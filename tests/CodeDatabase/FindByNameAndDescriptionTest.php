<?php

namespace CodePress\CodeDatabase\Tests;

use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodeDatabase\Contracts\CriteriaInterface;
use CodePress\CodeDatabase\Criteria\FindByNameAndDescription;
use CodePress\CodeDatabase\Models\Category;
use CodePress\CodeDatabase\Repository\CategoryRepository;
use CodePress\CodeDatabase\Tests\AbstractTestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery as m;


class FindByNameAndDescriptionTest extends AbstractTestCase  
{

	 /**
     * @var CodePress\CodeDatabase\Repository\CategoryRepository
     */
    private $repository;

    /**
     * @var CodePress\CodeDatabase\Contracts\CriteriaInterface 
     */
    private $criteria;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $this->repository = new CategoryRepository();
        $this->criteria = new FindByNameAndDescription('Category 1','Description 1');
        $this->createCategories();

    }

    public function test_if_instanceOf_criteriaInterface()
    {
        $this->assertInstanceOf(CriteriaInterface::class , $this->criteria);
    }

    public function test_if_apply_returns_dquerybuild()
    {
    	$class = $this->repository->model();
    	$result = $this->criteria->apply(new $class, $this->repository);

    	$this->assertInstanceOf(Builder::class , $result);
    }

    public function test_if_apply_returns_data()
    {
    	$class = $this->repository->model();
    	$result = $this->criteria->apply(new $class, $this->repository)->get()->first();

    	$this->assertEquals('Category 1' , $result->name);
    	$this->assertEquals('Description 1' , $result->description);
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