<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_successfully_with_mobile_elements()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('mobileMenuToggle');
        $response->assertSee('mobileNavDrawer');
        $response->assertSee('spice-hero-slider');
        $response->assertSee('hero-can');
    }
}

