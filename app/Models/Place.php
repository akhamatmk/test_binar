<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Place extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'marker_id', 'difficulty', 'visitor_count', 'phone', 'cover_image', 'name', 'info'
    ];

    public function marker()
    {
        return $this->hasOne(Marker::class, 'id', 'marker_id');
    }

    public function featuredUser()
    {
        return $this->hasOne(FeaturedUser::class, 'place_id', 'id');
    }

    public function featuredUsers()
    {
        return $this->hasMany(FeaturedUser::class, 'place_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(PlacePhoto::class, 'place_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(PlaceComment::class, 'place_id', 'id');
    }

    public function rating()
    {
        return $this->hasOne(PlaceRating::class, 'place_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(PlaceRating::class, 'place_id', 'id');
    }

    public function visitors()
    {
        return $this->hasMany(PlaceVisit::class, 'place_id', 'id');
    }

    public function visitor()
    {
        return $this->hasOne(PlaceVisit::class, 'place_id', 'id');
    }

    public function avg() {
       $result = $this->hasMany(PlaceRating::class, 'place_id', 'id')
       ->select(DB::raw('avg(rating) average'))
       ->first();

       return $result->average;
    }

    public function getVisitByUser($id)
    {
        $result = $this->hasMany(PlaceVisit::class, 'place_id', 'id')
       ->where('user_id', $id)
       ->first();

       return $result;
    }
}
