<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use SoftDeletes;
    use AuthenticableTrait;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'id_gg','password','url','email','name','dob','about','gender','city','intersport_passport','address','website','phone','photo','photo_thumbnail','valid_identification','followers','followees','statuses','total_points','points','profession','institution','friends_count','unread_notifications_count','cover_image','followers_count','social_connections','is_official','is_community','is_email_verified','long','lat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
