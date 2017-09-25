<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ComunityFeaturedUser;

class FeaturedUserComunityTransformer extends TransformerAbstract
{
	protected $availableIncludes = [
        'user'
    ];

    public function transform(ComunityFeaturedUser $FeaturedUser)
    {
        return [
            'id'        => (int) $FeaturedUser->id,
            'feature_date'        => $FeaturedUser->created_at->timestamp,
        ];
    }

    public function includeUser(ComunityFeaturedUser $FeaturedUser)
    {
        if(isset($FeaturedUser->user)) {
        	return $this->item($FeaturedUser->user, new UserTransformer);	
        }
        
    }
}
