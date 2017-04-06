<?php

namespace Tomgrohl\Laravel\Auth\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Hashing\Hasher;

class Hash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tomgrohl:hash:password {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash a password';

    /**
     * @var Hasher
     */
    protected $hasher;

    public function __construct(Hasher $hasher)
    {
        parent::__construct();
        $this->hasher = $hasher;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $password = $this->argument('password');

        $this->output->newLine(1);
        $this->output->writeln($this->hasher->make($password));
        $this->output->newLine(1);

        return 0;
    }
}

