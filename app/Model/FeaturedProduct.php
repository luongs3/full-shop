<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Product;
use Response;

class FeaturedProduct extends Model
{
	protected $table = "featured_product";
	protected $fillable = ['id','product_id','updated_at'];


	public function getAll($filter=array()){
		try {
			$product_model = new Product();
			$products = FeaturedProduct::orderBy("updated_at", "DESC")->take($filter['limit'])->get();
			if (!$products)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			foreach ($products as $key => $val) {
				$temp_val = $val->getAttributes();
				$response = $product_model->show($temp_val['product_id']);
				$data = json_decode($response->getContent(),true);
				$product = $data['product'];
				$products[$key]['name'] = $product['name'];
				$products[$key]['price'] = $product['price'];
				$products[$key]['image_url'] = array_get($product,'image_url');
				$products[$key]['sku'] = $product['sku'];
			}
			return Response::json(['featuredProducts' => $products]);
		} catch (Exception $e) {
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}

	public function index($filter=array())
	{
		$product_model = new Product();
		try {
			$products = FeaturedProduct::orderBy("updated_at", "DESC")->paginate($filter['limit']);
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
	public function store($product){
		$model = new FeaturedProduct($product);
		try {
			$model->save();
			return Response::json(['featuredProduct' => $model]);
		} catch (Exception $e) {
			return [
				Response::json(['errors' => [
					'code' => $e->getCode(), 'message' => $e->getMessage()
				]
				])];
		}
	}

	public function updateFeaturedProduct($product){
		try{
//			find based on product id
			$model = FeaturedProduct::where('product_id',$product['product_id'])->first();
			if(!$model)
				return Response::json([
					'errors' => ['message' => trans('message.product_not_exist')]
				]);
			$product['updated_at'] = time();
			$model->fill($product);
			$model->save();
			return Response::json(['featuredProduct' => $model]);
		}catch (Exception $e){
			return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
		}
	}

	public function deleteFeaturedProduct($id){
		try {
			$product = FeaturedProduct::find($id);
			if (!$product) {
				return [
					'errors' => [
						'code' => 'not_exist', 'message' => Lang::get('message.product_not_exist')
					]
				];
			}
			$product->delete();
			return Response::json(['featuredProduct' => $product ]);
		}catch (Exception $e){
			return Response::json([
				'errors' => [
					['code' => $e->getCode(), 'message' => $e->getMessage()]
				]
			]);
		}
	}
	public function showProduct($id = null)
	{
		try{
			$featured_product = FeaturedProduct::where('product_id',$id)->first();
			if(!$featured_product)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			return Response::json(['featuredProduct' => $featured_product]);
		}catch (Exception $e){
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}
}
