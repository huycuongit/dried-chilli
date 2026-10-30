<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_category()
    {
        $category = Category::create([
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
        ]);
        
        $this->assertTrue($category->is_active);
    }

    public function test_category_can_have_a_parent()
    {
        $parent = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        $child = Category::create([
            'name' => 'Mobile', 
            'slug' => 'mobile',
            'parent_id' => $parent->id
        ]);

        $this->assertEquals($parent->id, $child->parent->id);
        $this->assertTrue($parent->children->contains($child));
    }
}
