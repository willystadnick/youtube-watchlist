<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Search;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    public function testVisible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Search)
                ->assertSee(env('APP_NAME'))
                ->assertVisible('@search')
                ->assertVisible('@day1')
                ->assertVisible('@day2')
                ->assertVisible('@day3')
                ->assertVisible('@day4')
                ->assertVisible('@day5')
                ->assertVisible('@day6')
                ->assertVisible('@day7')
                ->assertVisible('@submit');
        });
    }

    public function testSearch()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Search)
                ->type('@search', 'test')
                ->click('@submit')
                ->assertSee('Results')
                ->assertSee('Most used words');
        });
    }
}
