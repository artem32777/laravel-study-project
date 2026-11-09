<?php

declare(strict_types=1);

namespace LaraN\News\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SendNewsEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $recipient,
        public string $title,
    ) {}

    public function handle(): void
    {
        Mail::raw("Новая новость: {$this->title}", function (Message $message): void {
            $message->to($this->recipient)
                ->subject('Новая новость');
        });
    }
}
