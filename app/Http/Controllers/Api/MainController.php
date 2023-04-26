<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\FoodType;

class MainController extends Controller
{
    use ApiResponseTrait;

    public function addFoodType(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            if(auth()->user()->type != 'seller'){
                return $this->returnError(400, "Doesn't a Seller");
            }

            $foodtype = FoodType::create([
                'name' => $request->name,
            ]);

            return $this->returnData(200, 'FoodType Created Successfully', $foodtype);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'FoodType Created Failed');
        }
    }
}
