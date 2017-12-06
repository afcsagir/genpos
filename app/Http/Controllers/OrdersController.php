<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\SoldProduct;
use Illuminate\Support\Facades\Auth;

 
class OrdersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function showOrders()
	{
		$news = SoldProduct::where('status', 'new')->orderBy('user_id')->get();

		$processings = SoldProduct::where('status', 'processing')->orderBy('user_id')->get();

		$completes = SoldProduct::where('status', 'complete')->orderBy('user_id')->get();

		return view('orders')->with('news', $news)->with('processings', $processings)->with('completes', $completes);
	}

	public function processOrder($orderId)
	{
		$process = SoldProduct::where('id', $orderId)->first();

		$process->status = "processing";
		$process->save();

		return redirect('/orders');
	}

	public function deliverOrder($orderId)
	{
		$process = SoldProduct::where('id', $orderId)->first();

		$process->status = "complete";
		$process->save();

		return redirect('/orders');
	}
}