<?php 

namespace App\Traits;

trait Badgeable
{
    public function checkBadge($request, $type, $required_value)
    {
        debug("badgeable");
        if($badge = request()->user()->checkBadge($type,$required_value) ){
                    debug("badgeable");

            $request->session()->flash('badge', $badge);
            if($next_badge = $badge->next()){
                        debug("badgeable session flash");

                $request->session()->flash('next_badge', $next_badge);
            }
        }
    }
}