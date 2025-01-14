<?php

namespace App\Http\Controllers;

use App\Models\FileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SftpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        //
        $allfiles = Storage::disk('ftp_uk')->allFiles('/');
        print_r($allfiles);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileUploads  $fileUploads
     * @return \Illuminate\Http\Response
     */
    public function show(FileUploads $fileUploads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileUploads  $fileUploads
     * @return \Illuminate\Http\Response
     */
    public function edit(FileUploads $fileUploads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileUploads  $fileUploads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileUploads $fileUploads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileUploads  $fileUploads
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileUploads $fileUploads)
    {
        //
    }
}
