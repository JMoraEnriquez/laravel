<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class sendRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a POST request';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
            'param1' => 'value1',
            'param2' => 'value2',
        ];

        $batchSize = 1000;
        $pauseTime = 1;

        for ($i = 1; $i <= 100000; $i++) {
            try {
                $response = Http::post("https://atomic.incfile.com/fakepost", $data);
                if($response->status() != 200)
                    Log::error('POST REQUEST FAILED: ' . $response->status());
            } catch (\Exception $exception) {
                Log::error('POST REQUEST: ' . $exception->getMessage());
            }

            if ($i % $batchSize === 0) {
                sleep($pauseTime);
            }
        }
    }
}
