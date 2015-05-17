<?php namespace Microffice\Core;

interface ViewableResourceInterface extends ModelResourceInterface {
    
    /**
    * Display a form to create a new Unit.
    *
    * @return Response
    */
    public function create();
    
    /**
    * Display a form to edit an existing Unit.
    *
    * @param int $id
    * @return Response
    */
    public function edit($id);
}