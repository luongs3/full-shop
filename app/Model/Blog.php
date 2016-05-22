<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Model;

use Response;

class Blog extends BaseModel{

    protected $table = "post";
    protected $fillable = ['id','user_id','image_id','title','subcontent','content','active'];
    
    public function __construct($attributes = array()){
        parent::__construct($attributes);
        $this->setModelClass('App\Model\Blog');
        $this->setSingularKey('post');
        $this->setPluralKey('posts');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function image(){
        return $this->hasOne(File::class,'id','image_id');
    }

    public function index($filter=array('limit'=>10)){
        $model_class = $this->getModelClass();
        try {
            $posts = $model_class::orderBy("updated_at", "DESC")->paginate($filter['limit']);
            if (!$posts)
                return Response::json(['errors' => ['message' => trans('message.post_not_exist')]]);
            foreach ($posts as $key => $val) {
                $user_name = $val->user->name;
                if (!empty($val->image_id)) {
                    $file = new File();
                    $response = $file->show($val->image_id);
                    $data = json_decode($response->getContent(), 'true');
                    if (isset($data['errors']))
                        return Response::json(['errors' => ['message' => $data['errors']['message']]]);
                    $file = $data['file'];
                    $posts[$key]['image_url'] = $file['url'];
                }
                $posts[$key]['user_name'] = $user_name;
                $temp = explode(" ",$val->created_at);
                $posts[$key]['date'] = $temp[0];
                $posts[$key]['time'] = date('H:i',strtotime($temp[1]));
            }

            return $posts;
        } catch (Exception $e) {
            return Response::json(['errors' => ['message' => $e->getMessage()]]);
        }
    }
    public function show($id = null){
        $model_class = $this->getModelClass();
        try {
            $model = $model_class::find($id);
            if (!$model)
                return Response::json(['errors' => ['message' => trans('message.'.$this->getSingularKey(). '_not_exist')]]);
            $model->user_name = $model->user->name;
            if (!empty($model->image_id)) {
                $file = new File();
                $response = $file->show($model->image_id);
                $data = json_decode($response->getContent(), 'true');
                if (isset($data['errors']))
                    return Response::json(['errors' => ['message' => $data['errors']['message']]]);
                $file = $data['file'];
                $model->image_url = $file['url'];
            }
            $temp = explode(" ",$model->created_at);
            $model->date = $temp[0];
            $model->time = date('H:i',strtotime($temp[1]));
            return Response::json([$this->getSingularKey() => $model]);
        } catch (Exception $e) {
            return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
        }
    }
}