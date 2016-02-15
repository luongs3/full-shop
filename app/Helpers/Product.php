<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 2/10/2016
 * Time: 10:07 PM
 */

namespace App\Helpers;
use App\Model\Product as Pro;
use Response;

class Product {
    public static function getCategoryProducts($category_id){
        $model = new Pro();
        $response = $model->getCategoryProducts($category_id);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Response::json(['errors' => ['message' =>  $data['errors']['message']]]);
        return Response::json(['products' => $data['products']]);

    }
}