<center>
<h2> Subscription Rerport</h2>
<h4>@php echo date('m-d-Y H:i a'); @endphp</h4>
</center>
<table style="border: 2px solid; width: 100%">
	<tr>
		<th style="border: 2px solid;">Id</th>
		<th style="border: 2px solid;">Parent Name</th>
		<th  style="border: 2px solid;">Subscription Plan</th>
		<th style="border: 2px solid;">Allowed Bookings</th>
		<th style="border: 2px solid;">Amount</th>
	</tr>

	@if(isset($data) && count($data))
		@foreach($data as $sdata)
			<tr>
				<td  style="border: 2px solid;">{!! $sdata->id !!}</td>
				<td  style="border: 2px solid;">{!! $sdata->username !!}</td>
				<td  style="border: 2px solid;">{!! $sdata->plan_title !!}</td>
				<td  style="border: 2px solid;">{!! $sdata->allowed_bookings !!}</td>
				<td  style="border: 2px solid;">{!! isset($sdata->plan) ? $sdata->plan->amount : '' !!}</td>
			</tr>
		@endforeach
	@endif
</table>