<?php
namespace App\Helpers;
use App\Model\Province;
use App\Model\District;
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 2/26/2016
 * Time: 9:26 PM
 */
use \App\Http\Controllers\Controller;
class Common extends Controller{
    public static function getProvinces($filter=array()){
        $model = new Province();
        $response = $model->getAll($filter,['key'=>'id','aspect'=>'ASC']);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return $data['errors'];
        return $data['provinces'];
    }
    public static function getDistricts($filter=array()){
        $model = new District();
        $response = $model->getAll($filter);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return $data['errors'];
        return $data['districts'];
    }

    public static function showProvince($province_id = 01){
        $model = new Province();
        $response = $model->show($province_id);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return $data['errors'];
        return $data['province']['name'];
    }
    public static function showDistrict($district_id = 01){
        $model = new District();
        $response = $model->show($district_id);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return $data['errors'];
        return $data['district']['name'];
    }

    public static function convertStatus($order_status){
        if($order_status=="SUCCESS")
            return trans('general.success');
        elseif($order_status=="PENDING")
            return trans('general.pending');
        else
            return trans('general.cancel');
    }
}