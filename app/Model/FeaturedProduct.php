<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Product;
use Response;

class FeaturedProduct extends BaseModel
{
	protected $table = "featured_product";
	protected $fillable = ['id','product_id'];


	public function __construct($attributes = array()){
		parent::__construct($attributes);
		$this->setModelClass('App\Model\FeaturedProduct');
		$this->setSingularKey('featuredProduct');
		$this->setPluralKey('featuredProducts');
	}

	public function getAll($filter = array(), $order = array()){
		try {
			$model_class = $this->getModelClass();
			$product_model_class = new Product();
			$products = $model_class::orderBy("updated_at", "DESC")->take($filter['limit'])->get();
			if (!$products)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			foreach ($products as $key => $val) {
				$temp_val = $val->getAttributes();
				$response = $product_model_class->show($temp_val['product_id']);
				$data = json_decode($response->getContent(),true);
				$product = $data['product'];
				$products[$key]['name'] = $product['name'];
				$products[$key]['price'] = $product['price'];
				$products[$key]['ratio'] = $product['ratio'];
				$products[$key]['sale_price'] = $product['sale_price'];
				$products[$key]['image_url'] = array_get($product,'image_url');
				$products[$key]['sku'] = $product['sku'];
			}
			return Response::json([$this->getPluralKey() => $products]);
		} catch (Exception $e) {
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}

	public function index($filter=array()){
		$model_class = $this->getModelClass();
		$product_model = new Product();
		try {
			$products = $model_class::orderBy("updated_at", "DESC")->paginate($filter['limit']);
			if (!$products)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			foreach ($products as $key => $val) {
				$temp_val = $val->getAttributes();
				$response = $product_model->show($temp_val['product_id']);
				$data = json_decode($response->getContent(),true);
				$product = $data['product'];
				$products[$key]['name'] = $product['name'];
				$products[$key]['sku'] = $product['sku'];
			}
			return $products;
		} catch (Exception $e) {
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}

	public function updateItem($product){
		try{
//			find based on product id
			$model_class = $this->getModelClass();
			$model = $model_class::where('product_id',$product['product_id'])->first();
			if(!$model)
				return Response::json([
					'errors' => ['message' => trans('message.product_not_exist')]
				]);
			$product['updated_at'] = time();
			$model->fill($product);
			$model->save();
			return Response::json([$this->getSingularKey() => $model]);
		}catch (Exception $e){
			return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
		}
	}
	public function show($id = null)
	{
		$model_class = $this->getModelClass();
		try{
			$featured_product = $model_class::where('product_id',$id)->first();
			if(!$featured_product)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			return Response::json([$this->getSingularKey() => $featured_product]);
		}catch (Exception $e){
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}
}
