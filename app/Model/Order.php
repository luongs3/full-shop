<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;
use Response;
use Exception;

class Order extends BaseModel{

    protected $table = "invoice";
    protected $fillable = ['id','status','address','sub_price','total_price','tax','items','name','email','phone_number','province','district'];

    public function __construct($attributes = array()){
        parent::__construct($attributes);
        $this->setModelClass('App\Model\Order');
        $this->setSingularKey('order');
        $this->setPluralKey('orders');
    }

    public function updateStatus($data){
        $model_class = $this->getModelClass();
        try {
//            $model = $model_class::where('id',$data['id'])->update(['status' => $data['status']]);
            $model = $model_class::find($data['id']);
            if (!$model)
                return Response::json([
                    'errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]
                ]);
            $model->status = $data['status'];
            $model->save();
            return Response::json([$this->getSingularKey()=>$model]);
        } catch (Exception $e) {
            return Response::json(['errors'=> [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]]);
        }
    }
}