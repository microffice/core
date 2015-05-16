<?php namespace Microffice\Units\Contracts;

interface ResourceRepository {

    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return Response
    */
    public function findById($id);
    
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function findAll();

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store($data);

    /**
    * Update the specified resource in storage.
    *
    * @param int $id
    * @return Response
    */
    public function update($id, $data);

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    * @return Response
    */
    public function destroy($id);


}