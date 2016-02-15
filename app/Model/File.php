<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Request;
use Response;


class File extends Model{
    protected $table = "file";
    public $timestamps = false;
    protected $fillable = ['name', 'type'];

    public function upload($file)
    {
        $file = new File($file);
        try {
            $file->save();
            return Response::json(['file' => $file]);
        } catch (Exception $e) {
            return [
                'errors' => [
                    'code' => $e->getCode(), 'message' => $e->getMessage()
                ]
            ];
        }
    }

    public function show($file_id)
    {
        try{
            $file = File::where('id',$file_id)->first();
            if(!$file)
                return Response::json(['errors' =>[
                    'message' => 'File not found'
                ]]);
            return Response::json(['file' => $file]);
        }catch (Exception $e){
            return Response::json([
                'errors' => [
                    'code' => $e->getCode(), 'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function getSliderImages(){
        try{
            $file = File::where('type','slider')->orderBy('id',"DESC")->get();
            if(!$file)
                return Response::json(['errors' =>[
                    'message' => trans('message.file_not_found')
                ]]);
            return Response::json(['files' => $file]);
        }catch (Exception $e){
            return Response::json([
                'errors' => [
                    'code' => $e->getCode(), 'message' => $e->getMessage()
                ]
            ]);
        }
    }
}