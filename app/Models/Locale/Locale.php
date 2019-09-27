<?php

namespace App\Models\Locale;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model implements LocaleInterface
{
    public $timestamps = false;

    protected $fillable = ['code', 'name'];
}
