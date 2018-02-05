<?php 

namespace App\Traits;

trait Badgeable
{
    public function checkBadge($request, $type, $required_value)
    {
        if($badge = request()->user()->checkBadge($type,$required_value) ){
            $request->session()->flash('badge', $badge);
            if($next_badge = $badge->next()){
                $request->session()->flash('next_badge', $next_badge);
            }
        }
    }
}