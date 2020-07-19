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
                ->assertVisible('@submit');
        });
    }

    public function testSearch()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Search)
                ->type('@search', 'test')
                ->click('@submit')
                ->assertSee('Results');
        });
    }
}
