<?php namespace Microffice\Core;

interface ModelResourceInterface extends ResourceInterface {
    
    /**
    * Validate data for resource.
    *
    * @param array $data
    * @return Response
    */
    public function validate($data);

    /**
    * Return a new resource instance.
    *
    * @param array $data
    * @return Response
    */
    public function instance();


}