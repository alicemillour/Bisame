<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository 
{

    protected $post;

    public function __construct(Post $post)
	{
		$this->post = $post;
	}

	public function getPaginate($n)
	{
		return $this->post->with('user')
		->orderBy('posts.created_at', 'desc')
		->paginate($n);
	}

	private function queryWithUserAndTags()
	{
		return $this->post->with('user', 'tags')
		->orderBy('posts.created_at', 'desc');		
	}

	public function getWithUserAndTagsPaginate($n)
	{
		return $this->queryWithUserAndTags()->paginate($n);
	}

	public function getWithUserAndTagsForTagPaginate($tag, $n)
	{
		return $this->queryWithUserAndTags()
		->whereHas('tags', function($q) use ($tag)
		{
		  $q->where('tags.tag_url', $tag);
		})->paginate($n);
	}

	public function store($inputs)
	{
		$this->post->create($inputs);
	}

	public function destroy($id)
	{
		$this->post->findOrFail($id)->delete();
	}

}