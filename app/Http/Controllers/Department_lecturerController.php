<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentLecturerResource;
use App\Models\Department_lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Department_lecturerController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $department_lecturers = Department_lecturer::all();
        if (!$department_lecturers){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($department_lecturers,$msg,$status);
    }


    public function show($id){
        $department_lecturer = Department_lecturer::findOrFail($id);
        if ($department_lecturer->exists()){
            return $this->apiResponseFormate($department_lecturer,"ok",200);
        }

        return $this->apiResponseFormate(null,"the department_lecturer is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'lecturer_id' => 'required',
                'department_id' => 'required',

            ])->validate();

            $department_lecturer = Department_lecturer::create([

                'lecturer_id' => $request->lecturer_id,
                'department_id' => $request->department_id,

            ]);

            if ($department_lecturer){
                return $this->apiResponseFormate(new DepartmentLecturerResource($department_lecturer),"the department_lecturer is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the  department_lecturer is not Save ",400);

    }





    public function update(Request $request, $id){

        try {
            $validator = Validator::make($request->all(), [

                'department_id' => 'required',
                'lecturer_id' => 'required',

            ])->validate();

            $department_lecturer = Department_lecturer::findOrFail($id);
            if (!$department_lecturer){
                return $this->apiResponseFormate(null,"the department_lecturer is not found ",400);
            }
            $department_lecturer->update([

                'department_id' => $request->department_id,
                'lecturer_id' => $request->lecturer_id,

            ]);

            if ($department_lecturer){
                return $this->apiResponseFormate(new DepartmentLecturerResource($department_lecturer),"the department_lecturer is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the department_lecturer is not updated ",400);

    }


    public function destroy($id){
        $department_lecturer = Department_lecturer::findOrFail($id);
        if (!$department_lecturer){
            return $this->apiResponseFormate(null,"the department_lecturer is not found ",400);
        }
        $department_lecturer->delete($id);
        if ($department_lecturer){
            return $this->apiResponseFormate(new DepartmentLecturerResource($department_lecturer),"the department_lecturer is deleted successfully ",203);
        }
    }
}
