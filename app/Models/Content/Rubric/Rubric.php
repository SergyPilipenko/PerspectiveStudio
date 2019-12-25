<?php


namespace App\Models\Content\Rubric;

use App\Models\Catalog\Category;
use App\Search\Indexers\CategoriesIndexer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Rubric extends Model
{

    protected $table = 'rubrics';
    protected $fillable = ['title', 'description', 'position', 'slug'];
    protected static function boot()
    {
        parent::boot();

            static::created(function ($rubric) {
                File::put(public_path('SomethingChanged.txt'), 'changed');
            });
            static::updated(function ($rubric) {
                File::put(public_path('SomethingChanged.txt'), 'changed');
            });
            static::deleted(function ($rubric) {

                File::put(public_path('SomethingChanged.txt'), 'changed');
            });


    }
    public function groups()
    {
        return $this->hasMany(RubricGroup::class, 'rubric_id', 'id')->orderBy('position', 'ASC');
    }

    public function scopeMenu($query)
    {
        return $query->where('show_in_menu', true)->with('groups')->orderBy('position', 'ASC');
    }
}
