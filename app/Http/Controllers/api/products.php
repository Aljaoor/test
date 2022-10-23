<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\product_user;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class   products extends Controller
{
    use ApiRespose;
    use ImageTrait;

    public function show()
    {
        $product = product::paginate(5);
        return $this->apiResponse($product, '0k', 200);

    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 'not created', 400);

        }
        $path = $this->uploadImage($request->image);

        $product = product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $path,
        ]);

        return $this->apiResponse($product, 'created', 201);


    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 'not update', 400);

        }


        $product = product::find($id);

        if (!$product) {
            return $this->apiResponse(null, 'The post Not Found', 404);
        }

        if ($request->hasFile('image')) {
            Storage::disk('public_uploads')->delete($product->id . '/' . $product->image);
            $file_name = $request->file('image')->getClientOriginalName();
            // move pic
            $request->image->move(public_path('product_Attachments/' . $product->id), $file_name);
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $request->file('image')->getClientOriginalName();
        $product->update();


        if ($product) {
            return $this->apiResponse($product, 'the product has been updated', 201);
        }

    }

    public function delete($id)
    {

        $product = product::find($id);

        if (!$product) {
            return $this->apiResponse(null, 'The product Not Found', 404);
        }

        $product->delete($id);

        if ($product) {
            return $this->apiResponse(null, 'The product deleted', 200);
        }

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
