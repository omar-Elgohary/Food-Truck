<?php
namespace App\Http\Controllers\Api;
use App\Models\Cart;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Section;
use App\Models\Without;
use Illuminate\Http\Request;
use App\Models\ProductQuantites;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class CartController extends Controller
{
    use ApiResponseTrait;
 

    public function getCustomerCart(Request $request)
    {
        try{
            if(auth()->user()->type == 'customer'){
                $carts = Cart::where('customer_id', auth()->user()->id)->get();
                
                foreach($carts as $cart){
                    $cart['quantity'] = Cart::where('product_id', $cart->product_id)->first()->quantity;
                    $cart['product'] = Product::where('id', $cart->product_id)->get();
                    $cart['images'] = Image::where('product_id', $cart->product_id)->get();
                    // $cart['total'] =  Cart::where('product_id', $cart->product_id)->sum('productPrice');
                }
                $cart['Ordertotal'] = Cart::where('customer_id', auth()->user()->id)->sum('productPrice');
                return $this->returnData(201, 'Cart Data Returned Successfully', $carts);
            }else{
                return $this->returnError(404, "There Are No Products in Cart as You Are a Seller");
            }
        }catch(\Exception $e){
            echo $e;
             return $this->returnError(404, "There Are No Products in Cart");
        }
    }



    public function addToCart(Request $request, $seller_id, $section_id)    // add to cart
    {
        try{
            $this->validate($request, [
                'product_id' => 'required',
                'without_id' => 'sometimes|nullable',
            ]);

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

            $order = Cart::create([
                'customer_id' => auth()->user()->id,
                'seller_id' => $seller_id,
                'product_id' => $request->product_id,
                'spicy' => $request->spicy,
                'without_id' => $without,
                'quantity' => $request->quantity,
                'productPrice' => (Product::where('id', $request->product_id)->first()->price) * ($request->quantity),
            ]);
            // $order['customer'] = User::where('id', auth()->user()->id)->get();
            // $order['seller'] = User::where('id', $request->seller_id)->get();
            $product = Product::where('id', $request->product_id)->get();

            if($request->without){
                foreach(explode(',',  $order->without_id) as $without){
                    $without = Without::where('id', $without)->first();
                    $withouts[] = $without->name;
                }
            }else{
                $product['withouts'] = null;
                $order->without_id = null;
            }
            return $this->returnData(201, 'Product Added To Cart Successfully', compact('product'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "Add To Cart Failed");
        }
    }




    public function confirmOrder(Request $request)
    {
        try{
            $cart = Cart::where('customer_id', auth()->user()->id)->get();
            foreach($cart as $c){
                $cart_id = $c->id;
                $cart['orderPrice'] = $c->orderPrice;
                $cart['delivery_price'] = $c->delivery_price;
                $cart['Total'] = $c->Total;
            } 

            return $this->returnData(201, 'Your Order Confirmed Successfully', compact('final_order', 'cart'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "Your Order Failed");
        }
    }

}
