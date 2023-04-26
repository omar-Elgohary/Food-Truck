<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
  
    



    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|string|min:6',
        ]);

        $token = auth()->guard('api')->attempt();

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }




    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'phone' => 'required|string|min:11|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($request->food_type_id == null)
        {
            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],
                ['type' => 'customer']
            ));  
        }else{
            $user = User::create(array_merge(
                ['name' => $request->name],
                ['phone' => $request->phone],
                ['password' => bcrypt($request->password)],
                ['type' => 'seller'],
                ['vehicle_name' => $request->vehicle_name],
                ['plate_num' => $request->plate_num],
                ['food_type_id' => $request->food_type_id],
                ['food_truck_licence' => $request->food_truck_licence],
                ['vehicle_image' => $request->vehicle_image],
                ['delivery' => $request->delivery],
            ));
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'status' =>200,
            'message' =>'User Successfully Registered',
            'token' => $token,
            'user' => $user
        ], 201);
    }


    


    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    


    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    



    public function userProfile() {
        return response()->json(auth()->user());
    }
    




    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}