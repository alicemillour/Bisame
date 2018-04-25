<?php

namespace App\Traits;

trait Badgeable {

    public function checkBadge($request, $type, $required_value) {
        debug("dans Badgeable/checkBadge");
        debug($request->session());

        if ($badge = request()->user()->checkBadge($type, $required_value)) {
            debug("badgeable");
            debug($request->session());
            $request->session()->flash('badge', $badge);
            if ($next_badge = $badge->next()) {
                debug("badgeable session flash");

                $request->session()->flash('next_badge', $next_badge);
                debug($request->session());
            }
        }
        debug("keep next badge");
        $request->session()->keep('next_badge');
        $request->session()->keep('badge');
        debug($request->session());

    }

}
