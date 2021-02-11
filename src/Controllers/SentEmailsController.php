<?php

namespace Dcblogdev\LaravelSentEmails\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Dcblogdev\LaravelSentEmails\Models\SentEmail;

class SentEmailsController extends BaseController
{
    public function index()
    {
        $emails = SentEmail::orderby('id', 'desc')->paginate(config('sentemails.perPage'));

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