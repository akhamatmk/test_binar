<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlacePhoto extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'place_id', 'user_id', 'url'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
