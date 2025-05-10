<?php

namespace App\Http\Controllers\Api;

use App\Models\SupportTicket;
use App\Models\TicketComment;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class SupportController extends Controller
{
    // user tickets
    public function user_tickets($slug = null)
    {
        if($slug){
            return $this->ticket_detail($slug);
        }
        // $tickets = Auth::user()->tickets()->orderByDesc('status')->limit(100)->get();
        $tickets = SupportTicket::whereUserId(Auth::id())->with('comments')->orderByDesc('status')->limit(100)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'User tickets fetched successfully',
            'data' => $tickets,
        ]);

    }

    // create ticket
    function create_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->all(),
            ], 422);
        }


        $ticket = Auth::user()->tickets()->save(new SupportTicket([
            'ticket' => getTrx(10),
            'status' => 2,
            'subject' => $request->subject,
        ]));

        $ticket->comments()->save(new TicketComment([
            'comment' => $request->message,
        ]));
        // Send EMail?
        return response()->json([
            'status' => 'success',
            'message' => 'Ticket created successfully',
            'data' => $ticket,
        ],201);
    }

    // ticket detail
    function ticket_detail($slug)
    {
        $ticket = Auth::user()->tickets()->with(['comments'])->whereTicket($slug)->first();

        if(!$ticket){
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket Not Found'
            ],404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Ticket detail fetched successfully',
            'data' => $ticket,
        ]);
    }

    // user comment
    public function user_comment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->all(),
            ], 422);
        }


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

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket comment sent successfully',
            "data" => [
                'comment' => $request->comment,
                'ticket' => $ticket
            ]
        ],201);
    }

}
