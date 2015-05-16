<?php namespace Microffice\Core;

interface ViewableResourceRepository extends ResourceRepository {
    
    /**
    * Display a form to create a new Unit.
    *
    * @param array $data
    * @return Response
    */
    public function create($data);
    
    /**
    * Display a form to edit an existing Unit.
    *
    * @param int $id
    * @return Response
    */
    public function edit($id);
}