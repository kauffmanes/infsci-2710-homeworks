<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Business Details</title>
	<style>
		label { display: block; margin-bottom: 1rem; }
		h1 { text-align: center; color: red }
		h1, h2 {
			font-family: sans-serif;
		}
		h2 {
			padding: 1rem;
			margin-bottom: 0;
		}
		.c-section {
			border: solid 1px rgba(0,0,0,.1);
			padding: .5rem 1rem 1rem 1rem;
			background: rgba(0,0,0,.075);
			min-width: 15vw;
			max-width: 50vw;
			margin: 0 auto;;
			margin-bottom: 2rem;
		}
		.c-section__review {
			padding: 1rem;
			background: white;
		}
		.c-section--recs {
			padding: 1rem;
			background: rgba(0,0,0,.075);
			margin-bottom: 1rem;
			border: solid 1px rgba(0,0,0,.1);
		}
		.c-section--recs:last-of-type {
			margin-bottom: 0;
		}
	</style>
</head>
<body>
	<h1>Definitely the Real Yelp</h1>
	
	<?php

		// create new connection
		$servername = "localhost";
		$username = "root";
		$password = "mysql";
		$database = "yelp_db";
		
		$conn = new mysqli($servername, $username, $password, $database);
	
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		// get info based on ID
		$id_to_edit = $_GET['id'];
		$sql = "";

		echo  "<div class='c-section'>";

		if ($id_to_edit) {
		
			$sql = "SELECT * FROM business WHERE id = '$id_to_edit' LIMIT 1";
			$result = mysqli_query($conn, $sql);

			while ($row = $result->fetch_assoc()) {
				echo "<h2>" . $row['name'] . "</h2>";
				echo "<div style='padding:1rem'>";
				echo "<strong>Neighborhood:</strong> " . $row['neighborhood'] . "<br/>";
				echo "<strong>Address:</strong> " . $row['address'] . ", " . $row['city'] . ", " . $row['state'] . " " . $row['postal_code'] . "<br/>";
				echo "<strong>Open for business:</strong> " . ($row['is_open'] == '1' ? "Yes" :  "No") . "<br/>";
				echo "<strong>Rating:</strong> " . $row['stars']  . "<br/>";
				echo "<strong>Number of ratings:</strong> " . $row['review_count']  . "<br/>";
				echo "</div>";
			}
		} else {
			echo "<p>Missing a business Id. Go back and do better.</p>";
		}
		
		mysqli_close($conn);

		echo "</div>";
		?>
		<p style="text-align:center"><a href="javascript:history.back()	">Back from whence you came</a></p>

  </body>
</html>