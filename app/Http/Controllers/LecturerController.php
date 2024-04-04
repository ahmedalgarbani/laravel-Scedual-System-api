<?php

namespace App\Http\Controllers;

use App\Http\Resources\LecturerResource;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LecturerController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $Lecturers = Lecturer::all();
        if (!$Lecturers){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($Lecturers,$msg,$status);
    }


    public function show($id){
        $Lecturers = Lecturer::findOrFail($id);
        if ($Lecturers->exists()){
            return $this->apiResponseFormate($Lecturers,"ok",200);
        }

        return $this->apiResponseFormate(null,"the Lecturer is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'nullable|max:255',
                'specialization' => 'nullable|max:255',
            ])->validate();

            $Lecturer = Lecturer::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'specialization'=>$request->specialization,
            ]);

            if ($Lecturer){
                return $this->apiResponseFormate(new LecturerResource($Lecturer),"the Lecturer is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the Lecturer is not Save ",400);

    }



    public function update(Request $request,String $id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'nullable|max:255',
                'specialization' => 'nullable|max:255',
            ])->validate();

            $Lecturer = Lecturer::findOrFail($id);
            if (!$Lecturer){
                return $this->apiResponseFormate(null,"the Lecturer is not found ",400);
            }
            $Lecturer->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'specialization'=>$request->specialization,
            ]);

            if ($Lecturer){
                return $this->apiResponseFormate(new LecturerResource($Lecturer),"the Lecturer is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the Lecturer is not updated ",400);

    }


    public function destroy($id){
        $Lecturer = Lecturer::findOrFail($id);
        if (!$Lecturer){
            return $this->apiResponseFormate(null,"the Lecturer is not found ",400);
        }
        $Lecturer->delete($id);
        if ($Lecturer){
            return $this->apiResponseFormate(new LecturerResource($Lecturer),"the Lecturer is deleted successfully ",203);
        }
    }
}
