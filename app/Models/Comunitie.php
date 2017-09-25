<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Comunitie extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'marker_id', 'phone', 'cover_image', 'name', 'info'
    ];

    public function photos()
    {
        return $this->hasMany(ComunityPhoto::class, 'comunity_id', 'id');
    }

    public function photosLimit()
    {
        return $this->hasMany(ComunityPhoto::class, 'comunity_id', 'id')->limit(5);
    }

    public function marker()
    {
        return $this->hasOne(Marker::class, 'id', 'marker_id');
    }

    public function featuredUser()
    {
        return $this->hasOne(ComunityFeaturedUser::class, 'comunity_id', 'id');
    }

    public function featuredUsers()
    {
        return $this->hasMany(ComunityFeaturedUser::class, 'comunity_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(ComunityMember::class, 'comunity_id', 'id');
    }

    public function member()
    {
        return $this->hasOne(ComunityMember::class, 'comunity_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(ComunityRating::class, 'comunity_id', 'id');
    }

    public function rating()
    {
        return $this->hasOne(ComunityRating::class, 'comunity_id', 'id');
    }

    public function ratingByUser($id)
    {
        $result = $this->hasMany(ComunityRating::class, 'comunity_id', 'id')
           ->where('user_id', $id)
           ->first();

       return $result;
    }

    public function avg() {
       $result = $this->hasMany(ComunityRating::class, 'comunity_id', 'id')
       ->select(DB::raw('avg(rating) average'))
       ->first();

       return $result->average;
    }

    public function getJoinByUser($id)
    {
        $result = $this->hasMany(ComunityMember::class, 'comunity_id', 'id')
       ->where('user_id', $id)
       ->first();

       return $result;
    }

}