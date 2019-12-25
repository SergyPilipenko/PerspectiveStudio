<?php


namespace App\Models\Content\Rubric;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{

    protected $table = 'rubrics';
    protected $fillable = ['title', 'description', 'position', 'slug'];

    public function groups()
    {
        return $this->hasMany(RubricGroup::class, 'rubric_id', 'id')->orderBy('position', 'ASC');
    }

    public function scopeMenu($query)
    {
        return $query->where('show_in_menu', true)->with('groups')->orderBy('position', 'ASC');
    }
}
