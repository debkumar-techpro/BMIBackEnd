<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Classes;
use App\Models\Programme;
use App\Models\ProgrammeUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'unique_id'             => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            $file_name = "";
            if ($request->hasFile('cover_img')) {
                $file_name = strtotime(date("Y-m-d h:i:s")) . "-" . $request->file('cover_img')->getClientOriginalName();
                $request->file('cover_img')->move('system', $file_name);
            }
            $programme                        = new Programme();
            $programme->name                  = $request->input('name');
            $programme->programme_description = $request->input('programme_description');
            $programme->cover_img             = $file_name;
            $programme->save();

            $programmeUpload = ProgrammeUpload::where(
                [
                    'unique_id' => $request->input('unique_id'),
                ])
                ->update(
                    [
                        'programme_id' => $programme->id,
                    ]);

            return response()->json([
                "message"   => 'Data store successfully inserted',
                "programme" => $programme,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data not inserted',
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
            'type'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            $file_name = "";
            if ($request->hasFile('img')) {
                $file_name = strtotime(date("Y-m-d h:i:s")) . "-" . $request->file('img')->getClientOriginalName();
                $request->file('img')->move('system', $file_name);
            }
            $programmeUpload            = new ProgrammeUpload();
            $programmeUpload->unique_id = $request->input('unique_id');
            $programmeUpload->link      = $request->input('link');
            $programmeUpload->type      = $request->input('type');
            $programmeUpload->name      = $file_name;
            $programmeUpload->save();

            return response()->json([
                "message" => 'Data store successfully inserted',
                "file"    => [
                    "id"   => $programmeUpload->id,
                    "path" => 'system',
                    "name" => $programmeUpload->name,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data not inserted',
                'error'   => $e->getMessage(),
            ], 400);
        }
    }
    public function store_class(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year'         => 'required|integer',
            'name'         => 'nullable|string',
            'programme_id' => 'required|integer',
            'start_date'   => 'required',
            'end_date'     => 'required',

        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            $classes               = new Classes();
            $classes->year         = $request->input('year');
            $classes->name         = $request->input('name');
            $classes->programme_id = $request->input('programme_id');
            $classes->start_date   = $request->input('start_date');
            $classes->end_date     = $request->input('end_date');
            $classes->save();

            return response()->json([
                "message" => 'Data store successfully inserted',
                "year"    => $classes,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data not inserted',
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
    public function show_class($programme_id)
    {
        $data      = ['programme_id' => $programme_id];
        $validator = Validator::make($data, [
            'programme_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }

        $classes = Classes::select('id', 'year', 'name', 'programme_id')
            ->where(['programme_id' => $programme_id])
            ->paginate();
        return response()->json($classes);
    }
    public function show_module($programme_id, $class_id)
    {
        $data = [
            'programme_id' => $programme_id,
            'class_id'     => $class_id,
        ];
        $validator = Validator::make($data, [
            'programme_id' => 'required|integer',
            'class_id'     => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }

        $modules = Programme::select('*')
            ->where(['id' => $programme_id])
            ->with('module.courses')
            ->whereHas('module', function ($query) use ($class_id) {
                $query->where(['class_id' => $class_id]);
            })
            ->paginate();
        return response()->json($modules);
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
    public function destroy($programme)
    {
        //
    }
    public function destroy_file($files)
    {
        $data      = ['files' => $files];
        $validator = Validator::make($data, [
            'files' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }

        $files = ProgrammeUpload::find($files);
        if (@$files->name) {
            $filename = public_path() . '/system/' . $files->name;
            File::delete($filename);
        }
        $files->delete();

        return response()->json($files);

    }
}
