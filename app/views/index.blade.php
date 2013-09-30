<p class="text-right">Auto-Update: <a id="auto" href="#">OFF</a></p>

<table id="table-queues" class="table table-stripped table-bordered">

	<thead>
		<th>Name</th>
		<th>Items</th>
		<th>Delayed</th>
		<th>Reserved</th>
	</thead>

	<tbody>

		@foreach ($queues as $name => $queue)
		<tr>
			<td><strong>{{ $name }}</strong></td>
			<td>{{ $queue['total'] }}</td>
			<td>{{ $queue['delayed']['total'] }}</td>
			<td>{{ $queue['reserved']['total'] }}</td>
		</tr>
		@endforeach

	</tbody>

</table>