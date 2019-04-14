<center>
<h2> Sitter Earning Rerport</h2>
<h4>@php echo date('m-d-Y H:i a'); @endphp</h4>
</center>
<table style="border: 2px solid; width: 100%">
	<tr>
		<th style="border: 2px solid;">Id</th>
		<th style="border: 2px solid;">Sitter</th>
		<th  style="border: 2px solid;">Parent</th>
		<th style="border: 2px solid;">Date</th>
		<th style="border: 2px solid;">In Time</th>
		<th style="border: 2px solid;">Out Time </th>
		<th style="border: 2px solid;">Amount</th>
	</tr>

	@if(isset($data) && count($data))
		@foreach($data as $sdata)
			<tr>
				<td  style="border: 2px solid;">{!! $sdata->id !!}</td>
				<td  style="border: 2px solid;">{!! isset($sdata->sitter) ? $sdata->sitter->name : '' !!}</td>
				<td  style="border: 2px solid;">{!! isset($sdata->user) ? $sdata->user->name : '' !!}</td>
				<td  style="border: 2px solid;">{!! date('m-d-Y', strtotime($sdata->booking_date)) !!}</td>
				<td  style="border: 2px solid;">{!! $sdata->start_time !!}</td>
				<td  style="border: 2px solid;">{!! $sdata->end_time !!}</td>
				<td  style="border: 2px solid;">{!! isset($sdata->payment) ? $sdata->payment->per_hour * $sdata->payment->total_hour + $sdata->payment->parking_fees + $sdata->payment->tip : 'N/A'; !!}</td>
			</tr>
		@endforeach
	@endif
</table>