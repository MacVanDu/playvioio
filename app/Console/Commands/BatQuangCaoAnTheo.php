<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class BatQuangCaoAnTheo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bat-quang-cao-an-theo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       Setting::where('key', 'bat_quang_cao')->update(['value' => '1']);

    }
}
