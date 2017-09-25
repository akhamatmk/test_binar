<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use App\Models\PlacePhoto;
use App\Models\ComunityPhoto;
use Validator;
use App\Transformers\PlacePhotoTransformer;
use App\Transformers\CommunityPhotoTransformer;

class PhotosController extends ApiController
{
	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function placeAll(JWTAuth $JWTAuth)
    {
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'place_id' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}

        $place_id = $this->request->get('place_id');
        $PlacePhoto = PlacePhoto::where('place_id', $place_id)->get();
        $data = [];
        if($PlacePhoto) {
            $manager = new \League\Fractal\Manager();
            $manager->parseIncludes(['user']);
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($PlacePhoto, new PlacePhotoTransformer());
            $data =  $manager->createData($resource)->toArray();
        }
        
        $user =  $JWTAuth->parseToken()->authenticate();
        $token = $JWTAuth->fromUser($user);
        return $this->response()->success($data, ['meta.token' => $token]);
    }

    public function communityAll(JWTAuth $JWTAuth)
    {
        $validator = Validator::make(
            $this->request->all(),
            array(
                    'community_id' => array('required')
                )
        );

        if ($validator->fails())
        {
            return $this->response()->error($validator->errors()->all());
        }

        $community_id = $this->request->get('community_id');

        $PlacePhoto = ComunityPhoto::where('comunity_id', $community_id)->get();
        $data = [];
        if($PlacePhoto) {
            $manager = new \League\Fractal\Manager();
            $manager->parseIncludes(['user']);
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($PlacePhoto, new CommunityPhotoTransformer());
            $data =  $manager->createData($resource)->toArray();
        }
        
        $user =  $JWTAuth->parseToken()->authenticate();
        $token = $JWTAuth->fromUser($user);
        return $this->response()->success($data, ['meta.token' => $token]);
    }
}