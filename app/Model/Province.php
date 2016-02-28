<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;

class Province extends BaseModel{

    protected $table = "province";
    public $timestamps = false;
    protected $fillable = ['id','name','type'];

    public function __construct($attributes = array()){
        parent::__construct($attributes);
        $this->setModelClass('App\Model\Province');
        $this->setSingularKey('province');
        $this->setPluralKey('provinces');
    }
}