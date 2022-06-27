<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Motorcycle extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'machine',
        'suspension_type',
        'transmission_type',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get table's vehicle
     */
    public function vehicle()
    {
        return $this->morphOne(Vehicle::class, 'attachable');
    }
}
