<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Marker;

class MarkerTransformer extends TransformerAbstract
{
    public function transform($marker)
    {
        return [
            'id'            => (int) $marker->id,
            'name'          => $marker->name,
            'long'          => (double) $marker->long,
            'lat'           => (double) $marker->lat,
            'type'          => (double) $marker->type,
            'spot_type'    => isset($marker->place_type) ? (int) $marker->place_type : -1,
            'full_address'  => (string) isset($marker->full_address) ? $marker->full_address : "",
            
        ];
    }
}
