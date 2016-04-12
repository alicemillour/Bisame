<?php 

namespace App\Repositories;

use App\Models\Corpus;

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

}