<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:show-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'configの確認表示';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->showByKey('app');
        $this->showByKey('services');
        $this->showByKey('mail');
        $this->showByKey('database');

        return 0;
    }

    private function showByKey($key)
    {
        $this->line($key);
        $this->line(json_encode(config($key), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
