<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller{

    public function upload(Request $request){

         if ($request->hasFile('image')) {
             $image = $request->file('image');

             $destinationPath = 'uploads';
             $imageName = time() . '.' . $image->getClientOriginalExtension();
             $image->move($destinationPath, $imageName);

             $img = Image::make(public_path($destinationPath . '/' . $imageName));
             $img->resize(300, 200);
             $img->save();

             return response()->json(['message' => 'Imagem enviada com sucesso', 'path' => $destinationPath . '/' . $imageName]);
         }
        

        return response()->json(['message' => 'Nenhuma imagem foi enviada'], 400);
    }
}

