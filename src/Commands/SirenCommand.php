<?php

namespace Mferrara\Siren\Commands;

use Illuminate\Console\Command;

class SirenCommand extends Command
{
    public $signature = 'server-siren:process';

    public $description = 'Collect and store server metrics';

    public function handle(): int
    {
        $this->comment('Starting metrics collection');

        $siren = new \Mferrara\Siren\Siren();
        $siren->process();

        $this->comment('All done');

        return self::SUCCESS;
    }
}
