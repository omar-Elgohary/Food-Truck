<?php
namespace App\Http\Controllers\Api;
use App\Models\Image;
use App\Models\Product;
use App\Models\WithOut;
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
            $products = Product::all();
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
                    return $this->returnError(400, "U Can't Add Product as U aren't A Seller");
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
}
