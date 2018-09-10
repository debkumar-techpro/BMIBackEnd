<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Programme;
use App\Models\ProgrammeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgrammeController extends BaseController
{
    public function __construct()
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programme = Programme::select('id', 'name', 'created_at')
            ->withCount('module')
            ->withCount('course')
            ->paginate(1);
        return response()->json($programme);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string',
            'cover_img'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'programme_description' => 'required|string',
            'unique_id'             => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            if ($request->hasFile('cover_img')) {
                $file_name = strtotime(date("Y-m-d h:i:s")) . "-" . $request->file('cover_img')->getClientOriginalName();
                $request->file('cover_img')->move('system', $file_name);
            }
            $programme            = new Programme();
            $programme->unique_id = $request->input('name');
            $programme->name      = $request->input('programme_description');
            $programme->cover_img = $file_name;
            $programme->save();

            $programmeUpload               = ProgrammeUpload::find(['unique_id' => $request->input('unique_id')]);
            $programmeUpload->programme_id = $programme->id;
            $programmeUpload->save();

            return response()->json('Data store successfully update');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Post not updated',
                'error'   => $e->getMessage(),
            ], 400);
        }
    }
    public function store_file(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required|string',
            'link'      => 'nullable|string',
            'img'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            if ($request->hasFile('img')) {
                $file_name = strtotime(date("Y-m-d h:i:s")) . "-" . $request->file('img')->getClientOriginalName();
                $request->file('img')->move('system', $file_name);
            }
            $programmeUpload            = new ProgrammeUpload();
            $programmeUpload->unique_id = $request->input('unique_id');
            $programmeUpload->name      = $request->input('link');
            $programmeUpload->name      = $file_name;
            $programmeUpload->save();

            return response()->json('Data store successfully update');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Post not updated',
                'error'   => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($programme_id)
    {
        $programme = Programme::find($programme_id);
        return response()->json($programme);
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
