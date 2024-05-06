<?php

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Dcblogdev\LaravelSentEmails\Models\SentEmailAttachment;

test('can see emails inbox', function () {
    $this->get(route('sentemails.index'))->assertOk();
});

test('can see email', function () {
    $email = SentEmail::factory()->create();

    $this->get(route('sentemails.email', $email))->assertOk();
});

test('can see email body', function () {
    $email = SentEmail::factory()->create();

    $this->get(route('sentemails.body', $email))->assertOk();
});

test('can download attachment', function () {

    $filename = 'testfile.pdf';
    $path = storage_path('app/public/testfile.pdf');

    file_put_contents($filename, 'Test file content.');

    $attachment = SentEmailAttachment::factory()->create([
        'filename' => $filename,
        'path' => $path,
    ]);

    $this->get(route('sentemails.downloadAttachment', $attachment->id))->assertDownload($filename);

    unlink($filename);
});