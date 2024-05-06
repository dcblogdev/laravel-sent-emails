<?php

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Dcblogdev\LaravelSentEmails\Models\SentEmailAttachment;

test('can see emails inbox', function () {
    SentEmail::factory()->count(10)->create();
    $this->get(route('sentemails.index'))
        ->assertOk()
        ->assertViewHas('emails', function ($emails) {
            return $emails->count() === 10;
        }
        );
});

test('can filter emails by date', function () {

    SentEmail::factory()->create(['date' => '2023-10-20']);
    SentEmail::factory()->create(['date' => '2023-10-20']);
    SentEmail::factory()->create();

    $this->get(route('sentemails.index', ['date' => '2023-10-20']))
        ->assertOk()
        ->assertViewHas('emails', function ($emails) {
            return $emails->count() === 2;
        }
        );
});

test('can filter emails by from', function () {

    SentEmail::factory()->create(['from' => 'demo@demo.com']);
    SentEmail::factory()->create();

    $this->get(route('sentemails.index', ['from' => 'demo@demo.com']))
        ->assertOk()
        ->assertViewHas('emails', function ($emails) {
            return $emails->count() === 1;
        }
        );
});

test('can filter emails by to', function () {

    SentEmail::factory()->create(['to' => 'demo@demo.com']);
    SentEmail::factory()->create();

    $this->get(route('sentemails.index', ['to' => 'demo@demo.com']))
        ->assertOk()
        ->assertViewHas('emails', function ($emails) {
            return $emails->count() === 1;
        }
        );
});

test('can filter emails by subject', function () {

    SentEmail::factory()->create(['subject' => 'Demo']);
    SentEmail::factory()->create(['subject' => 'Other']);

    $this->get(route('sentemails.index', ['subject' => 'Demo']))
        ->assertOk()
        ->assertViewHas('emails', function ($emails) {
            return $emails->count() === 1;
        }
        );
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
})->skip('fails on GH actions, need to investigate why');
