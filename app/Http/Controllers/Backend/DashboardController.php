<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\General\EloquentGeneralRepository;
use App\Models\General\General;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
    	$repository = new EloquentGeneralRepository;
    	$item		= new General;
    	$values 	= General::all();

    	if($request->has('sitter_hourly_rate'))
    	{
    		General::where('data_key', 'sitter_hourly_rate')->update([
    			'data_value' => $request->get('sitter_hourly_rate')
    		]);
    	}

		if($request->has('booking_local_rate'))
    	{
    		General::where('data_key', 'booking_local_rate')->update([
    			'data_value' => $request->get('booking_local_rate')
    		]);
    	}

    	if($request->has('booking_touriest_rate'))
    	{
    		General::where('data_key', 'booking_touriest_rate')->update([
    			'data_value' => $request->get('booking_touriest_rate')
    		]);
    	}

    	if($request->has('booking_tax_rate'))
    	{
    		General::where('data_key', 'booking_tax_rate')->update([
    			'data_value' => $request->get('booking_tax_rate')
    		]);
    	}

    	return view('backend.dashboard')->with([
    		'repository' => $repository,
    		'item'		 => $item,
    		'values'	 => $values
    	]);
    }
}
