<?php

namespace CodeDatabase;

use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodeDatabase\Models\Category;
use CodePress\CodeDatabase\Repository\CategoryRepository;
use CodePress\CodeDatabase\Tests\AbstractTestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery as m;


class CategoryRepositoryTest extends AbstractTestCase  
{

    /**
     * @var CodePress\CodeDatabase\Repository\CategoryRepository
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->repository = new CategoryRepository();
        $this->createCategories();

    }

    public function test_can_model()
    {
        $this->assertEquals(Category::class , $this->repository->model());
    }

    public function test_can_makemodel()
    {
        $result = $this->repository->makeModel();
        $this->assertInstanceOf(Category::class , $result);

        $refrectionClass = new \ReflectionClass($this->repository);
        $refrectionProperty = $refrectionClass->getProperty('model');
        $refrectionProperty->setAccessible(true);
        $this->assertInstanceOf(Category::class , $refrectionProperty->getValue($this->repository));
    }

    public function test_can_make_model_in_constructor()
    {
        
        $refrectionClass = new \ReflectionClass($this->repository);
        $refrectionProperty = $refrectionClass->getProperty('model');
        $refrectionProperty->setAccessible(true);

        $this->assertInstanceOf(Category::class , $refrectionProperty->getValue($this->repository));

    }

    public function test_can_list_all_categories()
    {
        $result = $this->repository->all();
        $this->assertCount(3 , $result);
        $this->assertNotNull($result[0]->description);

        $result = $this->repository->all(['name']);
        $this->assertNull($result[0]->description);

    }

    public function test_can_create_categories()
    {
        $result = $this->repository->create([
            "name" => "Category 4",
            "description" => "Description 4"
        ]);

        $this->assertInstanceOf(Category::class , $result);

        $this->assertEquals('Category 4' , $result->name);
        $this->assertEquals('Description 4' , $result->description);

        $result = Category::find(4);
        $this->assertEquals('Category 4' , $result->name);
        $this->assertEquals('Description 4' , $result->description);

    }

    public function test_can_update_categories()
    {
        $result = $this->repository->update([
            "name" => "Category Atualizada",
            "description" => "Description Atualizada"
        ] , 1 );

        $this->assertInstanceOf(Category::class , $result);

        $this->assertEquals('Category Atualizada' , $result->name);
        $this->assertEquals('Description Atualizada' , $result->description);

        $result = Category::find(1);
        $this->assertEquals('Category Atualizada' , $result->name);
        $this->assertEquals('Description Atualizada' , $result->description);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_can_update_categories_fail()
    {
        $result = $this->repository->update([
            "name" => "Category Atualizada",
            "description" => "Description Atualizada"
        ] , 10 );
    }

    public function test_can_delete_categories()
    {
        $result = $this->repository->delete(1);
        $categories = Category::all();
        $this->assertCount(2, $categories);
        $this->assertEquals(true , $result);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_can_delete_categories_fail()
    {
        $this->repository->delete(10);
    }


    public function test_can_find_categories()
    {
        $category = $this->repository->find(1);
        
        $this->assertInstanceOf(Category::class , $category);

        $this->assertNotNull($category->name);
        $this->assertNotNull($category->description);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_can_find_categories_fail()
    {
        $this->repository->find(10);
    }

    public function test_can_find_with_columns_categories()
    {
        $category = $this->repository->find(1 , ['name'] );
        
        $this->assertInstanceOf(Category::class , $category);

        $this->assertNotNull($category->name);
        $this->assertNull($category->description);
    }

    public function test_can_findBy_categories()
    {
        $category = $this->repository->findBy('name' , 'Category 1');
        
        $this->assertInstanceOf(Category::class , $category[0]);

        $this->assertCount( 1 , $category);

        $this->assertEquals( 'Category 1' , $category[0]->name);
            
        $category = $this->repository->findBy('name' , 'Category 10');
        $this->assertCount( 0 , $category);

        $category = $this->repository->findBy('name' , 'Category 1' , ['name']);
        
        $this->assertInstanceOf(Category::class , $category[0]);

        $this->assertCount( 1 , $category);

        $this->assertEquals( 'Category 1' , $category[0]->name);
        $this->assertNull( $category[0]->description);
    }

    private function createCategories()
    {
        Category::create([
            "name" => "Category 1",
            "description" => "Description 1"
        ]);

        Category::create([
            "name" => "Category 2",
            "description" => "Description 2"
        ]);

        Category::create([
            "name" => "Category 3",
            "description" => "Description 3"
        ]);
    }

}
