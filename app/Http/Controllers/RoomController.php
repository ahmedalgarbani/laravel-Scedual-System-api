<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    use ApiResponseTrait;

    public function index(){
       $Rooms = Room::all();
        if (!$Rooms){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
      $msg="the data is showing successfully";
      $status = 200;
        return $this->apiResponseFormate($Rooms,$msg,$status);
    }


    public function show($id){
       $Rooms = Room::findOrFail($id);
      if ($Rooms->exists()){
          return $this->apiResponseFormate($Rooms,"ok",200);
      }

        return $this->apiResponseFormate(null,"the room is not found",401);

    }


    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'capacity' => 'required|max:11',
                'location' => 'nullable|max:255',
                'department_id' => 'required',
            ])->validate();

            $Room = Room::create([
                'name'=>$request->name,
                'capacity'=>$request->capacity,
                'location'=>$request->location,
                'department_id'=>$request->department_id,
            ]);

            if ($Room){
                return $this->apiResponseFormate(new RoomResource($Room),"the Room is saved successfully",202);
            }

        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the Room is not Save ",400);

    }



    public function update(Request $request,String $id){

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'capacity' => 'required|max:11',
                'location' => 'nullable|max:255',
                'department_id' => 'required',
            ])->validate();


            $Room = Room::findOrFail($id);
            if (!$Room){
                return $this->apiResponseFormate(null,"the Room is not found ",400);
            }
            $Room->update([
                'name'=>$request->name,
                'capacity'=>$request->capacity,
                'location'=>$request->location,
                'department_id'=>$request->department_id,
            ]);

            if ($Room){
                return $this->apiResponseFormate(new RoomResource($Room),"the Room is updated successfully ",201);
            }


        } catch (ValidationException $e) {
            $errors = $e;
            return $this->apiResponseFormate(null, ['errors' => $errors->errors()], 401);
        }




        return $this->apiResponseFormate(null,"the Room is not updated ",400);

    }


    public function destroy($id){
        $Room = Room::findOrFail($id);
        if (!$Room){
            return $this->apiResponseFormate(null,"the Room is not found ",400);
        }
        $Room->delete($id);
        if ($Room){
            return $this->apiResponseFormate(new RoomResource($Room),"the Room is deleted successfully ",203);
        }
    }


}
