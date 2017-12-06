<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Attribute;
use App\Variance;
use App\Cart;
use App\CartItem;
use App\Customer;

use Illuminate\Http\Request;
use App\Http\Requests;

class PosController extends Controller
{
	public function getProduct()
	{
		// if(\Auth::check()){
		// 	$cart = DB::table('carts')->where('user_id',Auth::user()->id)->first();

	    //     if(!$cart){
	    //         $cart =  new Cart();
	    //         $cart->user_id=Auth::user()->id;
	    //         $cart->save();
	    //     }
    	// }

    	//$items = CartItem::where('cart_id', $cart->id)->where('status', 'valid')->get();

        // $total=0;
        // foreach($items as $item){
        //      	$total+=($item->variance->price)*($item->quantity);
        //   //dd($item->variance->price);
        // }
        		//dd($items);



        //return view('view', ['userId'=>Auth::user()->id, 'total'=>$total])->with('items', $items);


		$products = Variance::where('status','valid')->get();//DB::table('products')->get();

		$cartAd = DB::table('cart_items')->orderBy('id','DESC')->take(5)->get();
		$users = Customer::pluck('name','id')->toArray();
		//dd($cartAd);

		 //dd($postsNew);
		//return view('pos')->with(['cartAd' => $cartAd ])->render();
		 // Return View::make('pos', compact('$cartAd'));
		//return response()->json($cartAd);
					//->where('tag', 'featureYes')
					//->paginate(16);

		//$title = 'Featured';

		//dd($products);
		//return view('posts.index')->with('postsNew', $postsNew);

	// $users = Customer::pluck('name','id')->toArray();
  //   return view('pos',compact('users'));


		return view('pos')->with('products', $products)->with('cartAd', $cartAd)->with('users', $users);
		//['products' => $products, 'userId'=>Auth::user()->id, 'total'=>$total]); //->with('items', $items);
	}

	//public function testfunction(Illuminate\Http\Request $request)
    //{
    //    return response()->json(['response' => 'This is get method']);
    //}

    public function testFunction(){
		if(\Request::ajax()){



			if(\Auth::check()){
				$cart = DB::table('carts')->where('user_id',Auth::user()->id)->first();

		        if(!$cart){
		            $cart = new Cart();
		            $cart->user_id=Auth::user()->id;
		            $cart->save();
		        }
	    	}

	    	$items = CartItem::where('cart_id', $cart->id)->where('status', 'valid')->get();

	    	//$item = CartItem::where('cart_id', $cart->id)->where('status', 'valid')->order_by('upload_time', 'desc')->first();



	        /*$total=0;
	        foreach($items as $item){
	             	$total+=($item->variance->price)*($item->quantity);
	          //dd($item->variance->price);
	        }*/



			return response()->json($items);
	        //return response()->json($item);
			//return 'getRequest has loaded completely.';
		}
	}
	public function addProductsCarts(Request $request){
		// $data = $request->all(); // This will get all the request data.
		//       dd($data);


		//$post = new post;
		$CartItem =new CartItem;
		$CartItem->variance_id = $request->id;
		$CartItem->quantity	 = $request->quantity;
		$CartItem->combo	 = $request->combo;
		$CartItem->price	 = $request->price;
		$CartItem->customer_id	 = $request->users;
		
		
		
		//$CartItem->cart_id	 = $request->quantity;

		$CartItem->save();
		return response()->json($CartItem);
	}
	public function getData()
	{
		//$posts = Post::orderBy('id', 'desc')->get();
		$cartAd = DB::table('cart_items')->orderBy('id','DESC')->take(5)->get();
		//dd($cartAd);

		 //dd($postsNew);
		//return view('pos')->with(['cartAd' => $cartAd ])->render();
		 // Return View::make('pos', compact('$cartAd'));
		return response()->json($cartAd);
	}


}
