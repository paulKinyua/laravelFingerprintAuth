<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use App\Models\RegisterFingerprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $file->storeAs("fingerprints/tmp/".$folder, $filename);
            
            //return uploaded file path
            $path = "C:/Users/HP/Documents/fingerprintAuthentication/storage/app/fingerprints/tmp/".$folder."/".$filename;
            return $path;
            
            
        }
        return '';
    }
}
