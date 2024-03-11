<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store (Request $request){
        if($request->hasFile(key:'fingerprint')){
            $file = $request->file(key:'fingerprint');
            $filename = $file->getClientOriginalName();
            $folder = uniqid()."-".now()->timestamp;
            $file->storeAs("fingerprints/tmp/".$folder, $filename);

            return $folder;
        }
        return '';
    }
}
