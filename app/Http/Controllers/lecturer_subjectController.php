<?php

namespace App\Http\Controllers;

use App\Http\Resources\LecturerSubjectResource;
use App\Models\Lecturer_subject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class lecturer_subjectController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $lecturer_subjects = Lecturer_subject::all();
        if (!$lecturer_subjects){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($lecturer_subjects,$msg,$status);
    }


    public function show($id){
        $lecturer_subject = Lecturer_subject::findOrFail($id);
        if ($lecturer_subject->exists()){
            return $this->apiResponseFormate($lecturer_subject,"ok",200);
        }

        return $this->apiResponseFormate(null,"the lecturer_subject is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'subject_id' => 'required',
                'lecturer_id' => 'required',
            ])->validate();

            $lecturer_subject = Lecturer_subject::create([
                'subject_id' => $request->subject_id,
                'lecturer_id' => $request->lecturer_id,

            ]);

            if ($lecturer_subject){
                return $this->apiResponseFormate(new LecturerSubjectResource($lecturer_subject),"the lecturer_subject is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the lecturer_subject is not Save ",400);

    }





    public function update(Request $request, $id){

        try {
            $validator = Validator::make($request->all(), [

                'subject_id' => 'required',
                'lecturer_id' => 'required',

            ])->validate();

            $lecturer_subject = Lecturer_subject::findOrFail($id);
            if (!$lecturer_subject){
                return $this->apiResponseFormate(null,"the lecturer_subject is not found ",400);
            }
            $lecturer_subject->update([

                'subject_id' => $request->subject_id,
                'lecturer_id' => $request->lecturer_id,

            ]);

            if ($lecturer_subject){
                return $this->apiResponseFormate(new LecturerSubjectResource($lecturer_subject),"the lecturer_subject is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the lecturer_subject is not updated ",400);

    }


    public function destroy($id){
        $lecturer_subject = Lecturer_subject::findOrFail($id);
        if (!$lecturer_subject){
            return $this->apiResponseFormate(null,"the lecturer_subject is not found ",400);
        }
        $lecturer_subject->delete($id);
        if ($lecturer_subject){
            return $this->apiResponseFormate(new LecturerSubjectResource($lecturer_subject),"the lecturer_subject is deleted successfully ",203);
        }
    }
}
