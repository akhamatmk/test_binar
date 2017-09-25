<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ComunityRating extends Model
{
    use SoftDeletes;

    protected $table = 'comunity_rating';
    
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'comunity_id', 'user_id', 'Rating'
    ];
}