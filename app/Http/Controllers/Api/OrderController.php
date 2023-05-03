<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Section;
use App\Models\Without;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function makeOrder(Request $request, $seller_id, $section_id)    // add to cart
    {
        try{
            $seller = User::find($seller_id);
            $section = Section::find($section_id);
            if(auth()->user()->type != 'customer'){
                return $this->returnError(401, "You Can't make order as you aren't a Customer");
            }

            if(!$seller || $seller->type != 'seller'){
                return $this->returnError(404, "Seller Not Found");
            }

            if(!$section){ 
                return $this->returnError(404, "Section Not Found");
            }
            $without = implode(',', $request->without_id) ;

            if($request->product_id == null){
                return $this->returnError(404, "Product Not Found");
            }
            $order = Order::create([
                'customer_id' => auth()->user()->id,
                'seller_id' => $seller_id,
                'section_id' => $section_id,
                'product_id' => $request->product_id,
                'spicy' => $request->spicy,
                'without_id' => $without
            ]);
            $order['customer'] = User::where('id', auth()->user()->id)->get();
            $order['seller'] = User::where('id', $request->seller_id)->get();
            $order['product'] = Product::where('id', $request->product_id)->get();

            if($request->without){
                foreach(explode(',',  $order->without_id) as $without){
                    $without = Without::where('id', $without)->first();
                    $withouts[] = $without->name;
                }
            }else{
                $withouts[] = null;
            }
            return $this->returnData(201, 'Make Order Successfully', compact('order', 'withouts'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "Make Order Failed");
        }
        
    }



    

}