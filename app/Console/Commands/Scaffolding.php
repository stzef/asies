<?php

namespace asies\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Scaffolding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaffolding:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la estructura dearchivos base';

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
        $paths = [
            "/temp",
            "/evidencias",
            //"/evidencias/actividades",
        ];

        $bar = $this->output->createProgressBar(count($paths));

        foreach ($paths as $path) {
            $full_path = public_path() . $path;
            $this->info("path: $path");
            
            if(!File::exists($full_path)) {
                $result = File::makeDirectory($full_path, 0777);
                $this->info("Folder make: $result");
            }else{
                $this->info("This Folder Exists");
            }
            $bar->advance();
        }
        //

    }
}
