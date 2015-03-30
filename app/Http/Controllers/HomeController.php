<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CubeProcessor\TextProcessor;
use App\Models\CubeProcessor\CubeProcessor;
use App\Models\Entities\Input;
use App\Models\Entities\UserCase;

class HomeController extends Controller {

	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{		
		return view('home');
	}

	public function processData(Request $request){				
		try{			
			$processor = new TextProcessor();
			$input = $processor->ValidateText($request->input('textInput'));
			if($input->passed){
				$cubeP = new CubeProcessor();
				$input = $cubeP->ProcessCube($input);
				$input->save();
			}
			return array('obj'=>$input, 'status' => 1);
		}catch(Exception $ex){
			return array('msg'=>$ex->getMessage(), 'status' =>2);
		}

	}

	public function getHistoryList(){
		try{
			$inputs = Input::orderBy('id', 'desc')->get();
			$inputs->load(['usercases' => function($query)
			{
			    $query->orderBy('id', 'asc');
			}]);
			return array('obj'=>$inputs, 'status' => 1);
		}catch(Exception $ex){
			return array('msg'=>$ex->getMessage(), 'status' =>2);
		}

	}

	public function getInput(Request $request){
		try{

			$input = Input::findOrFail($request->input("id"));	
			$input->load(['usercases' => function($query)
			{
			    $query->orderBy('id', 'asc');
			}]);
			$text = "";
			if($input->passed){
				foreach ($input->usercases as $_c) {
					$text .= $_c->result;
				}
			}else{
				$text = $input->outMessage;
			}
			$obj = array(
				"textIn" => $input->userText,
				"textOut" => $text 
			);
			return array('obj'=>$obj, 'status' => 1);
		}catch(Exception $ex){
			return array('msg'=>$ex->getMessage(), 'status' =>2);
		}
	}

}
