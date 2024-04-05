<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimesTableResource;
use App\Models\timestable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TimestableController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $timestables = Timestable::all();
        if (!$timestables){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($timestables,$msg,$status);
    }


    public function search($param){
//        $search = '%'.$param.'%';
//        $result = Timestable::whereAny(['subject_id','room_id','day','start_time','end_time'],'LIKE',$search)->get();


        $search = '%' . $param . '%';
        $result = Timestable::where(function ($query) use ($search) {
            $columns = ['subject_id','lecturer_id','semester_id', 'room_id', 'day', 'start_time', 'end_time'];
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', $search);
            }
        })->get();

        if (!$result){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($result,$msg,$status);
    }


    public function show($id){
        $timestable = Timestable::findOrFail($id);
        if ($timestable->exists()){
            return $this->apiResponseFormate($timestable,"ok",200);
        }

        return $this->apiResponseFormate(null,"the timestable is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'subject_id' => 'required',
                'room_id' => 'required',
                'semester_id' => 'required',
                'lecturer_id' => 'required',
                'day' => 'nullable',
                'start_time' => 'required',
                'end_time' => 'required',
            ])->validate();

            $timestable = Timestable::create([
                'name' => $request->name,
                'subject_id' => $request->subject_id,
                'room_id' => $request->room_id,
                'lecturer_id' => $request->lecturer_id,
                'semester_id' => $request->semester_id,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            if ($timestable){
                return $this->apiResponseFormate(new TimesTableResource($timestable),"the timestable is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the timestable is not Save ",400);

    }





    public function update(Request $request, $id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'subject_id' => 'required',
                'room_id' => 'required',
                'semester_id' => 'required',
                'lecturer_id' => 'required',
                'day' => 'nullable',
                'start_time' => 'required',
                'end_time' => 'required',
            ])->validate();

            $timestable = Timestable::findOrFail($id);
            if (!$timestable){
                return $this->apiResponseFormate(null,"the timestable is not found ",400);
            }
            $timestable->update([
                'name' => $request->name,
                'subject_id' => $request->subject_id,
                'room_id' => $request->room_id,
                'lecturer_id' => $request->lecturer_id,
                'semester_id' => $request->semester_id,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            if ($timestable){
                return $this->apiResponseFormate(new TimesTableResource($timestable),"the timestable is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the timestable is not updated ",400);

    }


    public function destroy($id){
        $timestable = Timestable::findOrFail($id);
        if (!$timestable){
            return $this->apiResponseFormate(null,"the timestable is not found ",400);
        }
        $timestable->delete($id);
        if ($timestable){
            return $this->apiResponseFormate(new TimesTableResource($timestable),"the timestable is deleted successfully ",203);
        }
    }
}
