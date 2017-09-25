<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\FeaturedUser;

class FeaturedUserTransformer extends TransformerAbstract
{
	protected $availableIncludes = [
        'user'
    ];

    public function transform(FeaturedUser $FeaturedUser)
    {
        return [
            'id'        => (int) $FeaturedUser->id,
            'feature_date'        => $FeaturedUser->created_at->timestamp,
        ];
    }

    public function includeUser(FeaturedUser $FeaturedUser)
    {
        if(isset($FeaturedUser->user)) {
        	return $this->item($FeaturedUser->user, new UserTransformer);	
        }
        
    }
}
