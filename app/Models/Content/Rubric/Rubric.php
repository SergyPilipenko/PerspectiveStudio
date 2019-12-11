<?php


namespace App\Models\Content\Rubric;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $table = 'rubrics';
    protected $fillable = ['title', 'description', 'position', 'slug'];

    public function groups()
    {
        return $this->hasMany(RubricGroup::class, 'rubric_id', 'id');
    }
}
