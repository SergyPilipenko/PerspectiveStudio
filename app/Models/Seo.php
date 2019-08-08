<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    public $timestamps = false;

    protected $fillable = ['meta_title', 'meta_description', 'meta_keywords'];

    public function seo()
    {
        return $this->morphTo();
    }

    public function updateOrCreate($entity, $data)
    {
        $entity->seo ? $entity->seo()->update($data) : $entity->seo()->create($data);
    }
}
