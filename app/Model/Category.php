<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;
use Response;

class Category extends BaseModel{

    protected $table = "category";
    public $timestamps = false;
    protected $fillable = ['name','description','parent_id'];

    public function __construct($attributes = array()){
        parent::__construct($attributes);
        $this->setModelClass('App\Model\Category');
        $this->setSingularKey('category');
        $this->setPluralKey('categories');
    }
    public function getList(){
        $response = $this->getAll();
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