<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Section;
use App\Models\Without;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Api\ApiResponseTrait;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function allProducts()
    {
        try{
            $products = Product::where('seller_id', auth()->user()->id)->with('section')->get();
            foreach($products as $product){
                $product->images = Image::where('product_id', $product->id)->get();
            }
            if($products->count() > 0){
                return $this->returnData(200, 'All Products get Successfully', $products);
            }else{
                return $this->returnError(400, 'There Is No Products');
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'All Products get Failed');
        }
    }




    public function getProduct(Request $request, $id)
    {
        try{
            $product = Product::find($id);
            if(!$product){
                return $this->returnError(400, "Product Doesn't Exist");
            }
            $product = Product::where('id', $id)->with('section', 'images')->first();
            $product['seller'] = User::where('id', $product->seller_id)->first();
            if($product){
                return $this->returnData(200, 'Product get Successfully', compact('product'));
            }else{
                return $this->returnError(400, "Product Doesn't Exist");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Product get Failed');
        }
    }






    public function addProduct(Request $request)
    {
        try {
            $request->validate([
                'images' => 'required',
                'section_id' => 'required',
                'name' => 'required',
                'price' => 'required',
                'calories' => 'required',
                'description' => 'required',
            ]);
            
            if(Auth::user()->type == 'seller'){
                if(Auth::user()->isVerified == 0){
                    return $this->returnError(400, 'Please Verify Your Account');
                }
                // $without = implode(',', $request->without_id);
                $product = Product::create([
                    'seller_id' => auth()->user()->id,
                    'section_id' => $request->section_id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'calories' => $request->calories,
                    'description' => $request->description,
                ]);
                $product['section'] = Section::find($request->section_id)->name;

                if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('assets/images/product/'), $name);
                    $name = asset('assets/images/product/'.$name);
                    Image::create([
                        'product_id' => $product->id,
                        'image' => $name,
                    ]);
                }  
            }
            $images = $product->images()->get();
            // foreach(explode(',',  $product->without_id) as $without){
            //     $without = Without::where('id', $without)->first();
            //     $withouts[] = $without->name;
            // }
                return $this->returnData(201, 'Product Created Successfully', compact('product', 'images'));
            }else{
                return $this->returnError(400, "U Can't Add Product as U aren't A Seller");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Product Created Failed');
        }
    }



    public function editProduct(Request $request, $id)
    {
        try {
            $request->validate([
                'section_id' => 'required',
                'name' => 'required',
                'price' => 'required',
                'calories' => 'required',
                'description' => 'required',
            ]);

            $product = Product::find($id);
            if($product){
                if(Auth::user()->type == 'seller'){
                    $product->update([
                        'seller_id' => auth()->user()->id,
                        'section_id' => $request->section_id,
                        'name' => $request->name,
                        'price' => $request->price,
                        'calories' => $request->calories,
                        'description' => $request->description,
                    ]);

                    if($request->hasFile('images')){
                        $product->images()->delete();
                        foreach($request->file('images') as $image){
                            $name = rand() . '.' . $image->getClientOriginalExtension();
                            $image->move(public_path('assets/images/product/'), $name);
                            $name = asset('assets/images/product/'.$name);
                            Image::create([
                                'product_id' => $product->id,
                                'image' => $name,
                            ]);
                        } 
                    }
                    $images = $product->images()->get();
                    return $this->returnData(201, 'Product Updated Successfully', compact('product', 'images'));
                }else{
                    return $this->returnError(400, "U Can't Edit Product as U aren't A Seller");
                }
            }else{
                return $this->returnError(400, "Product Doesn't Exists");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Product Updated Failed');
        }
    }




    public function deleteProduct($id)
    {
        try{
            $product = Product::find($id);
            if($product){
                $product->delete();            
                return $this->returnData(200, 'Product Deleted Successfully');
            }else{
                return $this->returnError(404, "Product Doesn't Exists");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Product Deleted Failed');
        }
    }




    public function getAllProductsSeller($seller_id)
    {
        try{
            $seller = User::find($seller_id);
            if($seller && $seller->type == 'seller'){
                $products = Product::where('seller_id', $seller_id)->with('section')->get();
                foreach($products as $product){
                    $product->images = Image::where('product_id', $product->id)->get();
                }
                return $this->returnData(200, 'Products Returned Successfully', $products);
            }else{
                return $this->returnError(400, "Seller Doesn't Exists");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Products Returned Failed');
        }
    }




    public function getSpecificeProductsSeller(Request $request, $seller_id, $section_id)
    {
        try{
            $seller = User::find($seller_id);
            $section = Section::find($section_id);
            if($seller && $seller->type == 'seller'){
                $products = Product::where('seller_id', $seller_id)->with('section')->get();
                foreach($products as $product){
                    $product->images = Image::where('product_id', $product->id)->get();
                }
                if($section){
                    $products = $products->where('section_id', $section_id)->all();
                    return $this->returnData(200, 'Products Returned Successfully', $products);
                }else{
                    return $this->returnError(400, "Section Doesn't Exists");
                }
                return $this->returnData(200, 'Products Returned Successfully', $products);
            }else{
                return $this->returnError(400, "Seller Doesn't Exists");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Products Returned Failed');
        }
    }
}
