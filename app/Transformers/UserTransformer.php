<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'        => (int) $user->id,
            'id_gg'     => $user->id_gg,
            'url'       => $user->url,
            'email'     => $user->email,
            'name'      => $user->name,
            'dob'       => $user->dob,
            'about'     => $user->about,
            'gender'    => $user->gender,
            'city'      => $user->city,
            'intersport_passport'   => $user->intersport_passport,
            'address'   => $user->address,
            'website'   => $user->website,
            'phone' => $user->phone,
            'photo' => $user->photo,
            'photo_thumbnail'   => $user->photo_thumbnail,
            'valid_identification'  => $user->valid_identification,
            'followers' => $user->followers,
            'followees' => $user->followees,
            'statuses'  => $user->statuses,
            'total_points'  => $user->total_points,
            'points'    => $user->points,
            'profession'    => $user->profession,
            'institution'   => $user->institution,
            'friends_count' => $user->friends_count,
            'unread_notifications_count'    => $user->unread_notifications_count,
            'cover_image'   => $user->cover_image,
            'followers_count'   => $user->followers_count,
            'social_connections'    => $user->social_connections,
            'is_official'   => $user->is_official,
            'is_community'  => $user->is_community,
            'is_email_verified' => $user->is_email_verified,
        ];
    }
}
