<?php

namespace Dcblogdev\LaravelSentEmails\Controllers;

use Citco\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Dcblogdev\LaravelSentEmails\Models\SentEmail;

class SentEmailsController extends BaseController
{
    public function index()
    {
        $emails = SentEmail::orderby('id', 'desc');

        if (request()->exists('date')) {
            $date = request('date');
            $from = request('from');
            $to = request('to');
            $subject = request('subject');

            if ($date !='') {
                $date = Carbon::parse($date)->format('Y-m-d');
                $emails->where('date', '=', $date);
            }

            if ($from !='') {
                $emails->where('from', 'like', "%$from%");
            }

            if ($to !='') {
                $emails->where('to', 'like', "%$to%");
            }

            if ($subject !='') {
                $emails->where('subject', 'like', "%$subject%");
            }
        }

        $emails = $emails->paginate(config('sentemails.perPage'));

        return view('sentemails::index', compact('emails'));
    }

    public function email($id) {
        $email = SentEmail::findOrFail($id);

        return view('sentemails::email', compact('email'));
    }

    public function body($id)
    {
        $email = SentEmail::findOrFail($id);
        return $email->body;
    }
}