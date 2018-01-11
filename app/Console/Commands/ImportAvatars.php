<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Avatar;
use Artisan;

class ImportAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avatars:import';

    /** @var \Illuminate\Foundation\Application  */
    protected $app;
    /** @var \Illuminate\Filesystem\Filesystem  */
    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the avatars images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Application $app, Filesystem $files)
    {
        $this->app = $app;
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        Avatar::truncate();
        $avatars_directory = $this->app['path.public']. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'avatars';        
        $files_avatar = $this->files->allFiles($avatars_directory);
        foreach($files_avatar as $file){
            $name = $this->files->name($file);
            $extension = $this->files->extension($file);
            Avatar::firstOrCreate(['image'=> $name.'.'.$extension ]);
        }
     
    }
    
}
