<?php

namespace Dcblogdev\LaravelSentEmails\Controllers;

use Citco\Carbon;
use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Illuminate\Contracts\View\View;

class SentEmailsController
{
    public function index(): View
    {
        $emails = SentEmail::orderby('id', 'desc');

        if (request()->exists('date')) {
            $date = request('date');
            $from = request('from');
            $to = request('to');
            $subject = request('subject');

            if ($date != '') {
                $date = Carbon::parse($date)->format('Y-m-d');
                $emails->where('date', '=', $date);
            }

            if ($from != '') {
                $emails->where('from', 'like', "%$from%");
            }

            if ($to != '') {
                $emails->where('to', 'like', "%$to%");
            }

            if ($subject != '') {
                $emails->where('subject', 'like', "%$subject%");
            }
        }

        $emails = $emails->paginate(config('sentemails.perPage'));

        return view('sentemails::index', compact('emails'));
    }

    public function email(string $id): View
    {
        $email = SentEmail::findOrFail($id);

        return view('sentemails::email', compact('email'));
    }

    public function body(string $id): string
    {
        $email = SentEmail::findOrFail($id);

        return $email->body;
    }
}
