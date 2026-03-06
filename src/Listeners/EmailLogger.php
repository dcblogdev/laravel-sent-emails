<?php

namespace Dcblogdev\LaravelSentEmails\Listeners;

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Dcblogdev\LaravelSentEmails\Models\SentEmailAttachment;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Storage;

class EmailLogger
{
    public function handle(MessageSending $event): void
    {
        $message = $event->message;
        $body = $message->getHtmlBody() ?: $message->getTextBody() ?: '';
        $email = SentEmail::create([
            'date' => date('Y-m-d H:i:s'),
            'from' => $this->formatAddressField($message->getFrom()),
            'to' => $this->formatAddressField($message->getTo()),
            'cc' => $this->formatAddressField($message->getCc()),
            'bcc' => $this->formatAddressField($message->getBcc()),
            'subject' => $message->getSubject(),
            'body' => $body,
        ]);

        if (config('sentemails.storeAttachments')) {
            foreach ($message->getAttachments() as $attachment) {

                $path = 'sent-emails/'.now().'-'.$attachment->getFilename();
                Storage::disk(config('sentemails.storageDisk', 'local'))->put($path, $attachment->getBody());

                SentEmailAttachment::create([
                    'sent_email_id' => $email->id,
                    'filename' => $attachment->getFilename(),
                    'path' => $path,
                ]);
            }
        }
    }

    public function formatAddressField(array $field): ?string
    {
        $strings = [];

        foreach ($field as $row) {
            $email = $row->getAddress();
            $name = $row->getName();

            if ($name != '') {
                $email = $name.' <'.$email.'>';
            }

            $strings[] = $email;
        }

        return implode(', ', $strings);
    }
}
