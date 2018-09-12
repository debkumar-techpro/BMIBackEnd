<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CourseParticipant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgrammeParticipantController extends BaseController
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
            'user_id'   => 'required|array',
            'course_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        try {
            $user_id   = $request->input('user_id');;
            $course_id = $request->input('course_id');;
            $insert    = [];
            CourseParticipant::where(["course_id" => $course_id])->delete();
            foreach ($user_id as $key => $value) {
                $insert[] = [
                    "user_id"    => $value,
                    "course_id"  => $course_id,
                    "created_at" => date('Y-m-d H:i:s'),
                ];
            }
            CourseParticipant::insert($insert);
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
    public function show($course_id)
    {
        $courseParticipant = User::select('id')
            ->where([
                "type" => "5",
            ])
            ->withCount('courseParticipant')
            ->whereHas('courseParticipant', function ($query) use ($course_id) {
                $query->where(['course_id' => $course_id]);
            })
            ->get();
        $user_id = [];
        foreach ($courseParticipant as $key => $value) {
            $user_id[] = $value->id;
        }

        $user = User::select('*')
            ->where([
                "type" => "5",
            ])->paginate();
        foreach ($user as $key => $value) {
            if (in_array($value->id, $user_id)) {
                $value->selected = 1;
            }
        }
        return response()->json($user);
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
