<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiKey;

class ResetApiKeyUsage extends Command
{
    protected $signature = 'apikeys:reset-usage';
    protected $description = 'Reset used_today cho tất cả API keys';

    public function handle()
    {
        ApiKey::query()->update(['used_today' => 0, 'active' => true]);
        $this->info('Đã reset api keys usage.');
    }
}
