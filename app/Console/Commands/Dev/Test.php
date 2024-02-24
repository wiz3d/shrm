<?php

namespace App\Console\Commands\Dev;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Mime\Exception\LogicException;

class Test extends Command
{
    /**
     * The name and
     * signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dev Command to create client';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "start dev test script";



        echo "finsh dev test script";
    }
}
