<?php namespace Microffice\Core\Tests;

use Microffice\Core\NotFoundException;
use Microffice\Core\ValidationException;
use Mockery as m;

class CoreEloquentModelResourceTraitTest extends CoreBaseTest {

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

    }
    
    /**
     * Tear the test environment down.
     */
    public function tearDown()
    {
        m::close();
        parent::tearDown();
        
    }

    /**
     * Test EloquentModelResourceTrait setModelName().
     *
     * @test
     */
    public function testEloquentModelResourceTraitSetModelNameMethod()
    {
        $object = new Stubs\ResourceStubClass();

        $property = $this->getPrivateProperty( 'Microffice\Core\Tests\Stubs\ResourceStubClass', 'modelName');
        $modelName = $property->getValue($object);
        $this->assertTrue($modelName == 'ResourceStubModel');

        $property = $this->getPrivateProperty( 'Microffice\Core\Tests\Stubs\ResourceStubClass', 'modelFullName');
        $modelFullName = $property->getValue($object);
        $this->assertTrue($modelFullName == 'Microffice\Core\Tests\Stubs\ResourceStubModel');
    }

    /**
     * Test EloquentModelResourceTrait getResourceName().
     *
     * @test
     */
    public function testEloquentModelResourceTraitGetResourceNameMethod()
    {
        $object = new Stubs\ResourceStubClass();

        $method = $this->getPrivateMethod( 'Microffice\Core\Tests\Stubs\ResourceStubClass', 'getResourceName');
        $result = $method->invokeArgs( $object, array() );
        //var_dump($result);
        $this->assertTrue($result == 'resource stub');
    }

    /**
     * Test index should raise exception on empty table.
     *
     * @test
     */
    public function testIndexShouldRaiseExceptionOnEmptyTable()
    {
        $this->migrate('testbench_mysql');

        Stubs\ResourceStubModel::destroy(1);/**/

        try {
            $response = \Resource::index();
        }
        catch(NotFoundException $expected) {
            return;
        }
        $this->fail('NotFoundException was not raised');/**/
    }

    /**
     * Test index should return Collection.
     *
     * @test
     */
    public function testIndexShouldReturnCollection()
    {
        $this->migrate('testbench_mysql');

        // Fill the stubTable
        Stubs\ResourceStubModel::create(['stubValue' => 'toto']);
        $response = \Resource::index();

        $this->assertInstanceOf("Illuminate\Database\Eloquent\Collection", $response);
        $this->assertCount(2, $response);
    }

    /**
     * Test store should validate data
     *
     * @test
     */
    public function testStoreShouldValidateData()
    {
        $this->migrate('testbench_mysql');

        // Stub data
        $input = ['stubValue' => 'toto'];
        // Our Validator should "make" itself
        \Validator::shouldReceive('make')
            ->once()
            ->with(
                $input,
                // Stub rules
                ['stubValue' => 'required|min:1|max:5'])
            ->andReturn(m::self());
        // We test the data against the rules
        // !!! the validate() method uses fails() for Validation
        \Validator::shouldReceive('fails')
            ->once()
            ->andReturn(false);
        // Since the Validator is suposed to pass
        // the messages() method should NOT be called
        \Validator::shouldNotReceive('messages');/**/

        \Resource::store($input);
    }

    /**
     * Test store should add new Model to DB
     *
     * @test
     */
    public function testStoreShouldAddNewModelToDB()
    {
        $this->migrate('testbench_mysql');

        $response = \Resource::index();
        $this->assertCount(1, $response);

        \Resource::store(['stubValue' => 'toto']);
        $response = \Resource::index();
        $this->assertCount(2, $response);
    }

    /**
     * Test store should return Model
     *
     * @test
     */
    public function testStoreShouldReturnModel()
    {
        $this->migrate('testbench_mysql', false);

        $response = \Resource::store(['stubValue' => 'toto']);

        $this->assertInstanceOf("Illuminate\Database\Eloquent\Model", $response);
        $this->assertInstanceOf("Microffice\Core\Tests\Stubs\ResourceStubModel", $response);
    }

    /**
     * Test show should raise exception if non-existent id.
     *
     * @test
     */
    public function testShowShouldRaiseException()
    {
        $this->migrate('testbench_mysql');

        try {
            $response = \Resource::show(5);
        }
        catch(NotFoundException $expected) {
            return;
        }
        $this->fail('NotFoundException was not raised');/**/
    }

    /**
     * Test show should return Model.
     *
     * @test
     */
    public function testShowShouldReturnModel()
    {
        $this->migrate('testbench_mysql');

        // Fill the stubTable table
        Stubs\ResourceStubModel::create(['stubValue' => 'toto']);
        $response = \Resource::show(2);
        
        $this->assertInstanceOf("Microffice\Core\Tests\Stubs\ResourceStubModel", $response);
        $this->assertTrue($response['stubValue'] == 'toto');
    }

    /**
     * Test update should validate data
     *
     * @test
     */
    public function testUpdateShouldValidateData()
    {
        $this->migrate('testbench_mysql');

        // Stub data
        $input = ['stubValue' => 'tata'];
        // Our Validator should "make" itself
        \Validator::shouldReceive('make')
            ->once()
            ->with(
                $input,
                // Stub rules
                ['stubValue' => 'required|min:1|max:5'])
            ->andReturn(m::self());
        // We test the data against the rules
        // !!! the validate() method uses fails() for Validation
        \Validator::shouldReceive('fails')
            ->once()
            ->andReturn(false);
        // Since the Validator is suposed to pass
        // the messages() method should NOT be called
        \Validator::shouldNotReceive('messages');/**/

        \Resource::update(1, $input);
    }

    /**
     * Test update should raise exception if non-existent id.
     *
     * @test
     */
    public function testUpdateShouldRaiseException()
    {
        $this->migrate('testbench_mysql');

        try {
            $response = \Resource::update('abc', ['stubValue' => 'titi']);
        }
        catch(NotFoundException $expected) {
            return;
        }
        $this->fail('NotFoundException was not raised');/**/
    }

    /**
     * Test update should update data in DB
     *
     * @test
     */
    public function testUpdateShouldUpdateDB()
    {
        $this->migrate('testbench_mysql');

        $stubValue = 'tata';
        \Resource::update(1, ['stubValue' => $stubValue]);
        $response = \Resource::show(1);

        $this->assertTrue($response['stubValue'] == $stubValue);
    }

    /**
     * Test destroy should raise exception if non-existent id.
     *
     * @test
     */
    public function testDestroyShouldRaiseException()
    {
        $this->migrate('testbench_mysql');

        try {
            $response = \Resource::destroy('abc');
        }
        catch(NotFoundException $expected) {
            return;
        }
        $this->fail('NotFoundException was not raised');/**/
    }

    /**
     * Test destroy should erase resource from DB
     *
     * @test
     */
    public function testDestroyShouldEraseResourceFromDB()
    {
        $this->migrate('testbench_mysql');

        \Resource::store(['stubValue' => 'tutu']);
        $response = \Resource::index();
        $this->assertCount(2, $response);

        \Resource::destroy(2);
        $response = \Resource::index();
        $this->assertCount(1, $response);
    }

    /**
     * Test invalid data should raise exception
     *
     * @test
     */
    public function testValidateShouldRaiseExceptionOnInvalidData()
    {

        try {
            $object = new Stubs\ResourceStubClass();
            $method = $this->getPrivateMethod( 'Microffice\Core\Tests\Stubs\ResourceStubClass', 'validate');
            // stubValue length should be from 1 to 5 -> 6 should raise an exception
            $result = $method->invokeArgs( $object, [array('stubValue' => 'grrrrr')] );
        }
        catch(ValidationException $expected) {
            return;
        }
        $this->fail('ValidationException was not raised');/**/
    }

    /**
     * Test validate
     *
     * @test
     */
    public function testValidate()
    {
        $object = new Stubs\ResourceStubClass();
        $method = $this->getPrivateMethod( 'Microffice\Core\Tests\Stubs\ResourceStubClass', 'validate');

        $result = $method->invokeArgs( $object, [array('stubValue' => 'gr')] );
        $this->assertTrue($result);
    }
}