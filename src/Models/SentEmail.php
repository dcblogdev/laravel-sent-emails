<?php

namespace Dcblogdev\LaravelSentEmails\Models;

use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    protected $fillable = [
        'date',
        'from',
        'to',
        'cc',
        'bcc',
        'subject',
        'body'
    ];

    public function getBodyAttribute($compressed): string
    {
        return config('sentemails.compressBody')
                ? gzinflate(base64_decode($compressed))
                : $compressed;
    }

    public function setBodyAttribute($raw): void
    {
        $body = config('sentemails.compressBody')
                ? base64_encode(gzdeflate($raw, 9))
                : $raw;
        $this->attributes['body'] = $body;
    }
}
