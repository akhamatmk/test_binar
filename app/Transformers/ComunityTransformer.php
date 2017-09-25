<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Comunitie;

class ComunityTransformer extends TransformerAbstract
{
    protected $user;

	protected $availableIncludes = [
        'photos', 'address', 'featured_users'
    ];

    function __construct($user = null)
    {
        $this->user = $user;
    }

    public function transform(Comunitie $comunity)
    {
        return [
            'id'                => (int) $comunity->id,
            'name'              => (string) $comunity->name,
            'info'              => (string) $comunity->info,
            'phone'             => (string) $comunity->phone,
            'type'              => (int) $comunity->marker->type,
            'cover_image'       => $comunity->cover_image,
            'joined'            => $this->joined($comunity),
            'members_count'     => (int) count($comunity->members),
            'user_rating'       => count($comunity->members),
            'avg_rating'        => $comunity->avg(),
            'photos_count'      => (int) count($comunity->photos),
        ];

    }

    public function includePhotos(Comunitie $comunity)
    {
        if(isset($comunity->photosLimit)) {
            return $this->collection($comunity->photosLimit, new ComunityPhotoTransformer);    
        }
    }

    public function includeAddress(Comunitie $comunity)
    {
        if(isset($comunity->marker)) {
            return $this->item($comunity->marker, new MarkerDBTransformer);    
        }
    }

    public function includeFeaturedUsers(Comunitie $comunity)
    {
        if(isset($comunity->featuredUsers)) {
            return $this->collection($comunity->featuredUsers, new FeaturedUserComunityTransformer);  
        }
    }

    public function joined($comunity)
    {
        if($comunity->getJoinByUser($this->user))
           return true; 

        return false;
    }
}
