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


class File extends BaseModel{

    protected $table = "file";
    protected $fillable = ['name', 'type','url'];

    public function __construct($attributes = array()){
        parent::__construct($attributes);
        $this->setModelClass('App\Model\File');
        $this->setSingularKey('file');
        $this->setPluralKey('files');
    }

    public function store($data){
        $model_class = $this->getModelClass();
        if($data['type']=='PRODUCT')
            $data['url'] = '/images/product/' . $data['name'];
        elseif($data['type']=='SLIDER' || $data['type']=='advertisement')
            $data['url'] = '/images/home/'.  $data['name'];
        $model = new $model_class($data);
        try {
            $model->save();
            return Response::json([$this->getSingularKey() => $model]);
        } catch (Exception $e) {
            return [
                Response::json(['errors' => [
                    'code' => $e->getCode(), 'message' => $e->getMessage()
                ]
                ])];
        }
    }
    public function remove($id){
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::find($id);
            if (!$model) {
                return Response::json([
                    'errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]
                ]);
            }
            if(file_exists(public_path($model->url)))
                unlink(public_path($model->url));
            $model->delete();
            return Response::json([$this->getSingularKey() => $model]);
        } catch (Exception $e) {
            return Response::json([
                'errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
            ]);
        }
    }
}