<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SoldProduct;
use App\Variance;
use App\Customer;
use App\Product;
use App\Employee;
use App\EmployeeResult;

class ReportController extends Controller
{
	public function showReportByDate ($time = null, Request $request) 
	{
		if (($time !== null) && ($time == 'today')) {
			$time = date("Y-m-d");
			$sales = DB::table('sold_products')->whereDate('updated_at', $time)->get();
			return view('report-by-date')->with('sales', $sales);

		} else if (($time !== null) && ($time == 'seven')) {
			$time = new \DateTime;//date("Y-m-d");
			$time7 = new \DateTime;
			$time7 = date_modify($time7, "-7 days");

			$time = $time->format("Y-m-d");
			$time7 = $time7->format("Y-m-d");

			$sales = DB::table('sold_products')->whereBetween('updated_at', [$time7, $time])->get();
			return view('report-by-date')->with('sales', $sales);

		} else if (($time !== null) && ($time == 'month')) {
			$time = date("m");
			$sales = DB::table('sold_products')->whereMonth('updated_at', $time)->get();
			return view('report-by-date')->with('sales', $sales);

		} else if (($time !== null) && ($time == 'lastmonth')) {
			$time7 = new \DateTime;
			$time7 = date_modify($time7, "-1 month");

			//$time = $time->format("Y-m-d");
			$time7 = $time7->format("m");

			$sales = DB::table('sold_products')->whereMonth('updated_at', $time7)->get();
			return view('report-by-date')->with('sales', $sales);

		} else if (($time !== null) && ($time == 'year')) {
			$time7 = new \DateTime;
			//$time7 = date_modify($time7, "-1 month");

			//$time = $time->format("Y-m-d");
			$time7 = $time7->format("Y");

			$sales = DB::table('sold_products')->whereYear('updated_at', $time7)->get();
			return view('report-by-date')->with('sales', $sales);

		} else if (($time !== null) && ($time == 'lastyear')) {
			$time7 = new \DateTime;
			$time7 = date_modify($time7, "-1 year");

			//$time = $time->format("Y-m-d");
			$time7 = $time7->format("Y");

			$sales = DB::table('sold_products')->whereYear('updated_at', $time7)->get();
			return view('report-by-date')->with('sales', $sales);

		} else if (($time == null) && ($request['from'] !== null) && ($request['to'] !== null)) {
			$timeFrom = $request['from'];
			$timeTo = $request['to'];

			//$timeFrom = $timeFrom->format("Y-m-d");
			//$timeTo = $timeTo->format("Y-m-d");
			$sales = DB::table('sold_products')->whereBetween('updated_at', [$timeFrom, $timeTo])->get();
			return view('report-by-date', ['timeFrom' => $timeFrom, 'timeTo' => $timeTo])->with('sales', $sales);
		}


		$sales = DB::table('sold_products')->whereDate('updated_at', $time)->get();
		return view('report-by-date')->with('sales', $sales);
	}


	public function showReportByProduct ()
	{
		//$products = DB::table('sold_products')
		$products = SoldProduct::
						select('variance_id', DB::raw('(count(*) + SUM(quantity) ) AS tquantity'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->groupBy('variance_id')
						//->sum('total', '+', 'quantity')
						->orderBy('tquantity', 'desc')
						->get();

		//for ($i = 0; $i < count($products); $i++) {
		//	$products[$i]->total += $products[$i]->quantity;
		//}
		
		//$products->orderBy('total');

		return view('report-by-product')->with('products', $products);
	}

	public function uploadOldSalesData (Request $request)
	{
		if ($request['file'] !== null) {
			$file = $request->file('file');
			$fileOpen = fopen($file,'r');
			$fileDatas = array();
			while(! feof($fileOpen)) {
					array_push($fileDatas, fgetcsv($fileOpen));
				}
			fclose($fileOpen);
			//dd($fileDatas);
		} else {
			$fileDatas[0][0] = 'hello';
			$fileDatas[0][1] = 'major tom';
			$fileDatas[1][0] = 'shello';
			$fileDatas[1][1] = 'smajor tom';
		}

		//dd($fileDatas);
		$cannotFind = array();

		for ($i = 0; $i < count($fileDatas); $i++) {
			
			$dbMatch = Customer::where('name', $fileDatas[$i][0])->first();

			if (!$dbMatch) {
				array_push($cannotFind, $fileDatas[$i]);
			} else {
				$dbMatch->purchased = $dbMatch->purchased + $fileDatas[$i][1];
				$dbMatch->save();
			}
		}
		return view('oldsalesdata')->with('fileDatas', $fileDatas)->with('cannotFind', $cannotFind);
	}

	public function uploadOldItems (Request $request)
	{
		if ($request['file'] !== null) {
			$file = $request->file('file');
			$fileOpen = fopen($file,'r');
			$fileDatas = array();
			while(! feof($fileOpen)) {
					array_push($fileDatas, fgetcsv($fileOpen));
				}
			fclose($fileOpen);
			//dd($fileDatas);

				for ($i = 0; $i < count($fileDatas); $i++) {

				$item = new Product();
				$item->name = $fileDatas[$i][0];
				$item->type = "Simple";
				$item->category = "x";
				$item->price = (($fileDatas[$i][3])/($fileDatas[$i][2]));
				$item->save();

				//details save will go here

				$variance = new Variance();
				$variance->price = (($fileDatas[$i][3])/($fileDatas[$i][2]));
				$variance->quantity = 0;
				$item->variances()->save($variance);

				$sold = new SoldProduct();
				$sold->user_id = "x";
				$sold->status = "complete";
				$sold->quantity = $fileDatas[$i][2];
				$sold->customer_id = "x";
				$variance->soldProduct()->save($sold);
			}
		} else {
			$fileDatas[0][0] = 'hello';
			$fileDatas[0][1] = 'major';
			$fileDatas[0][2] = '1';
			$fileDatas[0][3] = '9000';
			$fileDatas[1][0] = 'shello';
			$fileDatas[1][1] = 'smajor';
			$fileDatas[1][2] = '2';
			$fileDatas[1][3] = '3';
		}

		

		return view('olditemsdata')->with('fileDatas', $fileDatas);
	}

	public function uploadEmployees (Request $request)
	{
		if ($request['file'] !== null) {
			Employee::truncate();
			$file = $request->file('file');
			$fileOpen = fopen($file,'r');
			$fileDatas = array();
			while(! feof($fileOpen)) {
					array_push($fileDatas, fgetcsv($fileOpen));
				}
			fclose($fileOpen);
			//dd($fileDatas);

			for ($i=0; $i<count($fileDatas); $i++) {
				//$x = \ToString($fileDatas[$i]);
				$fileDatas[$i] = explode(",", $fileDatas[$i][0]);
			}

			$temp = array();
			$temp2 = array();

			for ($i=0; $i<count($fileDatas); $i++) {
				if (($fileDatas[$i][0] == "ACC") && ($fileDatas[$i][4]) == "Granted" && ($fileDatas[$i][6]) !== "None") {
					$temp[$i] = explode("/", $fileDatas[$i][1]);
					
					//for ($j=0; $j<count($temp); $j++) {
					if (!array_key_exists([$i][0][1], $temp)) {$temp[$i][0] = "0".$temp[$i][0];} 

						$temp2[$i][0] = $temp[$i][2];
						$temp2[$i][1] = $temp[$i][0];
						$temp2[$i][2] = $temp[$i][1];
					//}
					//dd($temp2);
					//array_push($temp2, $temp[2]);
					//array_push($temp2, $temp[0]);
					//array_push($temp2, $temp[1]);

					$temp2[$i] = implode("-", (array)$temp2[$i]);
					$time = $temp2[$i]. " " .$fileDatas[$i][2];
					$record = new Employee;
					$record->time = $time;
					$record->location = $fileDatas[$i][3];
					$record->permission = $fileDatas[$i][4];
					$record->sid = $fileDatas[$i][5];
					$record->name = $fileDatas[$i][6];
					$record->save();
				}
			}
			//Process
			//From
			//One Table To Another

			
			$employees = DB::table('employees')->get();

			$years = $employees[0]->time[0].$employees[0]->time[1].$employees[0]->time[2].$employees[0]->time[3];
			$months = $employees[0]->time[5].$employees[0]->time[6];
			$days = $employees[0]->time[8].$employees[0]->time[9];

			DB::table('employee_results')->where('year', $years)->where('month', $months)->where('day', $days)->delete();

			$sid = array();
			//$sid[0] = "";

			for ($i=0; $i<count($employees); $i++) {
				if (!in_array($employees[$i]->sid, $sid)) {
					array_push($sid, $employees[$i]->sid);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
	//dd($sid);
			$name = array();
			//$sid[0] = "";

			for ($i=0; $i<count($employees); $i++) {
				if (!in_array($employees[$i]->name, $name)) {
					array_push($name, $employees[$i]->name);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
	//dd($name);
			for ($i=0; $i<count($sid); $i++) {
				$times = array();
				for ($j=0; $j<count($employees); $j++) {
					if ($sid[$i] == $employees[$j]->sid) {
						array_push($times, $employees[$j]->time);
					}

				}
				$count = count($times);
				$clockout = "yes";
				if ($count % 2 > 0) {
					$count = $count - 1; //check as not clock out
					$clockout = "no";
				}
				//dd($count);
				//$counta = array();
				$moments = 0;
				for ($k=0; $k<$count; $k+=2) {

					$format = 'Y-m-d H:i:s';
					$dateOdd = \DateTime::createFromFormat($format, $times[$k]);
					$dateEven = \DateTime::createFromFormat($format, $times[$k+1]);
					$moment = date_diff($dateOdd, $dateEven);
					$moments += $moment->s;
					
					//$k $k+1 
					//array_push($counta, $k);

					//if($k !== $count) {
					//array_push($counta, ($k+1));
					//}
				}
				//dd($counta);
				//dd($moments/60);
				$year = $times[0][0].$times[0][1].$times[0][2].$times[0][3];
				$month = $times[0][5].$times[0][6];
				$day = $times[0][8].$times[0][9];


				
				$record = new EmployeeResult;
				$record->year = $year;
				$record->month = $month;
				$record->day = $day;
				$record->seconds = $moments;
				$record->sid = $sid[$i];
				$record->location = $employees[$i]->location;
				$record->name = $name[$i];
				$record->clockout = $clockout;
				$record->save();
			}

		} else {
			$fileDatas[0][0] = 'hello';
			$fileDatas[0][1] = 'major tom';
			$fileDatas[0][2] = 'hello';
			$fileDatas[0][3] = 'major tom';
			$fileDatas[0][4] = 'hello';
			$fileDatas[0][5] = 'major tom';
			$fileDatas[0][6] = 'hello';
			$fileDatas[0][7] = 'major tom';
			$fileDatas[0][8] = 'hello';
			$fileDatas[0][9] = 'major tom';
			$fileDatas[0][10] = 'hello';
			$fileDatas[0][11] = 'major tom';

			$fileDatas[1][0] = 'shello';
			$fileDatas[1][1] = 'smajor tom';
			$fileDatas[1][2] = 'shello';
			$fileDatas[1][3] = 'smajor tom';
			$fileDatas[1][4] = 'shello';
			$fileDatas[1][5] = 'smajor tom';
			$fileDatas[1][6] = 'shello';
			$fileDatas[1][7] = 'smajor tom';
			$fileDatas[1][8] = 'shello';
			$fileDatas[1][9] = 'smajor tom';
			$fileDatas[1][10] = 'shello';
			$fileDatas[1][11] = 'smajor tom';
		}

		//dd($fileDatas);
		/*$cannotFind = array();

		for ($i = 0; $i < count($fileDatas); $i++) {
			
			$dbMatch = Customer::where('name', $fileDatas[$i][0])->first();

			if (!$dbMatch) {
				array_push($cannotFind, $fileDatas[$i]);
			} else {
				$dbMatch->purchased = $dbMatch->purchased + $fileDatas[$i][1];
				$dbMatch->save();
			}
		}*/
		return view('employeesdata')->with('fileDatas', $fileDatas);//->with('cannotFind', $cannotFind);
	}

	public function showReportEmployees ()
	{
		/*$records = DB::table('employee_results')->get();

		$sid = array();
			//$sid[0] = "";

			for ($i=0; $i<count($records); $i++) {
				if (!in_array($records[$i]->sid, $sid)) {
					array_push($sid, $records[$i]->sid);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
	//dd($sid);
			for ($i=0; $i<12; $i++) {
				for ($j=0; $j<count($sid); $j++) {
					${'yearseventeenm'.$i.'s'.$j} = EmployeeResult::where('year', '2016')->where('month', $i)->where('sid', $sid[$j])->get();

				}
			}
			
			//dd($yearseventeenm7s0);

			/*for ($i=0; $i<12; $i++) {
				for ($j=0; $j<count($sid); $j++) {
					for ($k=0; $k<count(${'yearseventeenm'.$i.'s'.$j}); $k++) {
						${'yearseventeenm'.$i.'s'.$j.'tt'} = 0;
					}
				}
			}

			for ($i=0; $i<12; $i++) {
				for ($j=0; $j<count($sid); $j++) {
					for ($k=0; $k<count(${'yearseventeenm'.$i.'s'.$j}); $k++) {
						${'yearseventeenm'.$i.'s'.$j.'tt'} += ${'yearseventeenm'.$i.'s'.$j}[$k]->seconds;
					}
				}
			}

			dd($yearseventeenm7s6tt);*/

			$reports177 = EmployeeResult::
						select('name', DB::raw('SUM(seconds) AS tquantity, year, month, day'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->where('year', '=', '2017')
						->where('month', '=', '7')
						->groupBy('name')
						//->sum('total', '+', 'quantity')
						//->having('year', '=', '2016')
						->orderBy('tquantity', 'asc')
						->get();

						//dd($reports);

			$reports178 = EmployeeResult::
						select('name', DB::raw('SUM(seconds) AS tquantity, year, month'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->where('year', '=', '2017')
						->where('month', '=', '8')
						->groupBy('name')
						//->sum('total', '+', 'quantity')
						//->having('year', '=', '2016')
						->orderBy('tquantity', 'asc')
						->get();

			$reports179 = EmployeeResult::
						select('name', DB::raw('SUM(seconds) AS tquantity, year, month'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->where('year', '=', '2017')
						->where('month', '=', '9')
						->groupBy('name')
						//->sum('total', '+', 'quantity')
						//->having('year', '=', '2016')
						->orderBy('tquantity', 'asc')
						->get();

			$reports1710 = EmployeeResult::
						select('name', DB::raw('SUM(seconds) AS tquantity, year, month'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->where('year', '=', '2017')
						->where('month', '=', '10')
						->groupBy('name')
						//->sum('total', '+', 'quantity')
						//->having('year', '=', '2016')
						->orderBy('tquantity', 'asc')
						->get();

			$reports1711 = EmployeeResult::
						select('name', DB::raw('SUM(seconds) AS tquantity, year, month'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->where('year', '=', '2017')
						->where('month', '=', '11')
						->groupBy('name')
						//->sum('total', '+', 'quantity')
						//->having('year', '=', '2016')
						->orderBy('tquantity', 'asc')
						->get();

			$reports1712 = EmployeeResult::
						select('name', DB::raw('SUM(seconds) AS tquantity, year, month'))//DB::raw('count(*) as total'), DB::raw('SUM(quantity) AS quantity'))//, 'sum("total", "+", "quantity") as totalQuantity')
						//->sum('total', '+', 'quantity')
						->where('year', '=', '2017')
						->where('month', '=', '12')
						->groupBy('name')
						//->sum('total', '+', 'quantity')
						//->having('year', '=', '2016')
						->orderBy('tquantity', 'asc')
						->get();

			$addedDays7 = EmployeeResult::where('year', '2017')->where('month', '7')->get();
			$addedDays7array = array();

			for ($i=0; $i<count($addedDays7); $i++) {
				if (!in_array($addedDays7[$i]->day, $addedDays7array)) {
					array_push($addedDays7array, $addedDays7[$i]->day);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
			//dd($addedDays7array);

			$addedDays8 = EmployeeResult::where('year', '2017')->where('month', '8')->get();
			$addedDays8array = array();

			for ($i=0; $i<count($addedDays8); $i++) {
				if (!in_array($addedDays8[$i]->day, $addedDays8array)) {
					array_push($addedDays8array, $addedDays8[$i]->day);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
			//dd($addedDays7array);

			$addedDays9 = EmployeeResult::where('year', '2017')->where('month', '9')->get();
			$addedDays9array = array();

			for ($i=0; $i<count($addedDays9); $i++) {
				if (!in_array($addedDays9[$i]->day, $addedDays9array)) {
					array_push($addedDays9array, $addedDays9[$i]->day);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
			//dd($addedDays7array);

			$addedDays10 = EmployeeResult::where('year', '2017')->where('month', '10')->get();
			$addedDays10array = array();

			for ($i=0; $i<count($addedDays10); $i++) {
				if (!in_array($addedDays10[$i]->day, $addedDays10array)) {
					array_push($addedDays10array, $addedDays10[$i]->day);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
			//dd($addedDays7array);

			$addedDays11 = EmployeeResult::where('year', '2017')->where('month', '11')->get();
			$addedDays11array = array();

			for ($i=0; $i<count($addedDays11); $i++) {
				if (!in_array($addedDays11[$i]->day, $addedDays11array)) {
					array_push($addedDays11array, $addedDays11[$i]->day);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
			//dd($addedDays7array);

			$addedDays12 = EmployeeResult::where('year', '2017')->where('month', '12')->get();
			$addedDays12array = array();

			for ($i=0; $i<count($addedDays12); $i++) {
				if (!in_array($addedDays12[$i]->day, $addedDays12array)) {
					array_push($addedDays12array, $addedDays12[$i]->day);
					//$sid[$i][0] = $employees[$i]->sid;
					//$sid[$i][1] = $employees[$i]->name;
				}
			}
			//dd($addedDays7array);



		return view('report-employees')->with('reports177', $reports177)->with('reports178', $reports178)->with('reports179', $reports179)->with('reports1710', $reports1710)->with('reports1711', $reports1711)->with('reports1712', $reports1712)->with('addedDays7array', $addedDays7array)->with('addedDays8array', $addedDays8array)->with('addedDays9array', $addedDays9array)->with('addedDays10array', $addedDays10array)->with('addedDays11array', $addedDays11array)->with('addedDays12array', $addedDays12array);
	}

	public function uploadProducts (Request $request)
	{

		if ($request['file'] !== null) {
			$file = $request->file('file');
			$fileOpen = fopen($file,'r');
			$fileDatas = array();
			while(! feof($fileOpen)) {
					array_push($fileDatas, fgetcsv($fileOpen));
				}
			fclose($fileOpen);
			//dd($fileDatas);
//dd($fileDatas);
			//for ($i=0; $i<count($fileDatas); $i++) {
				//$x = \ToString($fileDatas[$i]);
			//	$fileDatas[$i] = explode(",", $fileDatas[$i][0]);
			//}

			$temp = array();
			$temp2 = array();

			for ($i=1; $i<(count($fileDatas)-1); $i++) {
				$product = new Product;
				$product->name = $fileDatas[$i][0];
				$product->category = $fileDatas[$i][1];
				//$product->sub = $fileDatas[$i][2];
				$product->price = $fileDatas[$i][2];
				$product->quantity = $fileDatas[$i][3];
				$product->save();

				$variance = new Variance();
				$variance->price = $fileDatas[$i][2];
				$variance->quantity = $fileDatas[$i][3];
				$product->variances()->save($variance);
				

			}

		} else {
			$fileDatas[0][0] = 'hello';
			$fileDatas[0][1] = 'major tom';
			$fileDatas[0][2] = 'hello';
			$fileDatas[0][3] = 'major tom';
			
		}

		return view('uploadsimple')->with('fileDatas', $fileDatas);
	}
}