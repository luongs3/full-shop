<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;

class District extends BaseModel{

    protected $table = "district";
    public $timestamps = false;
    protected $fillable = ['id','name','type','location','province_id'];

    public function __construct($attributes = array()){
        parent::__construct($attributes);
        $this->setModelClass('App\Model\District');
        $this->setSingularKey('district');
        $this->setPluralKey('districts');
    }
}