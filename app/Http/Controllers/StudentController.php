<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $students = Student::all();
        if (!$students){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($students,$msg,$status);
    }


    public function show($id){
        $students = Student::findOrFail($id);
        if ($students->exists()){
            return $this->apiResponseFormate($students,"ok",200);
        }

        return $this->apiResponseFormate(null,"the student is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'nullable|max:255',
                'registration_number' => 'required|unique:students|max:255',
            ])->validate();

            $student = Student::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'registration_number'=>$request->registration_number,
            ]);

            if ($student){
                return $this->apiResponseFormate(new StudentResource($student),"the student is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the student is not Save ",400);

    }



    public function update(Request $request,$id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'nullable|max:255',
                'registration_number' => 'unique:students|max:255',
            ])->validate();

            $student = Student::findOrFail($id);
            if (!$student){
                return $this->apiResponseFormate(null,"the student is not found ",400);
            }
            $student->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'registration_number'=>$request->registration_number,
            ]);

            if ($student){
                return $this->apiResponseFormate(new StudentResource($student),"the Lecturer is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the student is not updated ",400);

    }


    public function destroy($id){
        $student = Student::findOrFail($id);
        if (!$student){
            return $this->apiResponseFormate(null,"the student is not found ",400);
        }
        $student->delete($id);
        if ($student){
            return $this->apiResponseFormate(new StudentResource($student),"the student is deleted successfully ",203);
        }
    }
}
