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
use App\Model\Category as Category;
use Input;
use Redirect;

class CategoryController extends Controller{
    protected $model;
    public function __construct(){
        $this->model = new Category();
        $this->setSingularKey('category');
        $this->setPluralKey('categories');
    }

    public function index(){
        return view('Categories');
    }
//    edit one category - admin
    public function edit($id=null){
        $response = $this->model->show($id);
        $data = json_decode($response->getContent(),true);
        if (isset($data['errors'])) {
            return view('categories.manage')->with('error',$data['errors']['message']);
        }
        $category = $data[$this->getSingularKey()];
        $response = $this->model->getList();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('categories.manage')->with('error', $data['errors']['message']);
        $categories = $data[$this->getPluralKey()];
        return view("category.edit")->with("category",$category)->with('categories',$categories);
    }
//    add new category
    public function create(){
        $response = $this->model->getAll();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $categories = $data[$this->getPluralKey()];
        return view("category.create")->with('categories', $categories);
    }
    public function save($id=null){
        $input = Input::all();
//        check sku
        if(array_get($input,'_token'))
            unset($input['_token']);
        $input['name'] = trim($input['name']);
        $input['description'] = trim($input['description']);
        if($id){
            $response = $this->model->updateItem($input);
            $data = json_decode($response->getContent(),true);
            if (isset($data['errors'])) {
                return Redirect::route('categories.edit',['id' => $id])->with('error', $data['errors']['message']);
            } else {
                return Redirect::route('categories.edit',['id' => $id])->with('success',trans('message.edit_category_successfully'));
            }
        }
        else{
            $response = $this->model->store($input);
            $data = json_decode($response->getContent(),true);
            if (isset($data['errors'])) {
                return Redirect::route('categories.create')->with('error',$data['errors']['message'])->withInput();
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
            return Redirect::route('categories.manage')->with('error', trans('message.category_not_exist'));
        $response = $this->model->remove($id);
        $data = json_decode($response->getContent());
        if(isset($data->errors))
            return Redirect::route("categories.manage", ['id' => $id])->with('error',$data['errors']['message']);
        else
            return Redirect::route("categories.manage")->with('success',trans('message.delete_category_successfully'));

    }

    public function massiveDelete()
    {
        $input = json_decode(Input::get('ids'));
        foreach ($input as $val) {
            $response = $this->model->remove($val);
            $data = json_decode($response->getContent(),true);
            if(isset($data['errors'])){
                Session::flash('error', $data['errors']['message']);
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
            return view('test')->with('error',$response->errors>message)->with('category',$input);
        } else {
            return Redirect::route('categories.test-view')->with('success',"Tạo Loại sản phẩm thành công");
        }

    }

}