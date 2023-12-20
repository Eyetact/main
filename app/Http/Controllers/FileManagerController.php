<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\File;
use Auth;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('files.index');
    }

    public function viewfolder($id)
    {
        $folder = Folder::find($id);
        return view('files.folder', compact('folder'));
    }

    public function newFolder(Request $request)
    {
        if ($request->isMethod('post')) {
            $folder = new Folder();
            $folder->name = $request->name;
            $folder->user_id = Auth::user()->id;
            $folder->save();

            return redirect()->route('files')
                ->with('success', 'Folder has been added successfully');
            
        }
        return view('files.new-folder');
    }

    public function newFile(Request $request)
    {
        if ($request->isMethod('post')) {
            $file = new File();

            $value = $request->file;
            $ext = $value->getClientOriginalExtension();
            $file->type = $ext;

            $file_name = time() . mt_rand(1000, 9000) . '.' . $ext;
            $file->name = $file_name;

            $value->move(public_path('uploads/users/'), $file_name);
            $file->path = 'uploads/users/' . $file_name;
            $file->folder_id = $request->folder_id;
            $file->user_id = Auth::user()->id;
            $file->save();

            if ($request->folder_id != 0) {
                return redirect()->route('viewfolder',$request->folder_id)
                ->with('success', 'Fild has been added successfully');
            }


            return redirect()->route('files')
                ->with('success', 'Filde has been added successfully');
            
        }
        return view('files.new-file');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
