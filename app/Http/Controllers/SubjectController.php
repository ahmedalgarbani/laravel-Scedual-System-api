<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $subjects = Subject::all();
        if (!$subjects){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($subjects,$msg,$status);
    }


    public function show($id){
        $subject = Subject::findOrFail($id);
        if ($subject->exists()){
            return $this->apiResponseFormate($subject,"ok",200);
        }

        return $this->apiResponseFormate(null,"the subject is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'short_name' => 'nullable',
                'description' => 'nullable',
                'hour' => 'nullable',
                'department_id' => 'required',
            ])->validate();

            $subject = Subject::create([
                'name'=>$request->name,
                'short_name'=>$request->short_name,
                'description'=>$request->description,
                'hour'=>$request->hour,
                'department_id'=>$request->department_id,
            ]);

            if ($subject){
                return $this->apiResponseFormate(new SubjectResource($subject),"the subject is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the subject is not Save ",400);

    }







    public function update(Request $request, $id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'short_name' => 'nullable',
                'description' => 'nullable',
                'hour' => 'nullable',
                'department_id' => 'required',
            ])->validate();

            $subject = Subject::findOrFail($id);
            if (!$subject){
                return $this->apiResponseFormate(null,"the subject is not found ",400);
            }
            $subject->update([
                'name'=>$request->name,
                'short_name'=>$request->short_name,
                'description'=>$request->description,
                'hour'=>$request->hour,
                'department_id'=>$request->department_id,
            ]);

            if ($subject){
                return $this->apiResponseFormate(new SubjectResource($subject),"the subject is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the subject is not updated ",400);

    }


    public function destroy($id){
        $subject = Subject::findOrFail($id);
        if (!$subject){
            return $this->apiResponseFormate(null,"the subject is not found ",400);
        }
        $subject->delete($id);
        if ($subject){
            return $this->apiResponseFormate(new SubjectResource($subject),"the subject is deleted successfully ",203);
        }
    }
}
