<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CorpusSeeder;
use App\Services\WordSeeder;
use App\Services\AnnotationSeeder;
use App;

class ImportTrainingCorpus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corpus:import {postag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a corpus for the training';

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
        $postag = $this->argument('postag');
        $path_csv = base_path() . '/database/seeds/csvs/'. App::getLocale() . '/';
        $corpus_seeder = new CorpusSeeder($path_csv.$postag.'_corpus.csv');
        $corpus_seeder->run();
        $word_seeder = new WordSeeder($path_csv.$postag.'_words.csv');
        $word_seeder->run();
        $annotation_seeder = new AnnotationSeeder($path_csv.$postag.'_annotations.csv');
        $annotation_seeder->run();
    }
}
