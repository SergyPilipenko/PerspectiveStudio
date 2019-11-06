<?php


namespace App\Models\Content\Block;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'content_blocks';
    protected $fillable = ['title', 'identifier', 'content', 'enabled'];
    public $timestamps = false;
}
