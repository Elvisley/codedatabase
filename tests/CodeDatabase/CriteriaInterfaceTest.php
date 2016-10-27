<?php

namespace CodePress\CodeDatabase\Tests;

use CodePress\CodeDatabase\Contracts\RepositoryInterface;
use CodePress\CodeDatabase\Models\Category;
use CodePress\CodeDatabase\Tests\AbstractTestCase;
use Illuminate\Database\Query\Builder;
use Mockery as m;

class CriteriaInterfaceTest extends AbstractTestCase  
{

    public function test_should_apple()
    {
        $mockQueryBuilder = m::mock(Builder::class);
        $mockRepository = m::mock(RepositoryInterface::class);
        $mockModel = m::mock(Category::class);
        $mock = m::mock(CriteriaInterfaceTest::class);
        $mock->shouldReceive('apply')
            ->with($mockModel, $mockRepository)
            ->andReturn($mockQueryBuilder);

        $this->assertInstanceOf(Builder::class , $mock->apply($mockModel , $mockRepository));
    }

}
