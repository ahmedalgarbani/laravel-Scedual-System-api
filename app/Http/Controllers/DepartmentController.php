<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $departments = Department::all();
        if (!$departments){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($departments,$msg,$status);
    }


    public function show($id){
        $department = Department::findOrFail($id);
        if ($department->exists()){
            return $this->apiResponseFormate($department,"ok",200);
        }

        return $this->apiResponseFormate(null,"the department is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                "name"=>'required|max:255',
                "code"=>'required|unique:departments',
                "description"=>'nullable',
                "college_id"=>'required'
            ])->validate();

            $department = Department::create([
                "name"=>$request->name,
                "code"=>$request->code,
                "description"=>$request->description,
                "college_id"=>$request->college_id
            ]);

            if ($department){
                return $this->apiResponseFormate(new DepartmentResource($department),"the department is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the department is not Save ",400);

    }





    public function update(Request $request, $id){

        try {
            $validator = Validator::make($request->all(), [
                "name"=>'required|max:255',
                "code"=>'required|unique:departments',
                "description"=>'nullable',
                "college_id"=>'required'
            ])->validate();

            $department = Department::findOrFail($id);
            if (!$department){
                return $this->apiResponseFormate(null,"the department is not found ",400);
            }
            $department->update([
                "name"=>$request->name,
                "code"=>$request->code,
                "description"=>$request->description,
                "college_id"=>$request->college_id
            ]);

            if ($department){
                return $this->apiResponseFormate(new DepartmentResource($department),"the department is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the department is not updated ",400);

    }


    public function destroy($id){
        $department = Department::findOrFail($id);
        if (!$department){
            return $this->apiResponseFormate(null,"the department is not found ",400);
        }
        $department->delete($id);
        if ($department){
            return $this->apiResponseFormate(new DepartmentResource($department),"the department is deleted successfully ",203);
        }
    }
}
