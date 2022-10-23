<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\product_user;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

class ProductUserController extends Controller
{

    public function assignProducts($id)
    {

        $products = product::get();
        return view('/products/assign_products')->with(['products' => $products, 'id' => $id]);
    }

    public function assign(Request $request)
    {

        $products = array_map('intval', explode(',', $request->products));

        foreach ($products as $product) {
            if (product_user::whereUserId($request->user_id)->whereProductId($product)->first()) {
                session()->flash('Error', 'تم تعيين هذا المنتج سابقا ');
                return back();            }
            product_user::create([
                'user_id' => $request->user_id,
                'product_id' => $product,
            ]);

        }

        session()->flash('Add', 'تم تعيين المنتجات بنجاح ');
        return back();
    }


    public function index()
    {
        return view('home');

    }
}
