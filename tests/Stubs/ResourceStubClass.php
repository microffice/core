<?php namespace Microffice\Core\Tests\Stubs;

use Microffice\Contracts\Core\IsResource as ResourceContract;
use Microffice\Core\Traits\EloquentModelResourceTrait;


class ResourceStubClass implements ResourceContract {

    /**
     * Making a Validable Resource.
     *
     */
    use EloquentModelResourceTrait;

    public function __construct()
    {
        
        $this->setModelName('ResourceStubModel', __NAMESPACE__);
    }

}