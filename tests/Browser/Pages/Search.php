<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Search extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
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
            '@search' => 'input[name=search]',
            '@day1' => 'input[name=day1]',
            '@day2' => 'input[name=day2]',
            '@day3' => 'input[name=day3]',
            '@day4' => 'input[name=day4]',
            '@day5' => 'input[name=day5]',
            '@day6' => 'input[name=day6]',
            '@day7' => 'input[name=day7]',
            '@submit' => 'button[type=submit]',
        ];
    }
}
