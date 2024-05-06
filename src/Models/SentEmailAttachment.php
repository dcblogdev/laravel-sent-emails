<?php

namespace Dcblogdev\LaravelSentEmails\Models;

use Dcblogdev\LaravelSentEmails\database\factories\SentEmailAttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentEmailAttachment extends Model
{
    use HasFactory;

    protected $table = 'sent_emails_attachments';

    protected $fillable = [
        'sent_email_id',
        'filename',
        'path'
    ];

    protected static function newFactory(): SentEmailAttachmentFactory
    {
        return SentEmailAttachmentFactory::new();
    }
}
