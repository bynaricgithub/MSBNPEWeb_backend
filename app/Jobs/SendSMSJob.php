<?php

namespace App\Jobs;

use App\Models\OtpVerify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    protected $template;

    public function __construct($details, $template)
    {
        $this->details = $details;
        $this->template = $template;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // $apiKey = urlencode('WYb3gsH8qH0-aHvaDjhoWMpLGJGijgl34Iz9yXil6F');
            $apiKey = urlencode('WYb3gsH8qH0-19D85XDlpVY9ZrabutuLKc5xNvbuIs');
            $numbers = $this->details['mobile'];
            $sender = urlencode('BYNRIC');

            $data = [
                'apikey' => $apiKey,
                'numbers' => $numbers,
                'sender' => $sender,
                'message' => $this->template,
            ];
            // Log::info('SMS data :' . $this->template);
            // Log::info('SMS data Encoded :' . json_encode($data['message']));
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            // Log::info('SMS Response :' . json_encode($response));
            OtpVerify::where('mobile', $numbers)
                ->where('otp', $this->details['otp'])
                ->update([
                    'status' => $response,
                ]);
        } catch (Throwable $e) {
            Log::info($e);
            $numbers = $this->details['mobile'];
            OtpVerify::where('mobile', $numbers)
                ->where('otp', $this->details['otp'])
                ->update([
                    'error' => $e->getMessage(),
                ]);
        }
    }
}
