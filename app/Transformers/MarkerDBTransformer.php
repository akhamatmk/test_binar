<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Marker;

class MarkerDBTransformer extends TransformerAbstract
{
    public function transform(Marker $marker)
    {
        return [
            'id'            => (int) $marker->id,
            'name'          => $marker->name,
            'long'          => (double) $marker->long,
            'lat'           => (double) $marker->lat,
            'type'          => (double) $marker->type,
            'spot_type'     => (int) $marker->place_type,
            'full_address'  => (string) $marker->full_address,
            
        ];
    }
}
