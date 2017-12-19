<?php 

namespace App\Repositories;

use App\Corpus;
use Illuminate\Support\Facades\DB;

class CorpusRepository {

	protected $corpus;

	public function __construct(Corpus $corpus)
	{
		$this->corpus = $corpus;
	}

	public function getAndPaginate($n)
	{
		return $this->corpus
			->orderBy('corpora.created_at', 'desc')
			->paginate($n);
	}
        
        public function get_current_unnanotated_corpus() {
        return ($this->corpus->select(DB::raw('id as id'))->where('is_training', '=', '0')->where('is_active','=','1')->first());
    }

}