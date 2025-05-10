<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // Newsletter
    public function newsletter()
    {
        $nls = Newsletter::orderByDesc('id')->get();

        return view('admin.newsletter.index', compact('nls'));
    }

    public function add_newsletter()
    {
        return view('admin.newsletter.add');
    }

    public function send_newsletter(Request $request)
    {
        // save to db
        $nl = new Newsletter;
        $nl->user_emails = $request->user_emails ?? 0;
        $nl->other_emails = $request->other_emails;
        $nl->subject = $request->subject;
        $nl->content = $request->content;
        $nl->date = $request->date;
        $nl->status = 2;
        $nl->save();

        return to_route('admin.newsletter')->withSuccess('Email Scheduled Successfully');
    }

    public function edit_newsletter($id)
    {
        $nl = Newsletter::findOrFail($id);

        return view('admin.newsletter.view', compact('nl'));
    }

    public function update_newsletter(Request $request, $id)
    {
        // save to db
        $nl = Newsletter::findOrFail($id);
        $nl->user_emails = $request->user_emails ?? 0;
        $nl->other_emails = $request->other_emails;
        $nl->subject = $request->subject;
        $nl->content = $request->content;
        $nl->date = $request->date;
        $nl->status = 2;
        $nl->save();

        return to_route('admin.newsletter')->withSuccess('Email Updated Successfully');
    }

    public function delete_newsletter($id)
    {
        $nl = Newsletter::findOrFail($id);
        $nl->delete();

        return back()->withSuccess('Newsletter Deleted Successfully');
    }

    public function queue_emails()
    {

        $currentDateTime = Carbon::now(); // Get the current date and time
        $newsletters = Newsletter::where('status', 2)
            ->where('date', '<=', $currentDateTime)
            ->get();

        foreach ($newsletters as $newsletter) {
            $delayMinutes = rand(1, 5);
            // Update its status before sending emails
            $newsletter->status = 1;
            $newsletter->save();

            if ($newsletter->user_emails) {
                dispatch(new SendMailJob($newsletter))->delay(now()->addMinutes($delayMinutes));
            }

            $otherEmails = array_filter(array_map('trim', explode(',', $newsletter->other_emails)));
            foreach ($otherEmails as $email) {
                $delayMinutes = rand(1, 6);
                dispatch(new SendMailJob($newsletter, $email))->delay(now()->addMinutes($delayMinutes));
            }
        }
    }
}
