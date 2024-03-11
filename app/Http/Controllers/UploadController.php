<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use App\Models\RegisterFingerprint;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store (Request $request){
        if($request->hasFile(key:'fingerprint')){
            $file = $request->file(key:'fingerprint');
            $filename = $file->getClientOriginalName();
            $folder = uniqid()."-".now()->timestamp;
            $file->storeAs("fingerprints/register/".$folder, $filename);

            RegisterFingerprint::create([
                'folder' => $folder,
                'filename'=>$filename
            ]);
            return $folder;
        }
        return '';
    }

    public function storeLogin(Request $request){
        if($request->hasFile(key:'fingerprint')){
            $file = $request->file(key:'fingerprint');
            $filename = $file->getClientOriginalName();
            $folder = uniqid()."-".now()->timestamp;
            $file->storeAs("fingerprints/temp/".$folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename'=>$filename
            ]);
            return $folder;
        }
        return '';
    }
}
