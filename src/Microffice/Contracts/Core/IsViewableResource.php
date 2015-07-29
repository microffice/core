<?php namespace Microffice\Contracts\Core;

interface IsViewableResource extends IsResource {
    
    /**
    * Display a form to create a new Unit.
    *
    * @return Illuminate\View
    */
    public function create();
    
    /**
    * Display a form to edit an existing Unit.
    *
    * @param int $id
    * @return Illuminate\View
    */
    public function edit($id);
}