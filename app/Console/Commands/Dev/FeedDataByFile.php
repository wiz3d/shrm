<?php

namespace App\Console\Commands\Dev;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Mime\Exception\LogicException;
use App\Helpers\FeedHelper;

class FeedDataByFile extends Command
{
    /**
     * The name and
     * signature of the console command.
     *
     * @var string
     */
        protected $signature = 'data:feed-by-file {type} {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Feed Data By File';

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
        try {
            echo "start import data from raw file.\n";

            $type = $this->argument('type');
            if (!in_array($type, FeedHelper::AVAILABLE_FILE_TYPES)) {
                throw new \Exception("a file type:{$type} doesn't support");
            }

            $fileName = $this->argument('filename');

            $feedHelper = app()->make(FeedHelper::class);
            $feedHelper->ImportDataByFile($type, $fileName);

            echo "succes finish imort data from file {$fileName}.\n";
        } catch (\Throwable $e) {
            echo "{$e->getMessage()}";
        }
    }
}
