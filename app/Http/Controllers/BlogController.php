<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/5/2016
 * Time: 3:28 PM
 */

namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\File;
use Session;
use Auth;
use Input;
use Redirect;

class BlogController extends Controller{
    protected $model;
    public function __construct(){
        $this->model = new Blog();
        $this->setSingularKey('post');
        $this->setPluralKey('posts');
    }

    public function index(){
        $filter = array(
            'page' => 0,
            'limit' => 10
        );
        $data = $this->model->index($filter);
        return view('blog.blog')->with('posts',$data);
    }

    public function post($id){
        $response = $this->model->show($id);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $post = $data[$this->getSingularKey()];
        return view("blog.blog-single")->with('post',$post);
    }
    
//    ADMIN
//    edit one post - admin
    public function edit($id=null){
        $response = $this->model->show($id);
        $data = json_decode($response->getContent(),true);
        if (isset($data['errors'])) {
            return view('posts.manage')->with('error',$data['errors']['message']);
        }
        $post = $data[$this->getSingularKey()];
        return view("blog.edit")->with("post",$post);
    }
//    add new post
    public function create(){
        $scripts = [
            '/js/summernote.js'
        ];
        return view("blog.create")->with('scripts',$scripts);
    }
    public function save($id=null){
        $input = Input::all();
        if(array_get($input,'_token'))
            unset($input['_token']);
        $input['title'] = trim(preg_replace('/[^(\x20-\x7F)]*/','', $input['title']));
        $input['subcontent'] = trim($input['subcontent']);
        isset($input['active']) ? $input['active'] = 1 :  $input['active']=0;
        $input['content'] = trim($input['content']);
        if(Input::hasFile('image') && empty($input['image_hidden'])) {
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
        }
        else $input['image_id'] = null;
        unset($input['image']);
        unset($input['image_hidden']);
        if($input['active']!=0)
            $input['active'] = 1;
        $input['user_id'] = Auth::user()->id;
        if(isset($id)){
            $input['id'] = $id;
            $response = $this->model->updateItem($input);
            $data = json_decode($response->getContent(),true);
            if (isset($data['errors'])) {
                return Redirect::route('blog.edit',['id' => $id])->with('error', $data['errors']['message']);
            } else {
                return Redirect::route('blog.manage')->with('success',trans('message.edit_post_successfully'));
            }
        }
        else{
            $response = $this->model->store($input);
            $data = json_decode($response->getContent(),true);
            if (isset($data['errors'])) {
                return Redirect::route('blog.create')->with('error',$data['errors']['message'])->withInput();
            } else {
                return Redirect::route('blog.manage')->with('success',trans('message.create_post_successfully'));
            }
        }
    }
//    admin page - manage post
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
        return view("blog.manage")->with('posts',$data)->with('scripts',$scripts);
    }

    public function delete($id)
    {
        if(!$id)
            return Redirect::route('blog.manage')->with('error', trans('message.post_not_exist'));
        $response = $this->model->remove($id);
        $data = json_decode($response->getContent());
        if($data['errors'])
            return Redirect::route("posts.manage")->with('error',$data['errors']['message']);
        else
            return Redirect::route("posts.manage")->with('success',trans('message.delete_post_successfully'));

    }

    public function massiveDelete()
    {
        $input = json_decode(Input::get('ids'));
        foreach ($input as $val) {
            $response = $this->model->remove($val);
            $data = json_decode($response->getContent());
            if($data['errors']){
                Session::flash('error', $data['errors']['message']);
            }
        }
        Session::flash('success',trans('message.delete_post_successfully'));
    }

    public function test(){
        return view('test');
    }

}