<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marker;
use App\Models\Place;
use App\Models\PlaceVisit;
use App\Models\PlaceRating;
use App\Models\PlaceComment;
use App\Models\PlacePhoto;
use App\Models\ComunityPhoto;
use App\Models\Comunitie;
use App\Models\ComunityComment;
use App\Models\ComunityMember;
use App\Models\ComunityRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformer;
use App\Transformers\MarkerTransformer;
use App\Transformers\PlaceTransformer;
use App\Transformers\ComunityTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use DB;
use Validator;


class AuthController extends ApiController
{

	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function login(JWTAuth $JWTAuth)
    {
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'email' => array('required'),
    				'password' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}

		

		$user  = User::where('email', $this->request->get('email'))->first();

		if(! $user)
		{
			return $this->response()->error("User Not Found");
		}

		$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Item($user, new UserTransformer());
		$data =  $manager->createData($resource)->toArray();
		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
    }

    public function getMarker()
    {
    	$marker = Marker::get();

    	$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Collection($marker, new MarkerTransformer());
		$data =  $manager->createData($resource)->toArray();

		return $this->response()->success($data);
    }

    public function getFirstMarker($id)
    {
    	
    	$marker = Marker::find($id);

    	$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Item($marker, new MarkerTransformer());
		$data =  $manager->createData($resource)->toArray();
		return $this->response()->success($data);
    }

    public function getPut($id)
    {
    	
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'name' => array('required'),
    				'long' => array('required'),
    				'lat' => array('required'),
    				'type' => array('required'),
    				'spot_type' => array('required'),
    				'full_address' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}

    	$marker = Marker::find($id);

    	if($marker)
    	{
    		$marker->name = $this->request->get('name');
			$marker->long = $this->request->get('long;');
			$marker->lat = $this->request->get('lat');
			$marker->type = $this->request->get('type');
			$marker->spot_type = $this->request->get('spot_type');
			$marker->full_address = $this->request->get('full_address');

			$marker->save();	
    	}
    	


    	$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Item($marker, new MarkerTransformer());
		$data =  $manager->createData($resource)->toArray();
		return $this->response()->success($data);
    }

    public function add()
    {
    	
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'name' => array('required'),
    				'long' => array('required'),
    				'lat' => array('required'),
    				'type' => array('required'),
    				'spot_type' => array('required'),
    				'full_address' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}

    	$marker = new Marker();
		$marker->name = $this->request->get('name');
		$marker->long = $this->request->get('long;');
		$marker->lat = $this->request->get('lat');
		$marker->type = $this->request->get('type');
		$marker->spot_type = $this->request->get('spot_type');
		$marker->full_address = $this->request->get('full_address');

		$marker->save();	
    	


    	$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Item($marker, new MarkerTransformer());
		$data =  $manager->createData($resource)->toArray();
		return $this->response()->success($data);
    }

    public function delete($id)
    {
    	$marker = Marker::find($id);

    	if(! $marker)
    	{
			return $this->response()->error("Data Not Found");
    	}

		return $this->response()->success(['succes delete']);
    }

}