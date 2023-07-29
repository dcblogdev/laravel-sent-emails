<?php

namespace Dcblogdev\LaravelSentEmails\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Dcblogdev\LaravelSentEmails\Models\SentEmail;

class EmailLogger
{
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        SentEmail::create([
            'date'        => date('Y-m-d H:i:s'),
            'from'        => $this->formatAddressField($message->getFrom()),
            'to'          => $this->formatAddressField($message->getTo()),
            'cc'          => $this->formatAddressField($message->getCc()),
            'bcc'         => $this->formatAddressField($message->getBcc()),
            'subject'     => $message->getSubject(),
            'body'        => $message->getHtmlBody(),
            'attachments' => count($message->getAttachments()),
        ]);
    }

    /**
     * Format address strings for from, to, cc, bcc.
     *
     * @param $field
     * @return null|string
     */
    function formatAddressField($field): ?string
    {
        $strings = [];
        foreach($field as $row) {
            $email = $row->getAddress();
            $name = $row->getName();
            if ($name !='') {
                $email = $name.' <'.$email.'>';
            }
            $strings[] = $email;
        }
        return implode(', ', $strings);
    }
}
