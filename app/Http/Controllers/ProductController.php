<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\ApiRespose;
use App\Models\product;
use App\Models\product_user;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiRespose;
    use ImageTrait;

    public function show()
    {
        $products = product::paginate(10);
        return view('products.products', compact('products'));
    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash('Error', 'هناك خطأ بالمعلومات ');
            return redirect()->route('products.show');

        }
        $path = $this->uploadImage($request->image);

        $product = product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $path,
        ]);

        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect()->route('products.show');

    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash('Error', ' لم يتم تعديل المنتج ');
            return back();
        }
        $path = $this->uploadImage($request->image);
        $product = product::findOrFail($request->pro_id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $path;
        $product->update();

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();

    }

    public function delete(Request $request)
    {
        $Products = product::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }


    public function assign(Request $request)
    {
        foreach ($request->users as $user) {
            foreach ($request->products as $product) {
                if (product_user::whereUserId($user)->whereProductId($product)->first()) {
                    return $this->apiResponse(null, 'a product has been assigned before', 400);
                }
                product_user::create([
                    'user_id' => $user,
                    'product_id' => $product,
                ]);

            }
        }
        return $this->apiResponse(null, 'product are assigned to users', 200);

    }

}
