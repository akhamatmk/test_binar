<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PlaceComment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'place_id', 'user_id', 'comment'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Likes()
    {
        return $this->hasMany(PlaceCommentLike::class, 'comment_id', 'id');
    }

    public function avg() {
       $result = $this->hasMany(PlaceCommentRating::class, 'comment_id', 'id')
       ->select(DB::raw('avg(rating) average'))
       ->first();

       return isset($result->average) ? (Float) $result->average : 0;
    }

}
