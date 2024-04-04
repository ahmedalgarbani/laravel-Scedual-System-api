<?php


namespace App\Http\Controllers;


trait ApiResponseTrait
{
        public function apiResponseFormate($data=null,$message=null,$status=null){
            $array=[
                "datat"=>$data,
                "message"=>$message,
                "status"=>$status
            ];
            return response($array,$status);
        }
}
