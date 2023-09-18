<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Models\Download;
use App\Models\DownloadHistory;


class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $productFilePath;
    public function __construct()
    {
        $this->productFilePath = env('DOCDIR')."/products/";
        //   $this->middleware('auth', ['except' => ["index"]]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getById($locale, $id)
    {
        logger()->debug(" getdata " . var_export($id, true));
        return response()->json(Download::whereId($id)->first());
    }
    public function delete($locale, Request $request)
    {
        logger()->debug(" delete download " . var_export($request->all(), true));
    }

    public function update($locale, Request $request)
    {
        logger()->debug(" Download update - data " . var_export($request->all(), true));
        logger()->debug(" Download update - download file :" . var_export($request->downloadfile, true));
        //$request->file('file')->getSize();
        try {
            $this->validate($request, [
                'partno' => 'required',
                'ftype' => 'required',
                'subject' => 'required',
                'downloadfile' => "required"
            ],
            [
                'partno.required' => 'Partno is required.',
                'ftype.required' => 'File Type is required.',
                'subject.required' => 'Subject is required.',
                'downloadfile.required' => 'Please select a file to upload.',
            ]);
           // handle file upload -  downloadfile

            $docname = $request->downloadfile->getClientOriginalName();
            logger()->debug(" Download update - data " . var_export($request->downloadfile->getClientOriginalName(), true));
            $savePath = $this->productFilePath . $request->input('partno')."/Web_Library/Download/" ;
            $docdir = 'download/'.$request->input('ftype').'/';
            $fileSize = $request->file('downloadfile')->getSize();
            $request->downloadfile->move($savePath, $docname);
            
            $requestData = $request->all();
            $requestData['docname'] = $docname;
            $requestData['docdir'] = $docdir;
            $requestData['filetype'] = $request->downloadfile->getClientMimeType();
            $requestData['filesize'] = $fileSize;

            $download = Download::updateOrCreate(['id' => $requestData['id']]);
            $update = $download->update($requestData);
            logger()->debug(" Download update - download get data :" . var_export($download, true));
            return response()->json(['success' => $update]);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function listAll()
    {
        return response()->json(Download::findAll());
    }

    public function listByPartno($locale, $partno)
    {
        $dls  = Download::where("partno", $partno);
        $data = [];
        $data['total'] = $dls->count();
        $data['rows'] = $dls->get();
        return response()->json($data);
    }

    public function store($locale, Request $request)
    {
        logger()->debug(" Download store - data :" . var_export($request->all(), true));
        logger()->debug(" Download store - data :" . var_export($request->downloadfile, true));
        // store file 

        // insert into DB

        return response()->json(true);
    }

    public function addHistory($data)
    {
        $downloadHistory = (new DownloadHistory)
            ->validateAndFill($data);
        // ->setAttribute('status', Products::STATUS_ACTIVE)
        // ->setAttribute('type', Products::TYPE_MAIN);

        if ($downloadHistory->save()) {
            logger()->debug(" DownloadHistory - Store data : SAVED" . var_export($data, true));
            return true;
        } else {
            logger()->debug(" DownloadHistory - Store data : Failed" . var_export($data, true));
            return false;
        }
    }
}
