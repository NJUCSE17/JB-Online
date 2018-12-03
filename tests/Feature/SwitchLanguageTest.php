<?php

namespace Tests\Feature;

use Tests\TestCase;

class SwitchLanguageTest extends TestCase
{
    /** @test */
    public function the_language_can_be_switched()
    {
        $response = $this->get('/lang/zh_CN');

        $response->assertSessionHas('locale', 'zh_CN');
    }
}
