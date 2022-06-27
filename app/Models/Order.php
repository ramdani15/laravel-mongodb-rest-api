<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'orderable_type',
        'orderable_id',
        'quantity',
        'total_price',
        'user_id',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Relation to orderable models.
     */
    public function orderable()
    {
        return $this->morphTo();
    }

    /**
     * Get the User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
