<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;
use App\User;

class Login extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Log a user.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  \App\Models\User  $user
     * @return void
     */
    public function connectUser(Browser $browser, User $user)
    {
        $browser->type('log', $user->username)
                ->type('password', "secret")
                ->press('Se connecter');
    }  
}
