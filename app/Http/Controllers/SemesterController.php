<?php

namespace App\Http\Controllers;

use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SemesterController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $semesters = Semester::all();
        if (!$semesters){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($semesters,$msg,$status);
    }


    public function show($id){
        $semester = Semester::findOrFail($id);
        if ($semester->exists()){
            return $this->apiResponseFormate($semester,"ok",200);
        }

        return $this->apiResponseFormate(null,"the semester is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'start_date' => 'nullable',
                'end_date' => 'nullable',
            ])->validate();

            $semester = Semester::create([
                'name'=>$request->name,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
            ]);

            if ($semester){
                return $this->apiResponseFormate(new SemesterResource($semester),"the semester is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the semester is not Save ",400);

    }







    public function update(Request $request, $id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'start_date' => 'nullable',
                'end_date' => 'nullable',
            ])->validate();

            $semester = Semester::findOrFail($id);
            if (!$semester){
                return $this->apiResponseFormate(null,"the subject is not found ",400);
            }
            $semester->update([
                'name'=>$request->name,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
            ]);

            if ($semester){
                return $this->apiResponseFormate(new SemesterResource($semester),"the semester is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the semester is not updated ",400);

    }


    public function destroy($id){
        $semester = Semester::findOrFail($id);
        if (!$semester){
            return $this->apiResponseFormate(null,"the subject is not found ",400);
        }
        $semester->delete($id);
        if ($semester){
            return $this->apiResponseFormate(new SemesterResource($semester),"the semester is deleted successfully ",203);
        }
    }
}
