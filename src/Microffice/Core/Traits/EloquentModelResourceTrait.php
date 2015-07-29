<?php namespace Microffice\Core\Traits;

use Microffice\Core\NotFoundException;
use Microffice\Core\ValidationException;

trait EloquentModelResourceTrait {

    /**
    * The current resource Model name.
    *
    * @var string
    */
    protected $modelName;

    /**
    * The current resource Model full name
    * aka namespaced name
    *
    * @var string
    */
    protected $modelFullName;

    /**
    * Return a listing of the resource.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function index()
    {
        $model = $this->modelFullName;
        $collection = $model::all();
        if($collection->isEmpty()) throw new NotFoundException('There Are No Resources Named "' . $this->getResourceName() . '" Yet');
        return $collection;
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param array $data
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function store($data)
    {
        $modelName = $this->modelFullName;
        if($this->validate($data, $modelName::$rules))
        {
            $model = $modelName::create($data);
            return $model;
        }
    }

    /**
    * Return the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function show($id)
    {
        $modelName = $this->modelFullName;
        $model = $modelName::find($id);
        if(!$model) throw new NotFoundException('There is no Resource with id = ' . $id . ' !');
        return $model;
    }

    /**
    * Update the specified resource in storage.
    *
    * @param int $id
    * @param array $data
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function update($id, $data)
    {
        $modelName = $this->modelFullName;
        if($this->validate($data, $modelName::$rules))
        {
            $model = $modelName::find($id);
            if(!$model) throw new NotFoundException('There is no Resource with id = ' . $id . ' !');
            $model->update($data);
            return $model;
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    * @return int (can be checked as boolean)
    */
    public function destroy($id)
    {
        $modelName = $this->modelFullName;
        $int = $modelName::destroy($id);
        if(!$int) throw new NotFoundException('There is no Resource with id = ' . $id . ' !');
        return $int;
    }

    /**
    * Validate data for resource.
    *
    * @param array $data
    * @param array $rules
    * @return boolean
    */
    protected function validate($data, $rules=false)
    {
        if(!$rules)
        {
            $modelName = $this->modelFullName;
            $rules = $modelName::$rules;
        }
        $validator = \Validator::make($data, $rules);
        if($validator->fails()) throw new ValidationException($validator);
        return true;
    }

    /**
    * Set $modelName and $modelFullName.
    *
    * @param string $modelName
    * @param string $namespace
    * @return void
    */
    protected function setModelName($modelName, $namespace)
    {
        $this->modelName = $modelName;
        $this->modelFullName = $namespace . "\\$modelName";
    }
    
    /**
    * Get Resource name from $modelName.
    *
    * @param string $modelName
    * @return $resourceName
    */
    protected function getResourceName()
    {
        // $modelName should end with 'Model'
        // if so, we trim it
        $end = strpos($this->modelName, 'Model');
        $length = strlen($this->modelName);
        $resourceName = ($end == $length - 5) ? substr($this->modelName, 0, $length - 5): $this->modelName;

        // Converting from camelCase to lowercase words
        // camelCase to Words from "ridgerunner" from StackOverflow (user 433790)
        $re = '/(?#! splitCamelCase Rev:20140412)
            # Split camelCase "words". Two global alternatives. Either g1of2:
              (?<=[a-z])      # Position is after a lowercase,
              (?=[A-Z])       # and before an uppercase letter.
            | (?<=[A-Z])      # Or g2of2; Position is after uppercase,
              (?=[A-Z][a-z])  # and before upper-then-lower case.
            /x';
        $resourceName = strtolower(join(' ', preg_split($re, $resourceName)));

        return $resourceName;
    }
}