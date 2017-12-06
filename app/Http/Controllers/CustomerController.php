<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Customer;

class CustomerController extends Controller
{
	public function showAddCustomer() {

		$customers = DB::table('customers')->get();

		return view('add_customer_form')->with('customers', $customers);
	}

	public function postCustomerData(Request $request){

              $name = $request->name;
              $email = $request->email;
              $address = $request->address;
              $city = $request->city;
              $phone = $request->phone;
              $zip = $request->zip;

              $customer = Customer::where('email', $email)->first();

              if (!$customer) {
              	$customer = new Customer();
              	$customer->name = $name;
              	$customer->email = $email;
              	$customer->address = $address;
              	$customer->city = $city;
              	$customer->phone = $phone;
              	$customer->zip = $zip;

              	$customer->save();

              	//$customers = App\Customer::all();
              	//$customers = DB::table('customers')->get();

              	return redirect('/customer');

              } else { 

              	//$customers = App\Customer::all();
              	$customers = DB::table('customers')->get();
              	
              	return view('add_customer_form', ['cusExists' => 'Customer with this email already exists'])->with('customers', $customers);

              }

    }

    public function updateCustomerData (Request $request) 
    {
    		  $customerId = $request->customerId;
    		  $name = $request->name;
              $email = $request->email;
              $address = $request->address;
              $city = $request->city;
              $phone = $request->phone;
              $zip = $request->zip;

              $dbCustomer = Customer::where('id', $customerId)->first();

              if ($email !== $dbCustomer->email) {

              $newCustomer = Customer::where('email', $email)->first();

              if (!$newCustomer) {
              	$customer = Customer::where('id', $customerId)->first();
              	//$customer = new Customer();
              	$customer->name = $name;
              	$customer->email = $email;
              	$customer->address = $address;
              	$customer->city = $city;
              	$customer->phone = $phone;
              	$customer->zip = $zip;

              	$customer->save();

              	//$customers = App\Customer::all();
              	//$customers = DB::table('customers')->get();

              	return redirect('/customer');

              } else { 

              	//$customers = App\Customer::all();
              	$customers = DB::table('customers')->get();
              	
              	return view('add_customer_form', ['cusExists' => 'Customer with this email already exists'])->with('customers', $customers);

              }

              } else {
              	$customer = Customer::where('id', $customerId)->first();
              	//$customer = new Customer();
              	$customer->name = $name;
              	$customer->email = $email;
              	$customer->address = $address;
              	$customer->city = $city;
              	$customer->phone = $phone;
              	$customer->zip = $zip;

              	$customer->save();

              	//$customers = App\Customer::all();
              	//$customers = DB::table('customers')->get();

              	return redirect('/customer');
              } 
    }

    public function showEditCustomerData($customerId)
    {
    	$getCustomerData = \DB::table('customers')->where('id', $customerId)->first();

    	return view('edit_customer_form', ['getCustomerData' => $getCustomerData]);
    }


              
}