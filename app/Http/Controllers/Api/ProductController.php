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
            $products = Product::where('user_id',  auth()->user()->id)->get();
            foreach($products as $product){
                $product->images = Image::where('product_id', $product->id)->get();
            }
            return $this->returnData(200, 'All Products get Successfully', $products);
            $products['images'] = Image::where('product_id', $product->id);
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
                'spicy' => 'nullable',
                'without_id' => 'nullable',
            ]);
            
            if(Auth::user()->type == 'seller'){
               $without = implode(',', $request->without_id) ;
                $product = Product::create([
                    'user_id' => auth()->user()->id,
                    'section_id' => $request->section_id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'calories' => $request->calories,
                    'description' => $request->description,
                    'spicy' => $request->spicy,
                    'without_id' => $without,
                ]);

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
           foreach(explode(',',  $product->without_id) as $without){
                $without = Without::where('id', $without)->first();
                $withouts[] = $without->name;
           }
                return $this->returnData(201, 'Product Created Successfully', compact('product','withouts', 'images'));
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
                'spicy' => 'nullable',
                'without_id' => 'nullable',
            ]);

            $product = Product::find($id);
            if($product){
                if(Auth::user()->type == 'seller'){
                $without = implode(',', $request->without_id) ;
                    $product->update([
                        'user_id' => auth()->user()->id,
                        'section_id' => $request->section_id,
                        'name' => $request->name,
                        'price' => $request->price,
                        'calories' => $request->calories,
                        'description' => $request->description,
                        'spicy' => $request->spicy,
                        'without_id' => $without,
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
                foreach(explode(',',  $product->without_id) as $without){
                    $without = Without::where('id', $without)->first();
                    $withouts[] = $without->name;
                }
                    return $this->returnData(201, 'Product Updated Successfully', compact('product', 'withouts', 'images'));
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




    public function getAllProductsSeller(Request $request, $seller_id)
    {
        try{
            $seller = User::find($seller_id);
            if($seller && $seller->type == 'seller'){
                $products = Product::where('user_id', $seller_id)->with('section')->get();
                foreach($products as $product){
                    $product->images = Image::where('product_id', $product->id)->get();

                    foreach(explode(',',  $product->without_id) as $without){
                        $without = Without::where('id', $product->without_id)->first();
                        $withouts[] = $without->name;
                    }
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
                $products = Product::where('user_id', $seller_id)->with('section')->get();
                foreach($products as $product){
                    $product->images = Image::where('product_id', $product->id)->get();
                }
                foreach(explode(',',  $product->without_id) as $without){
                    $without = Without::where('id', $without)->first();
                    $withouts[] = $without->name;
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
