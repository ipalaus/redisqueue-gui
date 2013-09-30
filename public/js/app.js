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
						// total
						animateCount(row.find('td:nth-child(2)'), queues[queueName].total);
						animateCount(row.find('td:nth-child(3)'), queues[queueName].delayed.total);
						animateCount(row.find('td:nth-child(4)'), queues[queueName].reserved.total);

						delete queues[queueName];
					} else { // it doesn't exists anymore? get rid of it!
						row.fadeOut(1000, function() {
							row.remove();
						});
					}
				});

				// if there is a new queue detected in the api, just attach it to the end of the table
				$.each(queues, function(index, queue) {
					var html = '<tr><td><strong>' + index + '</strong></td>' + '<td>' + queue.total + '</td>' +
							'<td>' + queue.delayed.total + '</td>' + '<td>' + queue.reserved.total +'</td></tr>';

					$(html).hide().appendTo("#table-queues tbody").fadeIn(1000);
				});
			},
			error: function(response) {
				// turn off timer
				auto = false;
				$('#auto').html('OFF');
			}
		});
	}

	function animateCount(child, newTotal) {
		var currentTotal = parseInt(child.html());

		if (currentTotal !== newTotal) {
			child.fadeOut(500, function() {
				child.html('');
			}).fadeIn(500, function() {
				child.html(newTotal);
			});
		}
	}

});