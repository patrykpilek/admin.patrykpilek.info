<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['title', 'slug', 'meta_description'];

    /**
     * Get the posts for the category.
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the route key for the mode
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
