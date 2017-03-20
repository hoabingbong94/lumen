<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Upload;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\File;

class UploadsController extends Controller
{
    protected $upload = '';

    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    public function uploads(Request $request){
        if ($request->isMethod('post'))
        {
            if($request->hasFile('name')){
                $file = $request->file('name');
                $fullName = $file->hashName();
                $destinationPath = "uploads/images/";
                $size = $file->getSize();
                $upload_success     =   $file->move($destinationPath, $fullName);
                if($upload_success)
                {
                    $uplodas = new Upload();
                    $uplodas->name = $fullName;
                    $uplodas->size = $size;
                    $uplodas->save();
                    return response()->json($uplodas,200);
                }
                else
                {
                    return response()->json("Not pound",400);
                }
            }
            else{
                return response()->json("Hacked By Not Pound");
            }
        }
    }
}