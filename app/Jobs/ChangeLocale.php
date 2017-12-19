<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Support\Facades\Request;
class ChangeLocale extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
    	if(request()->has('lang')){
    		$lang = request()->input('lang');
    		session()->put('locale', $lang);
    	}
        
    }
}
