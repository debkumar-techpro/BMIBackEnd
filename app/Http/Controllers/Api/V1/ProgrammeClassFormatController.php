<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ClassFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgrammeClassFormatController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'class_id' => 'required|integer',
            'days'     => 'required|string',
            'schedule' => 'required|json',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            ClassFormat::updateOrCreate(
                [
                    "class_id" => $request->input('class_id'),
                ],
                [
                    "class_id"   => $request->input('class_id'),
                    "days"       => $request->input('days'),
                    "schedule"   => $request->input('schedule'),
                    "created_at" => date('Y-m-d H:i:s'),
                ]);
            return response()->json([
                "message"     => 'Data store successfully inserted',
                "Participant" => [
                ],
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
    public function show($class_id)
    {
        $classFormat = ClassFormat::where(["class_id" => $class_id])->first();
        return response()->json([
            "data" => $classFormat
        ]);
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
