<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\General\EloquentGeneralRepository;
use App\Models\Access\User\User;
use App\Models\General\General;
use PDF;
use Exporter;

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
        /*
        $selected_array = array('header:col1','header:col2', 'header:col3');

        $Array_data = array(
            array('row1:col1','row1:col2', 'row1:col3'),
            array('row2:col1','row2:col2', 'row2:col3'),
            array('row3:col1','row3:col2', 'row3:col3'),
        );

        $Filename ='Level.csv';
        header('Content-Type: text/csv; charset=utf-8');
        Header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename='.$Filename.'');
        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        fputcsv($output, $selected_array);
        foreach ($Array_data as $row){
            fputcsv($output, $row);
        }
        fclose($output);
        */
        

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

    /**
     * @return \Illuminate\View\View
     */
    public function sendPushNotifications(Request $request)
    {
    	if($request->has('notification_text'))
    	{
    		$users 	= User::all();
    		$text  	= $request->get('notification_text');
    		$sr 	= 0;

    		foreach($users as $user)
    		{
    			$payload  = [
    			    'mtitle'    => '',
    			    'mdesc'     => $text,
    			    'ntype'     => 'GENERAL_NOTIFICATION'
    			];

    			access()->sentPushNotification($user, $payload);

    			$sr++;
    		}

    		return redirect()->route('admin.push-notifications')->withFlashSuccess("Total ".$sr." Push Notification Send Successfully!");
    	}

		return view('backend.push-notification');
    }
}
