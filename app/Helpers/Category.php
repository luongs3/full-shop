<?php
namespace App\Helpers;

/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 2/9/2016
 * Time: 11:10 PM
 */
use App\Model\Category as Cat;
use Response;

class Category{
    public static function getList(){
        $model = new Cat();
        $response = $model->getAll();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Response::json(['errors'=>['message' => $data['errors']['message']]]);
        $categories = $data['categories'];
        $i=0;
        foreach ($categories as $key => $val) {
            if($val['parent_id']!=null){
                foreach ($categories as $key1 => $val1) {
                    if($val['parent_id']==$val1['id']){
                        $categories[$key1]['children'][$i]['id']= $val['id'];
                        $categories[$key1]['children'][$i]['name']= $val['name'];
                        $i++;
                    }
                }
                unset($categories[$key]);
            }
        }
        return Response::json(['categories' => $categories]);
    }
}