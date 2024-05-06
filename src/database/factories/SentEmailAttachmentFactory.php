<?php

namespace Dcblogdev\LaravelSentEmails\database\factories;

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Dcblogdev\LaravelSentEmails\Models\SentEmailAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SentEmailAttachmentFactory extends Factory
{
    protected $model = SentEmailAttachment::class;

    public function definition(): array
    {
        return [
            'sent_email_id' => SentEmail::factory(),
            'filename' => Str::random(10).'.txt',
            'path' => 'sent-emails/'.Str::random(10).'.txt',
        ];
    }
}
