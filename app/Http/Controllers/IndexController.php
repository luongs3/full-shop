<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/4/2016
 * Time: 4:09 PM
 */

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\File;
use App\Model\Product;
use App\Model\Category;
use App\Model\FeaturedProduct;
use Auth;
use Session;
use Response;
use Input;
use Redirect;

class IndexController extends Controller {
    public function __construct(){
    }

    public function index(){
//        load image slider
        $file = new File();
        $attributes = array(
            'type' => 'slider'
        );
        $response = $file->getAll($attributes);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('')->with('error', $data['errors']['message']);
        $files = $data['files'];
//        load featured products
        $filter=array(
            'limit' => 6
        );
        $fp_model = new FeaturedProduct();
        $response = $fp_model->getAll($filter);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $featured_products = $data['featuredProducts'];
//        load categories
        $model = new Category();
        $response = $model->getList();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('categories.manage')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
//        page title
        return view("index")->with('files',$files)->with('featured_products',$featured_products)->with('categories',$categories);
    }
    public function getErrorPage(){
        return view('errors.404');
    }
//    show Category detail
    public function showCategoryDetail($id){
        $category = $this->model->get($id);
        if(!empty($category)){
            return view('category-details')->with("error",Lang::get("category.can_not_find_this_category"));
        }else{
            return view('category.category-details')->with("category",$category);
        }
    }
//    edit one category - admin
    public function edit($id=null){
        $response = $this->model->show($id);
        $data = json_decode($response->getContent());
        if (!$data) {
            return Redirect::route('categories.edit',['id' => $id])->with('error', "Loại SP Không tồn tại")->withInput();
        } else {
            return view("category.edit")->with("category",$data->category);
        }
    }
//    add new category
    public function create(){
        $scripts = [
//            '/js/jquery.uploadPreview.min.js'
        ];
        return view("category.create");
    }

//    manage
    public function manage(){
        $filter = array(
            'type' => 'slider'
        );
        $file_model = new File();
        $response = $file_model->getAll($filter);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return view('manage-index')->with('error', $data['errors']['message']);
        $images = $data['files'];
        return view("manage-index")->with('images',$images);
    }
//    save
    public function save(){
        $input = Input::all();
//        banner
        for($i=0;$i<3;$i++){
            if(Input::hasFile($i)) {
                if(Input::file($i)->getSize() < 500000 && Input::file($i)->isValid()){
                    $fileInstance = new File();
                    if (!empty(Input::get("hidden_" . $i))) {
//                        delete old banner
                        $response = $fileInstance->remove(Input::get("hidden_" . $i));
                        $data = json_decode($response->getContent(), true);
                        if (isset($data['errors']))
                            return Redirect::route('index.manage')->with('error', $data['errors']['message']);
                    }
                    $destination_path = public_path('images/home');
                    $name = Input::file($i)->getClientOriginalName();
                    $file = Input::file($i)->move($destination_path, $name);
                    $check_error = Input::file($i)->getError();
                    if($check_error != "UPLOADERROK")
                        return Redirect::route('index.manage')->with('error', trans('message.upload_file_failed'));
                    $saved_file = array(
                        'name' => $file->getFilename(),
                        'type' => 'SLIDER',
                    );
                    $response = $fileInstance->store($saved_file);
                    $data = json_decode($response->getContent(),true);
                    if (isset($data['errors'])) {
                        return Redirect::route('index.manage')->with('error', $data['errors']['message']);
                    }else
                        return Redirect::route('index.manage')->with('success', trans('message.upload_file_successfully'));
                }
            }
        }
        return Redirect::route('index.manage');
    }

    public function delete($id)
    {
        if(!$id)
            return Redirect::route('categories.manage')->with('error', "Sản Phảm Không tồn tại");
        $response = $this->model->deleteCategory($id);
        $data = json_decode($response->getContent());
        if($data->errors)
            return Redirect::route("categories.manage", ['id' => $id])->with('error',$data->errors->message);
        else
            return Redirect::route("categories.manage")->with('success',"Xóa sản phẩm thành công");
    }

    public function test()
    {
        $file = new File();
        $response = $file->remove(14);;
        $data = json_decode($response->getContent(), true);
        echo "<pre>";
        print_r($data);
        echo "\n";
        die();

        if (isset($data['errors']))
            return Redirect::route('products.manage')->with('error', $data['errors']['message']);
        $product = $data['product'];


    }
}