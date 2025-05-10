<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketComment;
use Auth;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $theme ;
    public function __construct()
    {
        switch (sys_setting('homepage_theme')) {
            case "theme1":
                $this->theme = "user.";
                break;
            case "theme2":
                $this->theme = "user.";
                break;
            case "theme3":
                $this->theme = "user3.";
                break;
            case "theme4":
                $this->theme = "user4.";
                break;
            default:
                $this->theme = "user.";
        }
    }
    //
    public function tickets()
    {
        $title = "All Support Tickets";
        $tickets = SupportTicket::orderByDesc('updated_at')->orderByDesc('status')->get();
        return view('admin.support.tickets', compact('title','tickets'));
    }
    public function unread_tickets()
    {
        $title = "Unread Tickets";
        $tickets = SupportTicket::whereStatus(2)->orderByDesc('id')->get();
        return view('admin.support.tickets', compact('title','tickets'));
    }
    // reply ticket
    public function reply_ticket($slug)
    {
        $ticket = SupportTicket::with(['comments'])->whereTicket($slug)->first();
        $title = 'Ticket #' . $ticket->ticket;
        return view('admin.support.details', compact('title', 'ticket'));
    }
    // save reply
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);
        $ticket = SupportTicket::findOrFail($id);
        $ticket->comments()->save(new TicketComment([
            'comment' => $request->comment,
            'type' => 1
        ]));

        $ticket->update([
            'status' => 3
        ]);
        // send email
        $subj = "Ticket #{$ticket->ticket} Replied by Admin";
        $mesg = $request->comment;
        general_email($ticket->user->email, $subj, $mesg);

        return back()->withSuccess('Ticket has been replied');
    }

    // delete ticket
    public function delete($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->comments()->delete();
        $ticket->delete();
        return redirect()->back()->withSuccess('Ticket has been deleted');
    }

    // user tickets
    public function user_tickets()
    {
        $tickets = Auth::user()->tickets()->orderByDesc('updated_at')->limit(20)->get();
        return view($this->theme.'ticket.index', compact('tickets'));
    }

    function create_ticket(Request $request){
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required',
        ]);

        $ticket = Auth::user()->tickets()->save(new SupportTicket([
            'ticket' => getTrx(10),
            'status' => 2,
            'subject' => $request->subject,
        ]));

        $ticket->comments()->save(new TicketComment([
            'comment' => $request->message,
        ]));

        // Send EMail?
        $subj = "Ticket #{$ticket->ticket} Opened by {$ticket->user->username}";
        $mesg = $request->message;
        general_email(get_setting('email'), $subj, $mesg);

        return redirect()->route('user.ticket.detail', [slug($ticket->ticket)]);
    }

    function ticket_detail($slug){
        $ticket = Auth::user()->tickets()->with(['comments'])->whereTicket($slug)->first();
        return view($this->theme.'ticket.details', compact('ticket'));
    }
    public function user_comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|max:5000'
        ]);
        $ticket = SupportTicket::findOrFail($id);
        $ticket->comments()->save(new TicketComment([
            'comment' => $request->comment,
            'type' => 0
        ]));
        $ticket->update([
            'status' => 2
        ]);

        // send email
        $subj = "Ticket #{$ticket->ticket} Replied by {$ticket->user->username}";
        $mesg = $request->comment;
        general_email(get_setting('email'), $subj, $mesg);
        return back()->withSuccess('Ticket Comment sent successfully');
    }


    function testing12(Request $request){
        return "hey";
    }
}
