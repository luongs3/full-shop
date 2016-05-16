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
            return Redirect::route('404')->with('error', $data['errors']['message']);
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
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $categories = $data['categories'];
        $response = $model->getAll();
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $categoryTab = $data['categories'];
        $filter = array(
            'limit' => 4,
            'order-by' => 'id',
            'direction' => 'DESC'
        );
        $model = new Product();
        $categoryProducts = $categoryNames = [];
        foreach ($categoryTab as $key => $item) {
            $response = $model->getLimit(['category_id' => $item['id']],['id','name','image_id', 'ratio', 'price','sale_price','sku']);
            $data = json_decode($response->getContent(), true);
            $categoryProducts[$key] = $data['products'];
            $categoryNames[$key] = $item['name'];
        }
//        load advert
        $model = new File();
        $response = $model->getAll(['type'=>'ADVERTISEMENT']);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            return Redirect::route('404')->with('error', $data['errors']['message']);
        $ad = isset($data['files'][0])?$data['files'][0]:null;
        $withData = array(
            'files' => $files,
            'featured_products' => $featured_products,
            'categories' => $categories,
            'categoryProducts' => $categoryProducts,
            'categoryNames' => $categoryNames,
            'ad' => $ad
        );
        return view("index")->with($withData);
    }
    public function getErrorPage(){
        return view('errors.404');
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
        $filter = array(
            'type' => 'advertisement'
        );
        $file_model = new File();
        $response = $file_model->getAll($filter);
        $data = json_decode($response->getContent(),true);
        if(isset($data['errors']))
            return view('manage-index')->with('error', $data['errors']['message']);
        $ad = isset($data['files'][0])?$data['files'][0]:null;
        return view("manage-index")->with('images',$images)->with('ad',$ad);
    }
//    save
    public function save(){
        $input = Input::all();
//        banner
//        max banner = 5;
        for($i=0;$i<5;$i++){
            if(Input::hasFile($i)) {
                if(Input::file($i)->getSize() < 500000 && Input::file($i)->isValid()){
                    $fileInstance = new File();
                    if (!empty(Input::get("hidden_" . $i))) {
//                        delete old banner
                        $response = $fileInstance->remove(Input::get("hidden_" . $i));
                        $data = json_decode($response->getContent(), true);
                        if (isset($data['errors']))
                            return Redirect::route('manage')->with('error', $data['errors']['message']);
                    }
                    $destination_path = public_path('images/home');
                    $name = Input::file($i)->getClientOriginalName();
                    $file = Input::file($i)->move($destination_path, $name);
                    $check_error = Input::file($i)->getError();
                    if($check_error != "UPLOADERROK")
                        return Redirect::route('manage')->with('error', trans('message.upload_file_failed'));
                    $saved_file = array(
                        'name' => $file->getFilename(),
                        'type' => 'SLIDER',
                    );
                    $response = $fileInstance->store($saved_file);
                    $data = json_decode($response->getContent(),true);
                    if (isset($data['errors'])) {
                        return Redirect::route('manage')->with('error', $data['errors']['message']);
                    }else
                        return Redirect::route('manage')->with('success', trans('message.upload_file_successfully'));
                }
            }
        }
//        advertisement
        if(Input::hasFile('advertisement'))
            if(Input::file('advertisement')->getSize() < 500000 && Input::file('advertisement')->isValid()){
                $fileInstance = new File();
                if (!empty(Input::get("hidden_advert"))) {
//                        delete old advert image
                    $response = $fileInstance->remove(Input::get('hidden_advert'));
                    $data = json_decode($response->getContent(), true);
                    if (isset($data['errors']))
                        return Redirect::route('manage')->with('error', $data['errors']['message']);
                }
                $destination_path = public_path('images/home');
                $name = Input::file('advertisement')->getClientOriginalName();
                $file = Input::file('advertisement')->move($destination_path, $name);
                $check_error = Input::file('advertisement')->getError();
                if($check_error != "UPLOADERROK")
                    return Redirect::route('manage')->with('error', trans('message.upload_file_failed'));
                $saved_file = array(
                    'name' => $file->getFilename(),
                    'type' => 'ADVERTISEMENT',
                );
                $response = $fileInstance->store($saved_file);
                $data = json_decode($response->getContent(),true);
                if (isset($data['errors'])) {
                    return Redirect::route('manage')->with('error', $data['errors']['message']);
                }else
                    return Redirect::route('manage')->with('success', trans('message.upload_file_successfully'));
            }

        return Redirect::route('manage');
    }

    public function deleteBanner(){
        $fileInstance = new File();
        $banner_id = json_decode(Input::get('id'));
        $response = $fileInstance->remove($banner_id);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']))
            Session::flash('errors',$data['errors']['message']);
        else
            Session::flash('success',trans('message.delete_image_successfully'));
    }

    public function search($key){
        $product_model = new Product();
        $response = $product_model->search($key);
        $data = json_decode($response->getContent(), true);
        if (isset($data['errors']) || empty($data['products'])){
            echo trans('message.product_not_exist');
        }else {
            $products = $data['products'];
            $data = "";
            foreach ($products as $product) {
                $data = $data . "<div class='line'>";
                $data = $data . '<a href="/products/' . $product['sku'] . '" target="blank">';
                $data = $data . '<img id="result_image" src="' . $product['image_url'] . '"/>';
                $data = $data . "<div class='result_data' id='result_name'>" . $product['name'] . "</div>";
                $data = $data . "<div class='result_data' id = 'result_sku'>" . $product['sku'] . "</div>";
                $data = $data . "<input type='hidden' class='hidden_data' value='" . $product['id'] . "'>" . "</a>";
                $data = $data . "</div>";
            }
            echo $data;
        }
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

    public function sessionDestroy(){
        Session::flush();
        return Redirect::route('/');
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