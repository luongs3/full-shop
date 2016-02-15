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
use App\Helpers\Category as Helper;
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
        $response = $file->getSliderImages();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('')->with('error', $data['errors']['message']);
        $files = $data['files'];
        foreach ($files as $key => $val) {
            $files[$key]['url'] = '/images/home/' . $val['name'];
        }
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
        $response = Helper::getList();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('categories.manage')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
//        page title
        return view("index")->with('files',$files)->with('featured_products',$featured_products)->with('categories',$categories);
    }
//  manage site
//    public function manage(){
//
//    }
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
    public function save($id=null){
        $input = Input::all();
//        check sku
        if(array_get($input,'_token'))
            unset($input['_token']);
        $input['name'] = trim(preg_replace('/[^(\x20-\x7F)]*/','', $input['name']));
        $input['description'] = trim($input['description']);
        if($id){
            $response = $this->model->updateCategory($input);
            $response = json_decode($response->getContent());
            if (isset($response->errors)){
                return Redirect::route('categories.edit',['id' => $id])->with('error', $response->errors->message);
            } else {
                return Redirect::route('categories.edit',['id' => $id])->with('success',"Chỉnh sửa Loại SP thành công");
            }
        }
        else{
            $response = $this->model->store($input);
            $response = json_decode($response->getContent());
            if (isset($response->errors)) {
                return Redirect::route('categories.create')->with('error',$response->errors->message)->withInput();
            } else {
                return Redirect::route('categories.create')->with('success',"Tạo Loại sản phẩm thành công");
            }
        }

//        $response = 1 <-> success, $response = 0 <-> failed
    }
//    admin page - manage category
    public function manage(){
        $filter = array(
            'page' => 0,
            'limit' => 10
        );
//        $data = json_decode($this->model->getcategorys(null,$filter));
        $data = $this->model->index($filter);
        $scripts = [
            "/js/jquery.dataTables.min.js",
            "/js/dataTables.bootstrap.min.js",
            "https://cdn.datatables.net/plug-ins/1.10.10/pagination/four_button.js"
        ];
        return view("category.category-manage")->with('categories',$data)->with('scripts',$scripts);
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
        $user = Auth::user();
        $attr = $user->getAttributes();
        echo "<pre>";
        print_r($attr);
        echo "\n";
        $name = Auth::getName();
        print_r($name);
        echo "\n";
        $user = Auth::getRequest();
        print_r($user);
        echo "\n";
        die();

    }
}