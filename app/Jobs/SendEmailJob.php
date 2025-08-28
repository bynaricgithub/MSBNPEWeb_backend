<?php

namespace App\Jobs;

use App\Mail\SendGrievanceMail;
use App\Models\Sent_Emails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;

    protected $email;

    public function __construct($data, $email)
    {
        $this->data = $data;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->email;
        try {
            Log::info($email);
            $res = Mail::to($email)->send(new SendGrievanceMail($this->data));
            Log::info('Email sent Success');

            $emailRecord = Sent_Emails::where('email', $email)
                ->orderBy('id', 'desc')
                ->first();
            if ($emailRecord) {
                Sent_Emails::where('id', $emailRecord->id)->update(['status' => $res->getMessageId()]);
            }
        } catch (\Throwable $e) {
            Log::info($e);
            Log::info('error => '.$e->getMessage());

            $emailRecord = Sent_Emails::where('email', $email)
                ->orderBy('id', 'desc')
                ->first();
            if ($emailRecord) {
                Sent_Emails::where('id', $emailRecord->id)->update(['error' => $e]);
            }
        }
    }
}
