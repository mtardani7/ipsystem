<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentReviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $owner;
    public $documents;

    public function __construct(array $owner, array $documents)
    {
        $this->owner = $owner;
        $this->documents = $documents;
    }

    public function build()
    {
        $documentCount = count($this->documents);
        if ($documentCount === 1) {
            $subject = '[IPSystem] Document Review Required - '.$this->documents[0]->DOCID;
        } elseif ($documentCount > 1) {
            $subject = '[IPSystem] Annual Document Review Required - '.$documentCount.' Documents';
        } else {
            $subject = '[IPSystem] Annual Document Review Required';
        }

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->view('mails.document_review_reminder')
            ->text('mails.document_review_reminder_plain')
            ->subject($subject)
            ->with([
                'reviewUrl' => url('/document-owner'),
                'ownerName' => trim((string) $this->owner['name']) ?: 'Pemilik Proses',
            ]);
    }
}
