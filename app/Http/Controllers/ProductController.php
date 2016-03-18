<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/5/2016
 * Time: 3:28 PM
 */

namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Session;
use App\Model\Product as Product;
use App\Model\Category as Category;
use App\Model\FeaturedProduct as FeaturedProduct;
use App\Model\File as File;
use Input;
use Redirect;

class ProductController extends Controller{
    protected $model;
    public function __construct(){
        $this->model = new Product();
    }

    public function index(){
        return view('products');
    }
//    edit one product - admin
    public function edit($id=null){
        $response = $this->model->show($id);
        $data = json_decode($response->getContent(),true);
        if (isset($data['errors'])) {
            return Redirect::route('products.manage')->with('error', $data['errors']['message']);
        } else {
            $scripts = [
                '/js/summernote.js'
            ];
            $product = $data['product'];
            $product['attributes'] = unserialize($product['attributes']);
            $model = new Category();
            $response = $model->getAll();
            $data = json_decode($response->getContent(), true);
            if (isset($data['errors']))
                return Redirect::route('products.manage')->with('error', $data['errors']['message']);
            $categories = $data['categories'];
            $title = array(
                'title' => trans('label.edit_product')
            );
            return view("product.edit",$title)->with("product",$product)->with("scripts", $scripts)->with('categories',$categories);
        }
    }
//    add new product
    public function create(){
        $category = new Category();
        $scripts = [
            '/js/summernote.js'
        ];
        $response = $category->getAll();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('products.manage')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
        $title = array(
            'title' => trans('label.add_new_product')
        );
        return view("product.create",$title)->with("scripts", $scripts)->with('categories',$categories);
    }

    public function save($id=null){
        $input = Input::all();
        echo "<pre>";
        print_r($input);
        echo "\n";
        die();

//        check sku
        if (!$id) {
            $response = $this->model->getSku($input['sku']);
            $data = json_decode($response->getContent(),true);
            if(isset($data['product']))
                return Redirect::route('products.manage')->with('error', trans('message.duplicated_sku'))->withInput();
        }
//        process data
        if(array_get($input,'status'))
            $input['status'] = 1;
        else
            $input['status'] = 0;
        if(array_get($input,'_token'))
            unset($input['_token']);
        $input['name'] = trim(preg_replace('/[^(\x20-\x7F)]*/','', $input['name']));
        $input['sku'] = trim(preg_replace('/[^(\x20-\x7F)]*/','', $input['sku']));
        $input['description'] = trim($input['description']);
        $input['attributes'] = serialize(array_get($input,'attributes'));
        if(isset($input['sale_price'])){
            $input['ratio'] = round((($input['price']-$input['sale_price'])/$input['price']) * 100,0);
        } elseif(isset($input['ratio']) && !isset($input['sale_price']))
            $input['sale_price'] = round($input['price'] - ( $input['price'] * $input['ratio'])/100,-2);
        if(empty($input['category_id'])) $input['category_id'] =1;
//        file process
        if(Input::hasFile('image') && $input['image_hidden']=='') {
            if(Input::file('image')->getSize() < 500000 && Input::file('image')->isValid()){
                    $destination_path = public_path('images/product');
                    $name = Input::file('image')->getClientOriginalName();
                    $file = Input::file('image')->move($destination_path, $name);
                $check_error = Input::file('image')->getError();
                if($check_error != "UPLOADERROK") {
                    if($id)
                        return Redirect::route('products.edit',['id' => $id])->with('error', $check_error)->withInput();
                    else
                        return Redirect::route('products.create')->with('error',$check_error)->withInput();
                }
                $fileInstance = new File();
                $saved_file = array(
                    'name' => $file->getFilename(),
                    'type' => 'PRODUCT'
                );
                $response = $fileInstance->store($saved_file);
                $data = json_decode($response->getContent(),true);
                if (isset($data['errors'])) {
                    if($id)
                        return Redirect::route('products.edit',['id' => $id])->with('error', $data['errors']['message'])->withInput();
                    else
                        return Redirect::route('products.create')->with('error', $data['errors']['message'])->withInput();
                } else {
                    $file = $data['file'];
                    $image_id = $file['id'];
                }
            }
        }
         if(isset($image_id))
            $input['image_id'] = $image_id;
         elseif($input['image_hidden']!=""){
             $input['image_id'] = $input['image_hidden'];
             unset($input['image_hidden']);
         }
        else $input['image_id'] = null;
        unset($input['image']);
        if($id){
            $response = $this->model->updateItem($input);
            $data = json_decode($response->getContent(), true);
            if (isset($data['errors'])) {
                return Redirect::route('products.edit',['id' => $id])->with('error', $data['errors']['message']);
            } else {
                return Redirect::route('products.edit',['id' => $id])->with('success',trans('message.edit_product_successfully'));
            }
        }
        else{
            $response = $this->model->store($input);
            $data = json_decode($response->getContent(), true);
            if (isset($data['errors'])) {
                return Redirect::route('products.create')->with('error',$data['errors']['message'])->withInput();
            } else {
                return Redirect::route('products.create')->with('success',trans('message.create_product_successfully'));
            }
        }

//        $response = 1 <-> success, $response = 0 <-> failed
    }
//    admin page - manage product
    public function manage(){
        $filter = array(
            'page' => 0,
            'limit' => 10
        );
        $data = $this->model->index($filter);
        $scripts = [
            "/js/jquery.dataTables.min.js",
            "/js/dataTables.bootstrap.min.js",
            "https://cdn.datatables.net/plug-ins/1.10.10/pagination/four_button.js"
        ];
        return view("product.product-manage")->with('products',$data)->with('scripts',$scripts);
    }
//    delete product
    public function delete($id){
        if(!$id)
            return Redirect::route('products.manage')->with('error', trans('message.product_not_exist'));
        $response = $this->model->remove($id);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return Redirect::route("products.manage", ['id' => $id])->with('error',$data['errors']['message']);
        else
            return Redirect::route("products.manage")->with('success',trans('message.delete_product_successfully'));
    }

    public function massiveDelete(){
        $input = json_decode(Input::get('ids'));
        foreach ($input as $val) {
            $response = $this->model->remove($val);
            $data = json_decode($response->getContent(),true);
            if(isset($data['errors'])){
                Session::flash('error', $response['errors']['message']);
                return "false";
            }
        }
        Session::flash('success',trans('message.delete_product_successfully'));
        return "true";
    }

    //    delete featured product
    public function deleteFeaturedProduct($id){
        if(!$id)
            return Redirect::route('products.manage-fp')->with('error', trans('message.product_not_exist'));
        $fea_product = new FeaturedProduct();
        $response = $fea_product->remove($id);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return Redirect::route("products.manage-fp", ['id' => $id])->with('error',$data['errors']['message']);
        else
            return Redirect::route("products.manage-fp")->with('success',trans('message.delete_product_successfully'));
    }

    public function massiveDeleteFeaturedProducts()
    {
        $fea_product = new FeaturedProduct();
        $input = json_decode(Input::get('ids'));
        foreach ($input as $val) {
            $response = $fea_product->remove($val);
            $data = json_decode($response->getContent(),true);
            if(isset($data['errors'])){
                Session::flash('error', $response['errors']['message']);
            }
        }
        Session::flash('success',trans('message.delete_product_successfully'));
    }

    public function setFeaturedProducts(){
        $featured_products = new FeaturedProduct();
        $input = json_decode(Input::get('ids'));
        foreach ($input as $val) {
            $response = $this->model->show($val);
            $data = json_decode($response->getContent(),true);
            if(isset($data['errors'])){
                Session::flash('error', $response['errors']['message']);
                return "false";
            }
            $product = $data['product'];
            $response = $featured_products->show($product['id']);
            $data = json_decode($response->getContent(),true);
            $featured_product = array(
                'product_id' => $product['id']
            );
            if(isset($data['featuredProduct'])){
                $response = $featured_products->updateItem($featured_product);
                $data = json_decode($response->getContent(), true);
                if (isset($data['errors'])){
                    Session::flash('error', $response['errors']['message']);
                    return "false";
                }
            }else{
                $response = $featured_products->store($featured_product);
                $data = json_decode($response->getContent(), true);
                if(isset($data['errors'])){
                    Session::flash('error', $response['errors']['message']);
                    return "false";
                }
            }
        }
        Session::flash('success', trans('message.update_product_successfully'));
        return "true";
    }

    public function getFeaturedProducts(){
        $filter = array(
            'limit' => 10
        );
        $fea_products_model = new FeaturedProduct();
        $products = $fea_products_model->index($filter);
        return view('product.featured-product-manage')->with('products',$products);
    }
//    product detail
    public function productDetail($sku){
        $response = $this->model->getSku($sku);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $product = $data['product'];
        //        load categories
        $model_cate = new Category();
        $response = $model_cate->getList();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('categories.manage')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
        return view('product.product-details')->with('product',$product)->with('categories',$categories);
    }
//    category products
    public function getCategoryProducts($category_id,$order_by='created_at',$direction='DESC'){
        $model = new Category();
        $response = $model->show($category_id);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('products.manage')->with('error', $data['errors']['message']);
        $category = $data['category'];
        $filter = array(
            'limit' => 10,
            'order-by' => $order_by,
            'direction' => $direction
        );
        //        load categories
        $model_cate = new Category();
        $response = $model_cate->getList();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('categories.manage')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
        $response = $this->model->getCategoryProducts($category_id,$filter);
        if (isset($response->errors))
            return Redirect::route('404')->with('error', $response->errors->message);
        $withData = array(
            'products' => $response,
            'category' => $category,
            'categories' => $categories
        );
        return view('shop')->with($withData);

    }
//    test
    public function testView(){
        return view('test');
    }
    public function abc(){
        $products = $this->model->getAll();
        return Redirect::route('products.test-view')->with('products',$products);
    }

    public function test()
    {
        $input['price'] = 10000;
//        $input['sale_price'] = 80;
        $input['ratio'] = 30;
        if(isset($input['sale_price'])){
            $input['ratio'] = round((($input['price']-$input['sale_price'])/$input['price']) * 100,0);
        }
        if(isset($input['ratio']) && !isset($input['sale_price']))
            $input['sale_price'] = round($input['price'] - ( $input['price'] * $input['ratio'])/100,-2);
        if(empty($input['category_id'])) $input['category_id'] =1;
        echo "<pre>";
        echo "Price: " . $input['price'];
        echo "\n";
        echo "Sale_price: " . $input['sale_price'];
        echo "\n";
        echo "Ratio: " . $input['ratio'];
        echo "\n";
        die();

    }

}