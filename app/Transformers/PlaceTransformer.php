<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Place;

class PlaceTransformer extends TransformerAbstract
{
    protected $user;

	protected $availableIncludes = [
        'address', 'featured_users', 'photos'
    ];

    function __construct($user = null)
    {
        $this->user = $user;
    }

    public function transform(Place $place)
    {
        return [
            'id'      			=> (int) $place->id,
            'name'      		=> (string) $place->name,
            'info'              => (string) $place->info,
            'cover_image' 	    => (string) $place->cover_image,
            'difficulty'        => (int) $place->difficulty,
            'checked_in'        => $this->checkIn($place),
            'phone' 	    	=> (string) $place->phone,
            'type' 	    		=> (int) $place->marker->type,
            'visitors_count'    => (int) count($place->visitors),
            'user_rating'		=> isset($place->rating->rating) ? (int) $place->rating->rating : 0,
            'avg_rating'		=> $place->avg(),
            'comments_count'	=> (int) count($place->comments),
            'photos_count' 	    => (int) count($place->photos), 
        ];

    }

    public function includeAddress(Place $place)
    {
        if(isset($place->marker)) {
        	return $this->item($place->marker, new MarkerDBTransformer);	
        }
        
    }

    public function includeFeaturedUsers(Place $place)
    {
        if(isset($place->featuredUsers)) {
        	return $this->collection($place->featuredUsers, new FeaturedUserTransformer);	
        }
        
    }

    public function includePhotos(Place $place)
    {
        if(isset($place->photos)) {
        	return $this->collection($place->photos, new PlacePhotoTransformer);	
        }
    }

    public function checkIn($place)
    {
        if($place->getVisitByUser($this->user))
           return true; 

        return false;
    }
}
