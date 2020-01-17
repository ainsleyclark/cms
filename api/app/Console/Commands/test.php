<?php

namespace App\Console\Commands;

use App\Helpers;
use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command';

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
       $configPath = Helpers::themePath() . '/BasicTheme/config.json';

       if (file_exists($configPath)) {
           $configFile = json_decode(file_get_contents($configPath));

           dd($configFile);

       } else {
           //Throw error
       }
    }
}
