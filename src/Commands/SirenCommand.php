<?php

namespace Mferrara\Siren\Commands;

use Illuminate\Console\Command;

class SirenCommand extends Command
{
    public $signature = 'server-siren';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
