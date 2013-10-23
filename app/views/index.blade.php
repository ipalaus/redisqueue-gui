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
			<td><a href="queue/{{ $name }}/queued">{{ $queue['queued'] }}</a></td>
			<td><a href="queue/{{ $name }}/delayed">{{ $queue['delayed'] }}</a></td>
			<td><a href="queue/{{ $name }}/reserved">{{ $queue['reserved'] }}</a></td>
			<td>{{ $queue['queued'] + $queue['delayed'] + $queue['reserved'] }}</td>
		</tr>
		@endforeach

	</tbody>

</table>
@stop