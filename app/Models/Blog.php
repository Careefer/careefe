<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'category_id',
                  'title',
                  'slug',
                  'image',
                  'type',
                  'content',
                  'status',
                  'meta_title',
                  'meta_keyword',
                  'meta_desc'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
               'deleted_at'
           ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the category for this model.
     *
     * @return App\Models\Category
     */
    

    public function category()
    {
        return $this->belongsTo('App\Models\BlogCategory','category_id','id');
    }

}
