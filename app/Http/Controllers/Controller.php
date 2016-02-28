<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    protected $model;
    protected $singular_key;
    protected $plural_key;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
