<?php 

namespace App\Traits;

trait Badgeable
{
    public function checkBadge($request, $type, $number)
    {
        if($badge = request()->user()->checkBadge($type,$number) ){
            $request->session()->flash('badge', $badge);
            if($next_badge = $badge->next()){
                $request->session()->flash('next_badge', $next_badge);
            }
        }
    }
}