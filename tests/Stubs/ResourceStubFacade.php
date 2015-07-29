<?php namespace Microffice\Core\Tests\Stubs;

use Illuminate\Support\Facades\Facade;

/**
 * Resource Stub Facade
 *
 */ 
class ResourceStubFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'resource'; }
 
}