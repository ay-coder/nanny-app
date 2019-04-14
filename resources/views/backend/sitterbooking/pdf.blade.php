<center>
<h2> Sitter Booking Rerport</h2>
<h4>@php echo date('m-d-Y H:i a'); @endphp</h4>
</center>
<table style="border: 2px solid; width: 100%">
	<tr>
		<th style="border: 2px solid;">Id</th>
		<th style="border: 2px solid;">Sitter Name</th>
		<th  style="border: 2px solid;">No of Completed Bookings</th>
	</tr>

	@if(isset($data) && count($data))
		@foreach($data as $sdata)
			<tr>
				<td  style="border: 2px solid;">{!! $sdata->id !!}</td>
				<td  style="border: 2px solid;">{!! isset($sdata->user) ? $sdata->user->name : '' !!}</td>
				<td  style="border: 2px solid;">{!! isset($sdata->sitter_completed_bookings) ? count($sdata->sitter_completed_bookings) : 0; !!}</td>
			</tr>
		@endforeach
	@endif
</table>