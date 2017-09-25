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


class TestController extends ApiController
{

	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

	public function test(JWTAuth $JWTAuth)
	{
		$requestData = json_decode($this->request->data);
		$token_gg = $this->request->get('token_gg');
		$email = $this->request->get('email');
	
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'email' => array('required'),
    				'token_gg' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}

		$user  = User::where('email', $email)->first();
		if(! $user){
			$client = new \GuzzleHttp\Client(['http_errors' => false]);
			$res = $client->request('GET', 'https://gate.co.id/api/users/me', ['headers' => ['Authorization' => 'Bearer '.$token_gg]]);
			$response =  json_decode($res->getBody());
			if($res->getStatusCode() != 200) 
			{
				return $this->response()->error($response, $res->getStatusCode());
			}

			if($response->email != $email) 
			{
				return $this->response()->error("Email not same with user registration in gg_id");
			}
			
			$user = new User();
			$user->id_gg 	= $response->id;
			$user->password 	= Hash::make('secret');
			$user->url 	= $response->url;
			$user->email  = $response->email;
			$user->name = $response->name;
			$user->dob = $response->dob;
			$user->about = $response->about;
			$user->gender = $response->gender;
			$user->city = $response->city;
			$user->intersport_passport = $response->intersport_passport;
			$user->address = $response->address;
			$user->website = $response->website;
			$user->phone = $response->phone;
			$user->photo = $response->photo;
			$user->photo_thumbnail = $response->photo_thumbnail;
			$user->valid_identification = $response->valid_identification;
			$user->followers = $response->followers;
			$user->followees = $response->followees;
			$user->statuses = $response->statuses;
			$user->total_points = $response->total_points;
			$user->points = $response->points;
			$user->profession = $response->profession;
			$user->institution = $response->institution;
			$user->friends_count = $response->friends_count;
			$user->unread_notifications_count = $response->unread_notifications_count;
			$user->cover_image = $response->cover_image;
			$user->followers_count = $response->followers_count;
			//$user->social_connections = $response->social_connections;
			$user->is_official = $response->is_official;
			$user->is_community = $response->is_community;
			$user->is_email_verified = $response->is_email_verified;

			$user->save();
		} 

		$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Item($user, new UserTransformer());
		$data =  $manager->createData($resource)->toArray();
		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
	}

	public function detail(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$marker_id = $this->request->get('marker_id');
		$type = $this->request->get('type');
		$data = null;
		if($type == 1) {

			$place = Place::where('marker_id', $marker_id)->first();
			if($place) {
				$manager = new \League\Fractal\Manager();
				$manager->parseIncludes(['address', 'featured_users', 'featured_users.user', 'photos', 'photos.user']);
				$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
				$resource = new Fractal\Resource\Item($place, new PlaceTransformer($user->id));
				$data =  $manager->createData($resource)->toArray();
			}
		} else {
			$comunity = Comunitie::where('marker_id', $marker_id)->first();
			if($comunity) {
				$manager = new \League\Fractal\Manager();
				$manager->parseIncludes(['photos', 'address', 'featured_users', 'featured_users.user', 'photos.user']);
				$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
				$resource = new Fractal\Resource\Item($comunity, new ComunityTransformer($user->id));
				$data =  $manager->createData($resource)->toArray();
			}
		}

		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
	}

	public function long(JWTAuth $JWTAuth)
	{
		$long = $this->request->get('long');
		$lat = $this->request->get('lat');	
		$radius = $this->request->get('radius');	
		$radius += 5;

		$marker = DB::table('markers')
                     ->select(DB::raw('`id`, `long`, `lat`, `name`, `type`, `place_type`, `full_address`,
						(
							3959  * acos(
								cos(radians('.$lat.')) * cos(radians(`lat`)) * cos(
									radians(`LONG`) - radians('.$long.')
								) + sin(radians('.$lat.')) * sin(radians(`lat`))
							)
						) `distance`'))
                    ->having('distance', '<', $radius)
                    ->orderBy('distance', 'ASC')
                    ->get();


		$markerUser = DB::table('users')
                 ->select(DB::raw('`id` , `long`, `lat`, 3 AS type, name ,
					(
						3959  * acos(
							cos(radians('.$lat.')) * cos(radians(`lat`)) * cos(
								radians(`LONG`) - radians('.$long.')
							) + sin(radians('.$lat.')) * sin(radians(`lat`))
						)
					) `distance`'))
                ->having('distance', '<', $radius)
                ->get();

        $merger = array_merge($marker, $markerUser);



	    $manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
		$resource = new Fractal\Resource\Collection($merger, new MarkerTransformer());
		$data =  $manager->createData($resource)->toArray();

		return $this->response()->success($data);
	}

	public function insertMarkers(){
		ini_set ( 'max_execution_time', 1200); 
		//$marker = Marker::where('id', '>', 12)->where('type' , 1)->get();
		
		// $cover_image = ['', 'http://meetferrytan.com/examples/projam/place_cover1.jpg', 'http://meetferrytan.com/examples/projam/place_cover2.jpg', 'http://meetferrytan.com/examples/projam/place_cover2.jpg'];
		// $phone = ['', '082111212321', '021231321312312', '087213123131232'];
		// $name = ['', 'name 1', 'name 2', 'name 3'];
		// $d =1;
		// foreach ($marker as $key => $value) {
		// 	if($d  > 3)
		// 		$d = 1;

		// 	$new = new Place;
  //       	$new->marker_id = $value->id;  
  //       	$new->difficulty = $d;  
  //       	$new->visitor_count =  0;
  //       	$new->phone =  $phone[$d];
  //       	$new->cover_image =  $cover_image[$d];
  //       	$new->name =  $name[$d];
  //       	$new->info = 'buka jam 09 AM -12 PM';
  //       	$new->save();
        	
		// 	$d++;
		// }
		// return $marker;

	// 	$place = Place::where('id' , '>', 2)->get();
		$photo2 = [
			"http://meetferrytan.com/examples/projam/photo2.jpg",
			"http://meetferrytan.com/examples/projam/photo3.jpg",
			"http://meetferrytan.com/examples/projam/photo4.jpg",
			"http://meetferrytan.com/examples/projam/photo5.jpg",
			"http://meetferrytan.com/examples/projam/photo1.jpg",
			"http://meetferrytan.com/examples/projam/photo6.jpg",
			"http://meetferrytan.com/examples/projam/photo7.jpg"
		];
		

	// 	$p = 0;
	// 	$user = 2;
	// 	foreach ($place as $key => $value) {
			
	// 		foreach ($photo2 as $key1 => $value1) {
	// 			if($user == 2)
	// 			{
	// 				$user = 22;
	// 			} else {
	// 				$user = 2;
	// 			}

				
	// 			$PlacePhoto = new PlacePhoto;
	//         	$PlacePhoto->place_id = $value->id; 
	//         	$PlacePhoto->user_id = $user;
	//         	$PlacePhoto->url =	$value1;
	//         	$PlacePhoto->save();
	// 		}
			
 //        }
	// 	return $place;

		// $marker = Marker::where('id', '>', 12)->where('type' , 2)->get();
		// $cover_image = ['', 'http://meetferrytan.com/examples/projam/community_cover1.jpg', 'http://meetferrytan.com/examples/projam/community_cover2.jpg', 'http://meetferrytan.com/examples/projam/community_cover1.jpg'];
		// $phone = ['', '082111212321', '021231321312312', '087213123131232'];
		// $name = ['', 'name 1', 'name 2', 'name 3'];
		// $a=1;
		// foreach ($marker as $key => $value) {

		// 	if ($a > 3) {
		// 		$a = 1;
		// 	}

  //       	$Comunitie = new Comunitie;
  //       	$Comunitie->marker_id = $value->id; 
  //       	$Comunitie->phone = $phone[$a];
  //       	$Comunitie->cover_image = $cover_image[$a];
  //       	$Comunitie->name = $name[$a];
  //       	$Comunitie->info = "Buka dari jam 9 AM - 12 PM";
  //       	$Comunitie->save();
  //       	$a++;
  //       }

		// return $marker;

		$Comunitie = Comunitie::where('id', '>', 12)->get();
		// foreach ($Comunitie as $key => $value) {
		// 	$ComunityRating = new ComunityRating;
  //       	$ComunityRating->comunity_id = $value->id; 
  //       	$ComunityRating->user_id = 2;
  //       	$ComunityRating->Rating = 5;
  //       	$ComunityRating->save();

  //       	$ComunityRating = new ComunityRating;
  //       	$ComunityRating->comunity_id = $value->id; 
  //       	$ComunityRating->user_id = 22;
  //       	$ComunityRating->Rating = 5;
  //       	$ComunityRating->save();


  //       	$ComunityMember = new ComunityMember;
  //       	$ComunityMember->comunity_id = $value->id; 
  //       	$ComunityMember->user_id = 2;
  //       	$ComunityMember->save();

  //       	$ComunityMember = new ComunityMember;
  //       	$ComunityMember->comunity_id = $value->id; 
  //       	$ComunityMember->user_id = 22;
  //       	$ComunityMember->save();

			
		// 	$ComunityComment = new ComunityComment;
  //       	$ComunityComment->comunity_id = $value->id; 
  //       	$ComunityComment->user_id = 2; 
  //       	$ComunityComment->comment = "ini komen";
  //       	$ComunityComment->save();

  //       	$ComunityComment = new ComunityComment;
  //       	$ComunityComment->comunity_id = $value->id; 
  //       	$ComunityComment->user_id = 22; 
  //       	$ComunityComment->comment = "ini komen";
  //       	$ComunityComment->save();

		// }
$user =2;

		foreach ($Comunitie as $key => $value) {
			foreach ($photo2 as $key2 => $value2) {
				if($user == 2)
					$user = 22;
				else
					$user = 2;

				$ComunityPhoto = new ComunityPhoto;
        		$ComunityPhoto->comunity_id = $value->id; 
        		$ComunityPhoto->user_id = $user; 
        		$ComunityPhoto->url = $value2;
        		$ComunityPhoto->save();
			}
		}
		return $Comunitie;

	}


}