<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use App\Models\Comunitie;
use App\Models\ComunityMember;
use Validator;
use App\Transformers\ComunityTransformer;

class ComunityController extends ApiController
{
	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function all(JWTAuth $JWTAuth)
    {
    	$data = [];
    	$user =  $JWTAuth->parseToken()->authenticate();
    	$comunity = Comunitie::all();
		if($comunity) {
			$manager = new \League\Fractal\Manager();
			$manager->parseIncludes(['photos', 'photos.user', 'address', 'featured_users', 'featured_users.user']);
			$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
			$resource = new Fractal\Resource\Collection($comunity, new ComunityTransformer($user->id));
			$data =  $manager->createData($resource)->toArray();
		}

		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
    }

    public function join(JWTAuth $JWTAuth)
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

		$Comunitie = Comunitie::where("id", $this->request->get('community_id'))->first();

		if(!$Comunitie) {
			return $this->response()->error('Community not Found', 404);
		}

    	$user =  $JWTAuth->parseToken()->authenticate();
    	$ComunityMember = ComunityMember::where('user_id', $user);
    	if(! $ComunityMember){
    		$ComunityMember->user_id = $user->id;
    		$ComunityMember->comunity_id = $this->request->get('community_id');

    		if(! $ComunityMember->save()) {
				return $this->response()->error('Failed Join', 400);
    		}
    	}
    
		$token = $JWTAuth->fromUser($user);
		return $this->response()->success((object)[], ['meta.token' => $token]);
    }
}