<?php
 
namespace App\Http\Controllers;
use App\Cart;
use App\Product;
use App\CartItem;
use App\Variance;
use App\SoldProduct;

use Illuminate\Support\Facades\Auth;
 
use Illuminate\Http\Request;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
class CartController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function addItem ($varianceId, $quantity){
		
 
        $cart = Cart::where('user_id',Auth::user()->id)->first();
 
        if(!$cart){
            $cart =  new Cart();
            $cart->user_id=Auth::user()->id;
            $cart->save();
        }
 
        $cartItem  = new CartItem();
        $cartItem->variance_id=$varianceId;
        $cartItem->cart_id=$cart->id;
        $cartItem->quantity=$quantity;
        $cartItem->save();

        $cart->count = ($cart->count)+$quantity;
        $cart->save();
 
        return redirect('/pos');
 
    }
 
    public function showCart(){
        $cart = Cart::where('user_id',Auth::user()->id)->first();

        if(!$cart){
            $cart = new Cart();
            $cart->user_id=Auth::user()->id;
            $cart->save();
        }
 
        //$items = $cart->cartItems;
		    $items = CartItem::where('cart_id', $cart->id)->where('status', 'valid')->get();

        $total=0;
        foreach($items as $item){
             	$total+=($item->variance->price)*($item->quantity);
          //dd($item->variance->price);
        }
        		//dd($items);
        

 
        return view('view', ['userId'=>Auth::user()->id, 'total'=>$total])->with('items', $items);

    }
 
    public function removeItem($itemId){
            //dd($itemId);
        $cart = Cart::where('user_id',Auth::user()->id)->first();
        //$cart->count = ($cart->count)-1;
        $cartItem = CartItem::where('id', $itemId)->first();
        $cart->count = ($cart->count) - ($cartItem->quantity);
        $cart->save();

        CartItem::destroy($itemId);

        
        //$cart->save();



        return redirect('/pos');
    }
    //Shipping Info Controller
    public function shipping()
        {
            return view('shipping-info');
        }
    
    public function checkOut($userId)
    {
      $getuserData = \DB::table('users')->where('id', $userId)->first();
                //dd($getPakData->pckg_code);
                //dd($getuserData);
                return view('checkout')->with('getuserData', $getuserData);
    }
    /*public function checkOut()
            {

                return view('checkout');
            }*/
    public function profile()
    {

         $id = \Auth::user()->id;
          $user = \DB::table('users')
          ->where('id',$id)
          ->get();
          //dd($user);
          //->with('users', $users);

          $items = SoldProduct::where('user_id', $id)->where('status', 'new')->orWhere('user_id', $id)->where('status', 'processing')->get();

          $histories = SoldProduct::where('user_id', $id)->where('status', 'complete')->get();

          $total=0;
          foreach($histories as $history){
                $total+=$history->variance->price;
            //dd($item->variance->price);
          }

          $loyaltyPoints = $total*0.01;

               // return view('home',$UserId);
      return view('profile', ['loyaltyPoints' => $loyaltyPoints])->with('user', $user)->with('items', $items)->with('histories', $histories);
    }


     public function editUserData($userId)
        {


                $getuserData = \DB::table('users')->where('id', $userId)->first();
                //dd($getPakData->pckg_code);
                //dd($getuserData);
                return view('edit_user_form')->with('getuserData', $getuserData);
        }

         public function getUserData(Request $request)
           {



              $name =$request->name;
              $email =$request->email;
              $address1 = $request->address1;
               $deliveryaddress =$request->deliveryaddress;
               $city =$request->city;
               $phone = $request->phone;
               $zip =$request->zip;
               $country =$request->country;
              $id  = $request->id;

              //dd( $request->hiddenId);
              //$packgCode      = $request->packgCode;
               $insert_user = array(

                            'name'=> $name,
                                'email' =>$email,
                                'address1' => $address1,
                                 'deliveryaddress' =>$deliveryaddress,
                                 'city' =>$city,
                                 'phone' => $phone,
                                 'zip' =>$zip,
                                 'country' =>$country,

                  //'pckg_volum' => $packVol,
                  );
               //dd($insert_user);

               if ($id) {
                    \DB::table('users')->where('id',$id)->update($insert_user);
                  }

            return redirect('/profile');
           }

           public function getPostCheckOut(Request $request)
           {



              $name =$request->name;
              $email =$request->email;
              $address1 = $request->address1;
              $deliveryaddress =$request->deliveryaddress;
              $city =$request->city;
              $phone = $request->phone;
              $zip =$request->zip;
              $country =$request->country;
              $id  = $request->id;
              $checkOutMethod = $request->checkOutMethod;

              //dd( $request->hiddenId);
              //$packgCode      = $request->packgCode;
               $insert_user = array(

                            'name'=> $name,
                                'email' =>$email,
                                'address1' => $address1,
                                 'deliveryaddress' =>$deliveryaddress,
                                 'city' =>$city,
                                 'phone' => $phone,
                                 'zip' =>$zip,
                                 'country' =>$country,

                  //'pckg_volum' => $packVol,
                  );
               //dd($insert_user);

               if ($id) {
                    \DB::table('users')->where('id',$id)->update($insert_user);
                  }

            $cartId = Cart::where('user_id', $id)->first();
            $soldItems = CartItem::where('cart_id', $cartId->id)->where('status', 'valid')->get();

            //$cart = Cart::where('user_id',Auth::user()->id)->first();
            //$cartItem = CartItem::where('id', $itemId)->first();
            //$cart->count = ($cart->count) - ($soldItem->quantity);
            //$cart->save();

            foreach ($soldItems as $key => $soldItem) {
              $cartId->count = ($cartId->count) - ($soldItem->quantity);
              $cartId->save();

              $sold = new SoldProduct;
              //save and make invalid
              $sold->user_id = $id;
              $sold->variance_id = $soldItem->variance_id;

              $variant = Variance::where('id', $soldItem->variance_id)->first();
              $variant->quantity = ($variant->quantity) - ($soldItem->quantity);
              $variant->save();

              $product = Product::where('id', $variant->product_id)->first();
              $product->quantity = ($product->quantity) - ($soldItem->quantity);
              $product->save();

              $sold->status = 'new';
              $sold->quantity = $soldItem->quantity;
              $sold->save();

              $soldItem->status = 'invalid';
              $soldItem->save();
            }
            
            $items = SoldProduct::where('user_id', $id)->where('status', 'new')->get();

            if ($checkOutMethod == 'cod') {
              return view('sold')->with('items', $items);
            }
            if ($checkOutMethod == 'cc') {
              return redirect('/cc');
            }
           }

           public function getCC ()
           {
            return view('ccard');
           }

}