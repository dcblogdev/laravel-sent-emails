<?php

namespace Dcblogdev\LaravelSentEmails\Models;

use Dcblogdev\LaravelSentEmails\database\factories\SentEmailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SentEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'from',
        'to',
        'cc',
        'bcc',
        'subject',
        'body',
    ];

    protected static function newFactory(): SentEmailFactory
    {
        return SentEmailFactory::new();
    }

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

    public function attachments(): HasMany
    {
        return $this->hasMany(SentEmailAttachment::class);
    }

    public function scopeApplyFilters($query, Request $request)
    {
        $date = $request->input('date');
        $from = $request->input('from');
        $to = $request->input('to');
        $subject = $request->input('subject');

        $query->when($date, function ($query, $date) {
            $query->where('date', '=', Carbon::parse($date)->format('Y-m-d'));
        })
            ->when($from, function ($query, $from) {
                $query->where('from', 'like', "%$from%");
            })
            ->when($to, function ($query, $to) {
                $query->where('to', 'like', "%$to%");
            })
            ->when($subject, function ($query, $subject) {
                $query->where('subject', 'like', "%$subject%");
            });
    }
}
