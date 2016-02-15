<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use PhpSpec\Exception\Exception;
use Response;
use Lang;

class Category extends Model{
    protected $table = "category";
    public $timestamps = false;
    protected $fillable = ['name','description','parent_id'];

    public function show($id = null){
        try{
            $category = Category::find($id);
            if(!$category)
                return Response::json(['errors' => ['message' => trans('message.category_not_exist')]]);
            return Response::json(['category' => $category]);
        }catch (Exception $e){
            return Response::json(['errors' => ['message' => $e->getMessage()]]);
        }
    }
    public function index($filter=array())
    {
        try {
            $categories = Category::orderBy("id", "DESC")->paginate($filter['limit']);
            if (!$categories)
                return Response::json(['errors' => ['message' => trans('message.category_not_exist')]]);
            return $categories;
        } catch (Exception $e) {
            return Response::json(['errors' => ['message' => $e->getMessage()]]);
        }
    }
    public function store($category){
        $model = new Category($category);
        try {
            $model->save();
            return Response::json(['category' => $model]);
        } catch (Exception $e) {
            return [
                Response::json(['errors' => [
                    'code' => $e->getCode(), 'message' => $e->getMessage()
                ]
            ])];
        }
    }

    public function getAll(){
        try {
            $categories = Category::get();
            if (!$categories)
                return Response::json(['errors' => ['message' => trans('message.category_not_exist')]]);
            return Response::json(['categories' => $categories]);
        } catch (Exception $e) {
            return Response::json(['errors' => ['message' => $e->getMessage()]]);
        }
    }
    public function updateCategory($category){
        try{
            $model = Category::find(array_get($category,'id'));
            if(!$model)
                return Response::json([
                    'errors' => ['message' => trans('message.category_not_exist')]
                ]);
            $model->fill($category);
            $model->save();
            return Response::json(['category' => $model]);
        }catch (Exception $e){
            return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
        }
    }

    public function deleteCategory($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return Response::json([
                    'errors' => [
                        ['code' => 'not_exist', 'message' => Lang::get('message.category_not_exist')]
                    ]
                ]);
            }
            $category->delete();
            return Response::json(['category' => $category ]);
        }catch (Exception $e){
            return Response::json([
                'errors' => [
                    ['code' => $e->getCode(), 'message' => $e->getMessage()]
                ]
            ]);
        }
    }
}