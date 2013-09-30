$(function() {

	var auto = false;

	$('#auto').on('click', function(e) {
		e.preventDefault();

		if (auto) { // turn off the updates
			auto = false;
			$('#auto').html('OFF');
			window.clearInterval(timer);
		} else { // let's fetch data!!
			auto = true;
			$('#auto').html('ON');
			var timer = window.setInterval(fetch, 5000);
		}

	});

	function fetch() {
		$.ajax({
			url: '/api/queue',
			dataType: 'json',
			success: function(response) {
				var queues = response;

				$("#table-queues tbody tr").each(function() {
					var row = $(this);
					var queueName = row.find('td:first').text();

					if (queues[queueName]) { // update if the queue exists
						row.find('td:nth-child(2)').html(queues[queueName].total);
						row.find('td:nth-child(3)').html(queues[queueName].delayed.total);
						row.find('td:nth-child(4)').html(queues[queueName].reserved.total);

						delete queues[queueName];
					} else { // it doesn't exists anymore? get rid of it!
						$(this).remove();
					}
				});

				// if there is a new queue detected in the api, just attach it to the end of the table
				$.each(queues, function(index, queue) {
					var html = '<tr><td><strong>' + index + '</strong></td>' + '<td>' + queue.total + '</td>' +
							'<td>' + queue.delayed.total + '</td>' + '<td>' + queue.reserved.total +'</td></tr>';

					$("#table-queues tbody").append(html);
				});
			},
			error: function(response) {
				// turn off timer
				auto = false;
				$('#auto').html('OFF');
			}
		});
	}

});