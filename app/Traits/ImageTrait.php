<?php

namespace App\Traits;

trait ImageTrait
{
    public function uploadImage($image)
    {
        $logo = time() + random_int(0, 999) . '.' . $image->extension();
        $image->move(('images') . '/' . date('d-m-Y'), $logo);
        $temp = '/images/' . date('d-m-Y') . '/' . $logo;
        return $temp;
    }
}
