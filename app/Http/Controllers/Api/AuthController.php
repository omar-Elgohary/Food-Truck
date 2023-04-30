<?php
namespace App\Http\Controllers\Api;
use Carbon\Carbon;
use App\Models\User;
use Twilio\Rest\Client;
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
        // auth()->setDefaultDriver('api');
    }


    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|string|min:6',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'status' =>200,
            'message' => 'Login Successfully',
            'token' => $token,
            'user' => auth()->user(),
        ]);
    }





    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($request->phone, "sms");

        if($request->food_type_id == null)
        {
            User::create(array_merge(
                ['name' => $request->name],
                ['phone' => $request->phone],
                ['password' => bcrypt($request->password)],
                ['type' => 'customer']
            ));  
        }else{
            User::create(array_merge(
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
            'message' => 'You Must Verify Your Mobile Number',
            'phone' => $request->phone,
            'token' => $token,
        ]);
    }




    protected function verify(Request $request)
    {
        try{
            $data = $request->validate([
                'phone' => ['required'],
                'verification_code' => ['required'],
            ]);

            /* Get credentials from .env */
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create(['code' => $data['verification_code'], 'to' => $data['phone']]);


            if ($verification->valid) {
                $user = tap(User::where('phone', $data['phone']))->update(['isVerified' => true]);
                /* Authenticate user */
                $user = Auth::login($user->first());
                return response()->json([
                    'status' => 200,
                    'phone' => $data['phone'],
                    'message' => 'Phone Number Verified Successfully',
                    'user' => $user,
                ]);  
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Invalid verification code entered!');
        }    
    }



    
    public function userProfile() 
    {
        return response()->json(auth()->user());
    }
    
    
    
    
    public function logout() 
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }




    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_at' => Carbon::parse($token['expires_at'])->toDateTimeString(),            
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}