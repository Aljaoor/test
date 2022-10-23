<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\updateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User_information extends Controller
{
    use ApiRespose;

    public function update(updateRequest $request)
    {

        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        User::find(auth()->id())->update($data);
        return $this->apiResponse($data, 'the product has been updated', 201);


    }

    public function changePassword(Request $request)
    {
        if (Hash::check($request->old, auth()->user()->password)) {
            $user = auth()->user();
            $user->password = bcrypt($request->new);
            $user->update();
            return $this->apiResponse('null', "the password is changed", '200');
        } else
            return $this->apiResponse('null', "the password is wrong", '400');


    }

    public function products($id)
    {
        $category = User::whereId($id)->first();
        $apps = $category->products()->paginate(3);
        return $this->apiResponse($apps, 'ok', 200);


    }

    public function edite(updateRequest $request, $id)
    {

        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        User::find($id)->update($data);
        return $this->apiResponse($data, 'the product has been updated', 201);


    }

    public function delete($id)
    {

        $user = User::find($id);
        if ($user) {
            $user->delete($id);
            return $this->apiResponse('', 'user account has been deleted', 200);
        }
        return $this->apiResponse('', 'not found', 400);


    }


}
