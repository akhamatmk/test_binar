<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ComunityPhoto as photo;

class CommunityPhotoTransformer extends TransformerAbstract
{
	protected $availableIncludes = [
        'user'
    ];

    public function transform(photo $photo)
    {
        return [
            'id'            => (int) $photo->id,
            'user'          => $photo->user_id,
            'url'           => (string) $photo->url,
            'upload_date'   => $photo->created_at->timestamp,
            
        ];
    }

    public function includeUser(photo $photo)
    {
        if(isset($photo->user)) {
        	return $this->item($photo->user, new UserTransformer);	
        }
        
    }
}
