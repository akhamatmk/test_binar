<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class PlaceVisit extends Model
{
	use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'place_id', 'user_id'
    ];
}