<?php
namespace App\Http\Controllers\Api;
use App\Models\Cart;
use App\Models\User;
use App\Models\Image;
use App\Models\Order;
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
                $Ordertotal = Cart::where('customer_id', auth()->user()->id)->sum('productPrice');
                $sellerDelivery = User::where('id', $cart->seller_id)->first()->deliveryPrice;
                $cart['Ordertotal'] = $Ordertotal + $sellerDelivery;
                return $this->returnData(201, 'Cart Data Returned Successfully', $carts);
            }else{
                return $this->returnError(404, "There Are No Products in Cart as You Are a Seller");
            }
        }catch(\Exception $e){
            echo $e->getMessage();
             return $this->returnError(404, "There Are No Products in Cart");
        }
    }



    public function addToCart(Request $request, $seller_id)    // add to cart
    {
        try{
            $this->validate($request, [
                'section_id' => 'required',
                'product_id' => 'required',
                'without_id' => 'sometimes|nullable',
            ]);

            $seller = User::find($seller_id);
            $section = Section::find($request->section_id);

            if(auth()->user()->type != 'customer'){
                return $this->returnError(401, "You Can't make order as you aren't a Customer");
            }

            if(auth()->user()->isVerified == 0){
                return $this->returnError(401, "You Are Not Verified");
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

            $customer = Cart::where('customer_id', auth()->user()->id)->get();
            if($customer->isEmpty()){
                $cart = Cart::create([
                    'customer_id' => auth()->user()->id,
                    'seller_id' => $seller_id,
                    'product_id' => $request->product_id,
                    'spicy' => $request->spicy,
                    'without_id' => $without,
                    'quantity' => $request->quantity,
                    'productPrice' => (Product::where('id', $request->product_id)->first()->price) * ($request->quantity),
                ]);
            }else{
                $cart = $customer->first();
                if($seller_id == $cart->seller_id){
                    $cart = Cart::create([
                        'customer_id' => auth()->user()->id,
                        'seller_id' => $seller_id,
                        'product_id' => $request->product_id,
                        'spicy' => $request->spicy,
                        'without_id' => $without,
                        'quantity' => $request->quantity,
                        'productPrice' => (Product::where('id', $request->product_id)->first()->price) * ($request->quantity),
                    ]);
                }else{
                    return $this->returnError(400, "Clear Your Cart");
                }
            }
            // $cart['customer'] = User::where('id', auth()->user()->id)->get();
            // $cart['seller'] = User::where('id', $request->seller_id)->get();

            $products = Product::where('seller_id', $seller_id)->get();
            foreach($products as $product){
                if($product->section_id != $request->section_id){
                    return $this->returnError(404, "Section Not Aviiable");
                }
            }

            $random_id = strtoupper('#'.substr(str_shuffle(uniqid()),0,6));
            while(User::where('random_id', $random_id )->exists()){
                $random_id = strtoupper('#'.substr(str_shuffle(uniqid()),0,6));
            }

            if($seller->deliveryPrice){
                $order = Order::create([
                    'random_id' => $random_id,
                    'customer_id' => auth()->user()->id,
                    'seller_id' => $seller_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'productPrice' => (Product::where('id', $request->product_id)->first()->price) * ($request->quantity),
                    'deliveryPrice' => $seller->deliveryPrice,
                    'total' => (Product::where('id', $request->product_id)->first()->price * $request->quantity) + ($seller->deliveryPrice),
                ]);
            }else{
                $order = Order::create([
                    'random_id' => $random_id,
                    'customer_id' => auth()->user()->id,
                    'seller_id' => $seller_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'productPrice' => (Product::where('id', $request->product_id)->first()->price) * ($request->quantity),
                    'total' => (Product::where('id', $request->product_id)->first()->price) * ($request->quantity),
                ]);
            }

            $product = Product::where('id', $request->product_id)->get();

            if($request->without){
                foreach(explode(',',  $cart->without_id) as $without){
                    $without = Without::where('id', $without)->first();
                    $withouts[] = $without->name;
                }
            }else{
                $product['withouts'] = null;
                $cart->without_id = null;
            }
            return $this->returnData(201, 'Product Added To Cart Successfully', compact('product'));
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Add To Cart Failed");
        }
    }




    public function deleteProductFromCart(Request $request, $product_id)
    {
        try{
            $product = Product::find($product_id);
            if(auth()->user()->type != 'customer'){
                return $this->returnError(401, "You Can't delete product as you aren't a Customer");
            }
            if(!$product){
                return $this->returnError(404, "Product Not Found");
            }
            $cart = Cart::where('customer_id', auth()->user()->id)->where('product_id', $product_id)->first();
            $cart->delete();

            $order = Order::where('customer_id', auth()->user()->id)->where('product_id', $product_id)->first();
            $order->delete();

            $carts = Cart::where('customer_id', auth()->user()->id)->get();
            $carts['Ordertotal'] = Cart::where('customer_id', auth()->user()->id)->sum('productPrice');
            return $this->returnData(201, 'Product Removed From Cart Successfully', $carts);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "Remove From Cart Failed");
        }
    }

}
