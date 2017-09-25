<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use App\Models\Place;
use App\Models\PlaceVisit;
use Validator;
use App\Transformers\PlaceTransformer;

class PlaceController extends ApiController
{
	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function all(JWTAuth $JWTAuth)
    {
    	$data = [];
    	$place = Place::all();
    	$user =  $JWTAuth->parseToken()->authenticate();
		if($place) {
			$manager = new \League\Fractal\Manager();
			$manager->parseIncludes(['address', 'featured_users', 'featured_users.user', 'photos', 'photos.user']);
			$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
			$resource = new Fractal\Resource\Collection($place, new PlaceTransformer($user->id));
			$data =  $manager->createData($resource)->toArray();
		}

		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
    }

    public function checkin(JWTAuth $JWTAuth)
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

		$place = Place::where("id", $this->request->get('place_id'))->first();

		if(!$place) {
			return $this->response()->error('Place not Found', 404);
		}

    	$user =  $JWTAuth->parseToken()->authenticate();
    	$PlaceVisit = PlaceVisit::where('user_id', $user);
    	if(! $PlaceVisit){
    		$PlaceVisit->user_id = $user->id;
    		$PlaceVisit->place_id = $this->request->get('place_id');

    		if(! $PlaceVisit->save()) {
				return $this->response()->error('Failed Check IN', 400);
    		}
    	}
    
		$token = $JWTAuth->fromUser($user);
		return $this->response()->success((object)[], ['meta.token' => $token]);	
    }
}