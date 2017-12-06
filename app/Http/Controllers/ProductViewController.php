<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Product;
use App\Attribute;
use App\Variance;
use App\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;



class ProductViewController extends Controller
{
	public function getProduct($productId)
	{
		

    	
		$product = Product::where('id', $productId)->first();

		$attributes = Attribute::where('product_id', $productId)->get();

		$variance = Variance::where('product_id', $productId)->where('status', 'valid')->get();

		$getrevs = Review::where('product_id', $productId)->get();

//		$varJSON = json_encode($variance);

		return view('product', ['product' => $product, 'attributes' => $attributes, 'variance' => $variance, 'getrevs' => $getrevs]);
	}

	public function getCategory($catName, $subName, Request $request)
	{
		if (isset($catName) && ($subName == 'All') && !isset($request['sortby'])){

			$products = DB::table('products')
						->where('category', $catName)
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '1';

		} else if (isset($catName) && ($subName !== 'All') && !isset($request['sortby'])){

			$products = DB::table('products')
						->where('category', $catName)->where('sub', $subName)
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '2';

		} else if (isset($catName) && ($subName == 'All') && ($request['sortby'] == 'nameA')){

			$products = DB::table('products')
						->where('category', $catName)
						->orderBy('name', 'asc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '3';//ucfirst($subName);

		} else if (isset($catName) && ($subName !== 'All') && ($request['sortby'] == 'nameA')){

			$products = DB::table('products')
						->where('category', $catName)->where('sub', $subName)
						->orderBy('name', 'asc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '4';//ucfirst($subName);

		} else if (isset($catName) && ($subName == 'All') && ($request['sortby'] == 'nameD')){

			$products = DB::table('products')
						->where('category', $catName)
						->orderBy('name', 'desc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '5';//ucfirst($subName);

		} else if (isset($catName) && ($subName !== 'All') && ($request['sortby'] == 'nameD')){

			$products = DB::table('products')
						->where('category', $catName)->where('sub', $subName)
						->orderBy('name', 'desc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '6';//ucfirst($subName);

		} else if (isset($catName) && ($subName == 'All') && ($request['sortby'] == 'priceA')){

			$products = DB::table('products')
						->where('category', $catName)
						->orderBy('min', 'asc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '7';//ucfirst($subName);

		} else if (isset($catName) && ($subName !== 'All') && ($request['sortby'] == 'priceA')){

			$products = DB::table('products')
						->where('category', $catName)->where('sub', $subName)
						->orderBy('min', 'asc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '8';//ucfirst($subName);
		} else if (isset($catName) && ($subName == 'All') && ($request['sortby'] == 'priceD')){

			$products = DB::table('products')
						->where('category', $catName)
						->orderBy('min', 'desc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '9';//ucfirst($subName);

		} else if (isset($catName) && ($subName !== 'All') && ($request['sortby'] == 'priceD')){

			$products = DB::table('products')
						->where('category', $catName)->where('sub', $subName)
						->orderBy('min', 'desc')
						->paginate(8);

			$catName = ucfirst($catName);
			$subName = ucfirst($subName);
			//$subName2 = '10';//ucfirst($subName);
		}

		

		return view('category', ['products' => $products, 'catName' => $catName, 'subName' => $subName]);
		
	}

	public function postReview(Request $request)
	{
		//Auth::user()->id
		$review = new Review();
		$review->user_id = Auth::user()->id;
		$review->product_id = $request['productId'];
		$review->revheader = $request['revheader'];
		$review->revpara = $request['revpara'];
		$review->save();

		//getProduct(Auth::user()->id);


		$product = Product::where('id', $request['productId'])->first();

		$attributes = Attribute::where('product_id', $request['productId'])->get();

		$variance = Variance::where('product_id', $request['productId'])->where('status', 'valid')->get();

		$getrevs = Review::where('product_id', $request['productId'])->get();

//		$varJSON = json_encode($variance);

		return view('product', ['product' => $product, 'attributes' => $attributes, 'variance' => $variance, 'getrevs' => $getrevs]);
	}
}