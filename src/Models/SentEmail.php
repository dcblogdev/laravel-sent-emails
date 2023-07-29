<?php

namespace Dcblogdev\LaravelSentEmails\Models;

use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    protected $guarded = [];

    public function getBodyAttribute($compressed) {
        return config('sentemails.compressBody')
                ? gzinflate(base64_decode($compressed))
                : $compressed;
    }

    public function setBodyAttribute($raw) {
        $body = config('sentemails.compressBody')
                ? base64_encode(gzdeflate($raw, 9))
                : $raw;
        $this->attributes['body'] = $body;
    }
}
