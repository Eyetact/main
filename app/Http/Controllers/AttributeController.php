<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Attribute::select('*'))
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = '<a class="btn btn-icon  btn-warning" href="' . route('attribute.edit', ['attribute' => $row->id]) . '"><i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>';                                                        ;
                    $btn = $btn . '&nbsp;&nbsp;<a class="btn btn-icon  btn-danger delete-attribute delete-attribute" data-id="'.$row->id.'" data-toggle="tooltip" title="" data-original-title="Delete"> <i class="fa fa-trash-o"></i> </a>';
                    return $btn;
                    

                    
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('attributes.list', ['blog' => new Attribute()]);
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
