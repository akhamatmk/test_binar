<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ComunityPhoto extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'comunity_id', 'user_id', 'url'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}