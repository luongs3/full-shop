<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\File;
use Response;

class Product extends Model
{
	protected $table = "product";
	/**
	 * API Resource
	 *
	 * @var string
	 */
	protected $resource = 'products';
	protected $fillable = ['id','name','description','price','sku','attributes','view','buy_times','brand','sale_price','category_id','status','quantity','image_id'];
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	public function getAll($attributes = array()){
		return Response::json(['products' => Product::all($attributes)]);
	}

	public function getCategoryProducts($category_id, $filter=array()){
		try {
			$products = Product::where('category_id',$category_id)->orderBy($filter['order-by'],$filter['direction'])->paginate($filter['limit']);
			if(empty($products))
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			foreach ($products as $product) {
				if(!empty($product->image_id)){
					$file = new File();
					$response = $file->show($product->image_id);
					$data = json_decode($response->getContent(),'true');
					if (isset($data['errors']))
						return Redirect::route('products.manage')->with('error', $data['errors']['message']);
					$file = $data['file'];
					$product->image_id = $file['id'];
					$product->image_url = "/images/product/" . $file['name'];
				}
				$product->price = number_format($product->price);
			}
			return $products;
		} catch (Exception $e) {
			return Response::json(['errors' => [
				'code' => $e->getCode(), 'message' => $e->getMessage()
			]
			]);
		}


	}
	public function show($id = null){
		try{
			$product = Product::find($id);
			if(!$product)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			if(!empty($product->image_id)){
				$file = new File();
				$response = $file->show($product->image_id);
				$data = json_decode($response->getContent(),'true');
				if (isset($data['errors']))
					return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
				$file = $data['file'];
				$product->price = number_format($product->price);
				$product->image_id = $file['id'];
				$product->image_url = "/images/product/" . $file['name'];

			}
			return Response::json(['product' => $product]);
		}catch (Exception $e){
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}
	public function index($filter=array())
	{
		try {
			$products = Product::orderBy("id", "DESC")->paginate($filter['limit']);
			foreach ($products as $key => $val) {
				$products[$key]->price = number_format($val->price);
			}

			if (!$products)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			return $products;
		} catch (Exception $e) {
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}
	public function store($product){
		$model = new Product($product);
		try {
			$model->save();
			return Response::json(['product' => $model]);
		} catch (Exception $e) {
			return
				Response::json(['errors' => [
					'code' => $e->getCode(), 'message' => $e->getMessage()
				]
				]);
		}
	}

	public function getSku($sku=null)
	{
		try{
			$product = Product::where('sku',$sku)->first();
			if(!$product)
				return Response::json(['errors' => ['message' => trans('message.product_not_exist')]]);
			if(isset($product->image_id)){
				$file = new File();
				$response = $file->show($product->image_id);
				$data = json_decode($response->getContent(),'true');
				if (isset($data['errors']))
					return Redirect::route('products.manage')->with('error', $data['errors']['message']);
				$file = $data['file'];
				$product->image_id = $file['id'];
				$product->image_url = "/images/product/" . $file['name'];
				$product->price = number_format($product->price);
			}
			return Response::json(['product' => $product]);
		}catch (Exception $e){
			return Response::json(['errors' => ['message' => $e->getMessage()]]);
		}
	}

	public function updateProduct($product){
		try{
			$model = Product::find(array_get($product,'id'));
			if(!$model)
				return Response::json([
					'errors' => ['message' => trans('message.product_not_exist')]
				]);
			$model->fill($product);
			$model->save();
			return Response::json(['product' => $model]);
		}catch (Exception $e){
			return Response::json(['errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]]);
		}
	}

	public function deleteProduct($id){
		try {
			$product = Product::find($id);
			if (!$product) {
				return [
					'errors' => [
						'code' => 'not_exist', 'message' => Lang::get('message.product_not_exist')
					]
				];
			}
			$product->delete();
			return Response::json(['product' => $product ]);
		}catch (Exception $e){
			return Response::json([
				'errors' => [
					['code' => $e->getCode(), 'message' => $e->getMessage()]
				]
			]);
		}
	}
}
