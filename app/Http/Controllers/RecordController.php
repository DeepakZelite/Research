<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;

use Vanguard\Http\Requests;
use Auth;
use DB;
use Barryvdh\Debugbar\Facade as Debugbar;

class RecordController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->theUser = Auth::user();
	}
	
	public function index()
	{
		$data = [];
		$edit = false;
		return view('records\list',compact('data','edit'));
	}
	
	public function info(Request $request)
	{
		$data=null;
		if($request->queries != '')
		{
			$data =  DB::select(DB::raw("$request->queries"));
		}
		$edit = $request->queries;
		Debugbar::info($data);
		//     	$data = (array) html_entity_decode(json_encode($data),true);
		return view('records\list',compact('data','edit'));
	}
}
