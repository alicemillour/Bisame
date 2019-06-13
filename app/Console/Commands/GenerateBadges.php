<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Artisan;
use App;

class GenerateBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:generate';

    /** @var \Illuminate\Foundation\Application  */
    protected $app;
    /** @var \Illuminate\Filesystem\Filesystem  */
    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the images of the badges';

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
        $original_fill = '#ffffff';
        $original_stroke = '#000000';
        $badges = [
            '1' => ['fill'=>'#ffffff', 'stroke'=>'#000000'],
            '2' => ['fill'=>'#ffffff', 'stroke'=>'#f8ea03'],
            '3' => ['fill'=>'#f8ea03', 'stroke'=>'#f8ea03'],
            '4' => ['fill'=>'#f8ea03', 'stroke'=>'#f89c03'],
            '5' => ['fill'=>'#f89c03', 'stroke'=>'#f89c03'],
            '6' => ['fill'=>'#f89c03', 'stroke'=>'#009000'],
            '7' => ['fill'=>'#009000', 'stroke'=>'#009000'],
            '8' => ['fill'=>'#005df5', 'stroke'=>'#005df5'],
            '9' => ['fill'=>'#aa6200', 'stroke'=>'#aa6200'],
            '10' => ['fill'=>'#000000', 'stroke'=>'#000000'],
            '11' => ['fill'=>'#ffffff', 'stroke'=>'#f61e1e'],
            '12' => ['fill'=>'#f61e1e', 'stroke'=>'#f61e1e'],
        ];
        $badges_directory = $this->app['path.public']. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'badges'.DIRECTORY_SEPARATOR;        
        $sources_directory = $this->app['path.public']. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'badges'. DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . App::getLocale();
        $files_source = $this->files->allFiles($sources_directory);
        foreach($files_source as $file_source){
            $source = $this->files->get($file_source);
            $name = $this->files->name($file_source);
            $tab = ['fill="'.$original_fill.'"','stroke="'.$original_stroke.'"'];
            foreach($badges as $key => $badge){
                $tabr = ['fill="'.$badge['fill'].'"','stroke="'.$badge['stroke'].'"'];
                $source_new_badge = str_replace($tab,$tabr,$source);
                $path_new_badge = $badges_directory.$name.'-'.$key.'.svg';
                $this->files->put($path_new_badge,$source_new_badge);
            }
        }
     
    }
    
}
