<?php

namespace Dcblogdev\LaravelSentEmails\Controllers;

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Dcblogdev\LaravelSentEmails\Models\SentEmailAttachment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SentEmailsController
{
    public function index(Request $request): View
    {
        $emails = SentEmail::orderby('id', 'desc')
            ->applyFilters($request)
            ->paginate(config('sentemails.perPage'));

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

    public function downloadAttachment(string $id): BinaryFileResponse
    {
        $attachment = SentEmailAttachment::findOrFail($id);

        return response()->download(storage_path('app/'.$attachment->path), $attachment->filename);
    }
}
