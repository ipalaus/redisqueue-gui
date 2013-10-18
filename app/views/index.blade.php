@extends('layouts.master')

@section('content')
<p class="text-right">Auto-Update: <a id="auto" href="#">OFF</a></p>

<table id="table-queues" class="table table-stripped table-bordered">

	<thead>
		<th>Name</th>
		<th>Queued</th>
		<th>Delayed</th>
		<th>Reserved</th>
		<th>Total</th>
	</thead>

	<tbody>

		@foreach ($queues as $name => $queue)
		<tr>
			<td><strong>{{ $name }}</strong></td>
			<td>{{ $queue['queued'] }}</td>
			<td>{{ $queue['delayed'] }}</td>
			<td>{{ $queue['reserved'] }}</td>
			<td>{{ $queue['queued'] + $queue['delayed'] + $queue['reserved'] }}</td>
		</tr>
		@endforeach

	</tbody>

</table>
@stop