<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use PhpSpec\Exception\Exception;
use Response;

abstract class BaseModel extends Model
{
//    protected $table;
//    public $timestamps;
//    protected $fillable;
    protected $model_class;
    protected $singular_key;
    protected $plural_key;


    public function show($id = null)
    {
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::find($id);
            if (!$model)
                return Response::json(['errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]]);
            return Response::json([$this->getSingularKey() => $model]);
        } catch (Exception $e) {
            return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
        }
    }

    public function index($filter = array())
    {
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::orderBy("id", "DESC")->paginate($filter['limit']);
            if (!$model)
                return Response::json(['errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]]);
            return $model;
        } catch (Exception $e) {
            return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
        }
    }

    public function store($data){
        $model_class = $this->getModelClass();
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

    public function getAll($filter = array())
    {
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::where($filter)->orderBy('id',"DESC")->get();
            if (!$model)
                return Response::json(['errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]]);
            return Response::json([$this->getPluralKey() => $model]);
        } catch (Exception $e) {
            return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
        }
    }

    public function updateItem($data)
    {
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::find(array_get($data, 'id'));
            if (!$model)
                return Response::json([
                    'errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]
                ]);
            $model->fill($data);
            $model->save();
            return Response::json([$this->getSingularKey() => $model]);
        } catch (Exception $e) {
            return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
        }
    }

    public function remove($id)
    {
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::find($id);
            if (!$model) {
                return Response::json([
                    'errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]
                ]);
            }
            $model->delete();
            return Response::json([$this->getSingularKey() => $model]);
        } catch (Exception $e) {
            return Response::json([
                'errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
            ]);
        }
    }

//    get, set function
    public function getModelClass()
    {
        return $this->model_class;
    }

    public function setModelClass($model_class)
    {
        $this->model_class = $model_class;
    }

    public function getSingularKey()
    {
        return $this->singular_key;
    }

    public function setSingularKey($singular_key)
    {
        $this->singular_key = $singular_key;
    }

    public function getPluralKey()
    {
        return $this->plural_key;
    }

    public function setPluralKey($plural_key)
    {
        $this->plural_key = $plural_key;
    }
}