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
            'from'        => $this->formatAddressField($message, 'From'),
            'to'          => $this->formatAddressField($message, 'To'),
            'cc'          => $this->formatAddressField($message, 'Cc'),
            'bcc'         => $this->formatAddressField($message, 'Bcc'),
            'subject'     => $message->getSubject(),
            'body'        => $message->getBody()
        ]);
    }

    /**
     * Format address strings for sender, to, cc, bcc.
     *
     * @param $message
     * @param $field
     * @return null|string
     */
    function formatAddressField($message, $field)
    {
        $headers = $message->getHeaders();

        if (!$headers->has($field)) {
            return null;
        }

        $mailboxes = $headers->get($field)->getFieldBodyModel();

        $strings = [];
        foreach ($mailboxes as $email => $name) {
            $mailboxStr = $email;
            if (null !== $name) {
                $mailboxStr = $name . ' <' . $mailboxStr . '>';
            }
            $strings[] = $mailboxStr;
        }
        return implode(', ', $strings);
    }
}
