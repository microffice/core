<?php namespace Microffice\Core\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;

/**
 * Core Resource Stub Model
 *
 */ 

class ResourceStubModel extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stubTable';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['stubValue'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Indicates if te model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;
 
    /**
    * Validation Rules
    * this is just a place for us to store these, you could
    * alternatively place them in your repository
    * @var array
    */
    public static $rules = array(
        'stubValue' => 'required|min:1|max:5'
    );

}