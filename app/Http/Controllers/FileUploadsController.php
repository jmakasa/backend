<?php

namespace App\Http\Controllers;

use App\Models\FileUploads;
use Illuminate\Http\Request;
use File;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class FileUploadsController extends Controller
{
    protected $filepath;
    protected $marketingPath;
    protected $akasa2206Path;

    public function __construct()
    {
        //   $this->middleware('auth', ['except' => ['getBlogsList']]);
        ini_set('memory_limit', '2048M');
        $this->marketingPath = Storage::disk('marketing_reviewsite')->getAdapter()->getPathPrefix();
        $this->filepath =[
            'ticket_threads_attachments'=> public_path(). "/ticket_threads_attachments/",
            'reviewsites_icon'=>  Storage::disk('marketing_reviewsite')->getAdapter()->getPathPrefix()."icon/",
            'product_review_image' => '',
           // 'product_review_image' => env("DOCDIR", "/akasa/www/akasa2206"). "/products/" . $partno . "/Web_Library/Reviews/",
        ];
    }

/**
 *  type  =  filesystem disk
 *  savePath location of disk
 * 
 */
    public function uploadFile($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'file' => 'required',
                    'diskType' => 'required',
                ],
                [
                    'diskType.required' => 'Disk Type is required.',
                    'file.required' => 'File is required.',
                ]
            );

            $rFiles = $request->file('file');
            $filename = $rFiles->getClientOriginalName();
            $disktype =$request->get('diskType');
            $folderPath = ($request->has('folderPath')?$request->get('folderPath') : "");

            //$request->file->storeAs('marketing_reviewsite', '20230724.jpg');
            logger()->debug(" uploadFile :  - $folderPath, $filename,$disktype");
            $uploaded= $request->file->storeAs($folderPath, $filename,$disktype);
            
            // logger()->error(" uploadFile : movepath - $movePath");
            // if (!File::isDirectory($movePath)) {
            //     File::makeDirectory($movePath, 0777, true, true);
            // }            
            // $uploaded = $rFiles->move($movePath, $filename);

            return response()->json($uploaded);
        } catch (ValidationException $ex) {
            logger()->error(" uploadFile " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

}
