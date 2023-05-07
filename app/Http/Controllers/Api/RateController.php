<?php
namespace App\Http\Controllers\Api;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class RateController extends Controller
{
    use ApiResponseTrait;

    public function rateSeller(Request $request, $seller_id)
    {
        try{
            $this->validate($request, [
                'rate' => 'required',
                'review' => 'required',
            ]);

            $seller = User::find($seller_id);
            if(!$seller || $seller->type != 'seller'){
                return $this->returnError(401, "Seller Not Found");
            }
            if(auth()->user()->type != 'customer'){
                return $this->returnError(401, "U Can't Rate This Seller");
            }
            $rates = Rate::where('seller_id', $seller_id)->where('customer_id', auth()->user()->id)->get();
            if($rates->isEmpty()){
                $rate = Rate::create([
                    'customer_id' => auth()->user()->id,
                    'seller_id' => $seller_id,
                    'rate' => $request->rate,
                    'review' => $request->review,
                ]);
            }else{
                return $this->returnError(404, "U Rated This Seller Before");
            }
            return $this->returnData(201, 'Rated Seller Done Successfully', $rate);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Rated Seller Failed");
    }
    }
}
