<?php

//load swapi class
require_once 'swapi.php';

$swapi = new Swapi;
//get page from url
$result = $swapi->getPersons(@$_GET['page']);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Persons List</title>
	<style>
		.container {
			width: 70%;
			margin: 0 auto;
		}
		.tables {
			width: 100%;
			text-align: center;
			font-family: calibri;
		}

		.tables th {
			background-color: silver;
			padding: 10px;
		}

		.tables tbody tr:nth-child(odd) {
			background-color: pink;
			padding: 5px;
		}

		.tables.details tbody tr:nth-child(odd) {
			background-color: slategrey;
			padding: 5px;
		}
		.pagination {
			display: flex;
			justify-content: space-between;
		}

		table.details {display: none;margin-top:15px;}
	</style>
</head>

<body>
	<div class="container">
		<table class="tables">
			<thead>
				<tr>
					<th>Name</th>
					<th>Birth Year</th>
					<th>Gender</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<!-- loop persons -->
				<?php foreach ($result['results'] as $person) : ?>
					<tr>
						<td><?= $person['name'] ?></td>
						<td><?= $person['birth_year'] ?></td>
						<td><?= $person['gender'] ?></td>
						<td><button class="js-show-details" data-details='<?= json_encode($person) ?>'>details</button></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="pagination">
			<!-- if prev exists show it -->
			<?php if($result['previous']) : ?>
				<a href="?page=<?= $result['previous'] ?>"><< prev page</a>
			<?php endif; ?>
			<!-- if next exists show it -->
			<?php if($result['next']) : ?>
				<a href="?page=<?= $result['next'] ?>">next page >></a>
			<?php endif; ?>
		</div>
		<table class="tables details">
			<thead>
				<tr>
					<th colspan="2">Selected Person Details</th>
				</tr>
				<tr>
					<th>Item</th>
					<th>Value</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
	$(function() {
		$(".js-show-details").on('click', function(e) {

			//show details table
			$("table.details").show();

			//get all data from data-details attr and parse into json
			let details = $(this).attr('data-details');
			details = JSON.parse(details);

			let table = '';
			//loop items and add it to table string
			$.each(details, function(i, item) {
				if(typeof item === 'string') {
					table += `<tr><td>${i}</td><td>${item}</td></tr>`;
				} else if (typeof item === 'object') {
					$.each(item, function(j, item2) {
						table += `<tr><td>${i}</td><td>${item2}</td></tr>`;
					});
				}
			});

			//insert table string
			$("table.details tbody").html(table);

		});
	})
</script>

</html>