<?php

namespace App\Console\Commands;

use App\DocumentReviewReminderService;
use Illuminate\Console\Command;

class SendDocumentReviewReminders extends Command
{
    protected $signature = 'document-review:send-reminders';

    protected $description = 'Email document owners when an annual SOP/WI review is due';

    public function handle()
    {
        $result = app(DocumentReviewReminderService::class)->send();
        $this->info('Owners: '.$result['owners'].' | Documents: '.$result['documents'].' | Emails sent: '.$result['emails_sent'].' | Failed: '.$result['failed']);
        foreach ($result['failures'] as $failure) {
            $this->warn($failure['owner'].' ('.$failure['email'].'): '.$failure['reason']);
        }

        return 0;
    }
}
