<?php namespace Microffice\Core;

interface ResourceRepository {
    
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index();

    /**
    * Store a newly created resource in storage.
    *
    * @param array $data
    * @return Response
    */
    public function store($data);

    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return Response
    */
    public function show($id);

    /**
    * Update the specified resource in storage.
    *
    * @param int $id
    * @param array $data
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