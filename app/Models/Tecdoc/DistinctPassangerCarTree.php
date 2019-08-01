<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Awobaz\Compoships\Compoships;

class DistinctPassangerCarTree extends Model
{
    use Compoships;
    use NodeTrait{NodeTrait::newEloquentBuilder insteadof Compoships;}

}
