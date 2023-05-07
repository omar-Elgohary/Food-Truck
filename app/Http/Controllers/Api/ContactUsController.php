<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    use ApiResponseTrait;

    public function sendContactUsMessage(Request $request)
    {
        try{
            $this->validate($request, [
                'name' => 'required',
                'phone' => 'required',
                'message' => 'required',
            ]);
            if(auth()->user()->type == 'customer'){
                $contactUsMesaage = ContactUs::create([
                    'customer_id' => auth()->user()->id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'message' => $request->message,
                ]);
            }else{
                return $this->returnError(404, "U Can't Send ContactUs Message as U Aren't Customer");
            }
            return $this->returnData(201, 'ContactUs Message Sent Successfully', $contactUsMesaage);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "ContactUs Message Sent Failed");
        }
    }
}
