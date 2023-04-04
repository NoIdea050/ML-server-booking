<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Storage;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Storage::all();
        return view('admin.pages.storage-management.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.storage-management.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input data to the form
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:storages',
            'type' => 'required|string|max:255',
            'cost_per_hour' => 'required|numeric|min:0|not_in:0',
        ]);
        // return $request->all();

        $data = New Storage();
        $data->title = $request->title;
        $data->type = $request->type;
        $data->cost_per_hour = $request->cost_per_hour;
        $data->save();

        if ($data) {
            return redirect()
                    ->back()
                    ->with('success', 'Data Added successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
        } 
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
        $data = Storage::find($id);
        return view('admin.pages.storage-management.edit', compact('data'));
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
        // Validate input data to the form
        $validated = $request->validate([
            // 'title' => 'required|max:255|unique:storages',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('storages', 'title')->ignore($id),
            ],
            'type' => 'required|string|max:255',
            'cost_per_hour' => 'required|numeric|min:0|not_in:0',
        ]);
        // return $request->all();

        $data = Storage::find($id);
        $data->title = $request->title;
        $data->type = $request->type;
        $data->cost_per_hour = $request->cost_per_hour;
        $data->save();

        if ($data) {
            return redirect()
                    ->back()
                    ->with('success', 'Data Updated successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Something Went Wrong, Try Again.');
        } 
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

    public function status_change($id)
    {
        $data = Storage::find($id);
        if ($data->status == 1) {
            $data->status = 0;
            $data->save();
            return redirect()->back()->with('success', 'Data Inactived successfully');
        } else {
            $data->status = 1;
            $data->save();
            return redirect()->back()->with('success', 'Data Actived successfully');
        }

        return redirect()->back()->with('error', 'Something Went Wrong, Try Again.');
    }
}
