<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CourseParticipant;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function show_by_class($class_id)
    {
        $courseParticipant = CourseParticipant::select('*')
            ->with(['course' => function ($query) {
                $query->select('id');
            }, 'user' => function ($query) {
            }])
            ->whereHas('course', function ($query) use ($class_id) {
                $query->where(['class_id' => $class_id]);
            })
            ->groupby('user_id')
            ->get();
        return response()->json($courseParticipant);
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
