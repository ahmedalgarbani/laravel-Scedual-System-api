<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollegeResource;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CollegeController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $colleges = College::all();
        if (!$colleges){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($colleges,$msg,$status);
    }


    public function show($id){
        $colleges = College::findOrFail($id);
        if ($colleges->exists()){
            return $this->apiResponseFormate($colleges,"ok",200);
        }

        return $this->apiResponseFormate(null,"the college is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'nullable',
            ])->validate();

            $college = College::create([
                'name'=>$request->name,
                'description'=>$request->description
            ]);

            if ($college){
                return $this->apiResponseFormate(new CollegeResource($college),"the college is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the college is not Save ",400);

    }



    public function update(Request $request,String $id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'nullable',
            ])->validate();

            $college = College::findOrFail($id);
            if (!$college){
                return $this->apiResponseFormate(null,"the college is not found ",400);
            }
            $college->update([
                'name'=>$request->name,
                'description'=>$request->description,
            ]);

            if ($college){
                return $this->apiResponseFormate(new CollegeResource($college),"the college is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the college is not updated ",400);

    }


    public function destroy($id){
        $college = College::findOrFail($id);
        if (!$college){
            return $this->apiResponseFormate(null,"the college is not found ",400);
        }
        $college->delete($id);
        if ($college){
            return $this->apiResponseFormate(new CollegeResource($college),"the college is deleted successfully ",203);
        }
    }
}

