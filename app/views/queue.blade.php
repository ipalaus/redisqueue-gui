@extends('layouts.master')

@section('heading')
<div class="row">
	<h3>{{ $name }} <small>{{ $type }}</small></h3>
</div>
@stop

@section('content')
<div class="row">
	<table id="table-queues" class="table table-stripped table-bordered">

		<thead>
			<th>Job</th>
			<th>Data</th>
			<th>ID</th>
			<th>Attempts</th>
			<th>Actions</th>
		</thead>

		<tbody>

			@foreach ($items as $item)
			<tr>
				<td>{{ $item->job }}</td>
				<td><pre><small>{{ $item->encoded }}</small></pre></td>
				<td>{{ $item->id }}</td>
				<td>{{ $item->attempts }}</td>
				<td><a href="/queue/{{ $name }}/{{ $type }}/delete?value={{ $item->delete }}" class="btn btn-danger">Delete</a></td>
			@endforeach

		</tbody>

	</table>
</div>
@stop