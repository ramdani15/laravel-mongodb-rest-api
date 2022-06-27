<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'year',
        'color',
        'price',
        'stock',
        'attachable_type',
        'attachable_id',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Relation to attachable models.
     */
    public function attachable()
    {
        return $this->morphTo();
    }
}
