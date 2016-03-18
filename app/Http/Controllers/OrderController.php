<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/5/2016
 * Time: 3:28 PM
 */

namespace app\Http\Controllers;
use App\Model\Product as Product;
use Mockery\CountValidator\Exception;
use Session;
use App\Model\Order as Order;
use App\Helpers\Common;
use Input;
use Redirect;

class OrderController extends Controller{
    public function __construct(){
        $this->model = new Order();
        $this->setSingularKey('order');
        $this->setPluralKey('orders');
    }

    public function index(){
        return view('Categories');
    }

    public function cart(){
        $items = array();
        if(Session::has('items'))
            $items = Session::get('items');
        $price['sub_price'] = Session::get('sub_price');
        $price['total_price'] = Session::get('total_price');
        return view('order.cart')->with('items',$items)->with('price',$price);
    }

    public function addItem(){
        $input = array(
            'product_id' => Input::get('product_id'),
            'quantity' => Input::get('quantity',1)
        );
        $product = new Product();
        $response = $product->show($input['product_id']);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $product = $data['product'];
        $input['name'] = $product['name'];
        $input['sku'] = $product['sku'];
        $input['price'] = $product['price'];
        $input['sale_price'] = $product['sale_price'];
        $input['image_url'] = $product['image_url'];
        if (isset($product['sale_price']))
            $input['sub_total'] = $input['quantity'] * $product['sale_price'];
        else
            $input['sub_total'] = $input['quantity'] * $product['price'];
        if(Session::has('items'))
            Session::push('items',$input);
        else
            Session::set('items',[$input]);
        Session::set('sub_price',Session::get('sub_price')+$input['sub_total']);
//            not include tax, so sub_price = total_price
        Session::set('total_price',Session::get('sub_price'));
        return Redirect::route('cart');
    }

    public function removeItem(){
        $key = json_decode(Input::get('key'));
        $item = Session::pull('items.'.$key);
        Session::set('sub_price',Session::get('sub_price')-$item['sub_total']);
        Session::set('total_price',Session::get('sub_price'));
        Session::flash('success',trans('message.remove_item_successfully'));
    }

    public function changeQuantity(){
        $input = Input::all();
        $item = Session::get('items.'.$input['key']);
        Session::set('sub_price',Session::get('sub_price')+($input['quantity']-$item['quantity'])*$item['price']);
        Session::set('total_price',Session::get('sub_price'));
        $item['quantity'] = $input['quantity'];
        $item['sub_total'] = $item['quantity'] * $item['price'];
        Session::set('items.'.$input['key'],$item);
    }
//    checkout
    public function getCheckout(){
        $items = $price = array();
        if(Session::has('items')){
            $items = Session::get('items');
            $price['sub_price'] = Session::get('sub_price');
            $price['total_price'] = Session::get('total_price');
        }
//        $districts = Common::getDistricts();
        $provinces = Common::getProvinces();
        $data = array('price'=>$price,
            'items'=>$items,
            'provinces'=>$provinces,
//            'districts'=>$districts
        );
        return view('order.checkout')->with($data);
    }

    public function selectDistricts($province_id){
        $districts = Common::getDistricts(array('province_id'=>$province_id));
        return $districts;
    }

    public function postCheckout(){
        $input = Input::all();
        if(isset($input['_token']))
            unset($input['_token']);
        try {
            $input['sub_price'] = Session::pull('sub_price');
            $input['total_price'] = Session::pull('total_price');
            $input['items'] = Session::pull('items');
        } catch (Exception $e) {
            return Redirect::route('404')->with('error',$e->getCode().': '.$e->getMessage());
        }
        $input['items'] = serialize($input['items']);
        $response = $this->model->store($input);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return Redirect::route('404')->with('error',$data['errors']['message']);
        return Redirect::route('result')->with('success',trans('message.submit_order_successfully'));
    }

    public function result(){
        return view('order.result');
    }
//    edit one category - admin
    public function edit($id=null){
        $response = $this->model->show($id);
        $data = json_decode($response->getContent(),true);
        if (isset($data['errors'])) {
            return view('orders.manage')->with('error',$data['errors']['message']);
        }
        $order = $data[$this->getSingularKey()];
        $order['items'] = unserialize($order['items']);
        if(!empty($order['province']))
            $order['province'] = Common::showProvince($order['province']);
        if(!empty($order['district']))
            $order['district'] = Common::showDistrict($order['district']);
        $order['status'] = Common::convertStatus($order['status']);
        return view("order.edit")->with($this->getSingularKey(),$order);
    }
//    add new category
    public function create(){
        $response = $this->model->getAll();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
        return view("category.create")->with('categories', $categories);
    }
    public function save($id=null){
        $input = Input::all();
//        check sku
        if(array_get($input,'_token'))
            unset($input['_token']);
        $input['name'] = trim(preg_replace('/[^(\x20-\x7F)]*/','', $input['name']));
        $input['description'] = trim($input['description']);
        if($id){
            $response = $this->model->updateItem($input);
            $data = json_decode($response->getContent(),true);
            if (isset($data['errors'])) {
                return Redirect::route('categories.edit',['id' => $id])->with('error', $data->errors->message);
            } else {
                return Redirect::route('categories.edit',['id' => $id])->with('success',trans('message.edit_category_successfully'));
            }
        }
        else{
            $response = $this->model->store($input);
            $data = json_decode($response->getContent(),true);
            if (isset($data['errors'])) {
                return Redirect::route('categories.create')->with('error',$data->errors->message)->withInput();
            } else {
                return Redirect::route('categories.create')->with('success',trans('message.create_category_successfully'));
            }
        }
    }
//    admin page - manage category
    public function manage(){
        $filter = array(
            'page' => 0,
            'limit' => 10
        );
        $scripts = [
            "/js/jquery.dataTables.min.js",
            "/js/dataTables.bootstrap.min.js",
            "https://cdn.datatables.net/plug-ins/1.10.10/pagination/four_button.js"
        ];
        $data = $this->model->index($filter);
        return view("order.order-manage")->with('orders',$data)->with('scripts',$scripts);
    }

    public function updateStatus(){
        $input = Input::all();
        $data = json_decode($input['data'],true);
        foreach ($data as $item) {
            $response = $this->model->updateStatus($item);
        }
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            Session::flash('error',$data['errors']['message']);
        else
            Session::flash('success',trans('message.update_order_status_successfully'));
    }

    public function delete($id)
    {
        if(!$id)
            return Redirect::route('categories.manage')->with('error', trans('message.category_not_exist'));
        $response = $this->model->remove($id);
        $data = json_decode($response->getContent());
        if($data->errors)
            return Redirect::route("categories.manage", ['id' => $id])->with('error',$data->errors->message);
        else
            return Redirect::route("categories.manage")->with('success',trans('message.delete_category_successfully'));

    }

    public function massiveDelete()
    {
        $input = json_decode(Input::get('ids'));
        foreach ($input as $val) {
            $response = $this->model->remove($val);
            $data = json_decode($response->getContent());
            if($data->errors){
                Session::flash('error', $data->errors->message);
            }
        }
        Session::flash('success',trans('message.delete_category_successfully'));
    }

    public function abc(){
        $categories = $this->model->index();
        return view('test')->with('test','abc');
    }

    public function testView()
    {
        return view('test');
    }
    public function test()
    {
        $input = array(
            'name' => "wam",
            'description' => 'Why always Me'
        );
        $response = $this->model->updateItem($input);
        $response = json_decode($response->getContent());
        if (isset($response->errors)) {
            $input = json_decode(json_encode($input), FALSE);
            return view('test')->with('error',$response->errors->message)->with('category',$input);
        } else {
            return Redirect::route('categories.test-view')->with('success',"Tạo Loại sản phẩm thành công");
        }

    }

}