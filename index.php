<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Welcome to INFSCI 2710</title>
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
		
		$rotd_conn = new mysqli($servername, $username, $password, $database);
	
		if ($rotd_conn->connect_error) {
			die("Connection failed: " . $rotd_conn->connect_error);
		}

		// review of the day sql
		$rotd_sql = "CALL sp_review_otd()";
		$rotd_result = $rotd_conn->query($rotd_sql);

		if ($rotd_result) {

			while ($rotd_row = $rotd_result->fetch_assoc()) {

				// review of the day data
				$rotd_reviewer_name = $rotd_row['user_name'];
				$rotd_reviewer_fans = $rotd_row['fans'];
				$rotd_reviewer_stars = $rotd_row['user_review_count'];
				$rotd_reviewer_elite_since = $rotd_row['years_as_elite'];
				$rotd_reviewed_business = $rotd_row['business_name'];
				$rotd_reviewed_id = $rotd_row['business_id'];
				$rotd_review_stars = $rotd_row['review_stars'];
				$rotd_review_date = $rotd_row['review_date'];
				$rotd_review_text = $rotd_row['review_text'];

				// intro text
				$rotd_intro = "<h3>".$rotd_reviewer_name."</h3>";
				$rotd_intro .= "<p>";
				$rotd_intro .= "<span><strong># Fans:</strong> ".$rotd_reviewer_fans."</span>, ";
				$rotd_intro .= "<span><strong># Stars:</strong> ".$rotd_reviewer_stars."</span>, ";
				$rotd_intro .= "<span><strong>Elite since</strong> ".$rotd_reviewer_elite_since."</span>";
				$rotd_intro .= "</p>";
				$rotd_intro .= "<p>Wrote a review for <a href='business.php?id=".$rotd_reviewed_id."'>".$rotd_reviewed_business."</a></p>";
				
				// text review area
				$rotd_review = "<h2 style='background:lightblue'>Review of the day</h2>";
				$rotd_review .= "<div class='c-section__review'>";
				$rotd_review .= "<em>Given ".$rotd_review_stars."/5 stars on ".$rotd_review_date."</em>";
				$rotd_review .= "<p>".$rotd_review_text."</p>";
				$rotd_review .= "</div>";

				$rotd = "<div class='c-section'>";
				$rotd .= $rotd_intro . $rotd_review;
				$rotd .= "</div><!-- /c-section -->";

				echo $rotd;

			}
		}

		$rotd_result->free();
		mysqli_close($rotd_conn);

		// elite recommendations
		$rec_conn = new mysqli($servername, $username, $password, $database);
		if ($rec_conn->connect_error) {
			die("Connection failed: " . $rec_conn->connect_error);
		}

		$rec_sql = "CALL sp_elite_recommends()";
		$rec_result = $rec_conn->query($rec_sql);

		if ($rec_result) {

			echo "<div class='c-section'>";
			echo "<h2>Top Pittsburgh Restaurants Recommended by Elite Users</h2>";
			
			while ($rec_row = $rec_result->fetch_assoc()) {
			
				// data
				$rec_business = $rec_row['name'];
				$rec_business_id = $rec_row['id'];
				$rec_review_stars = $rec_row['stars'];
				$rec_review_count = $rec_row['review_count'];
				$rec_review_neighborhood = $rec_row['neighborhood'];
			
				// restaurant
				$rec = "<div class='c-section--recs'>";
				$rec .= "<h3><a href='business.php?id=".$rec_business_id."'>".$rec_business."</a></h3>";
				$rec .= "<p>".$rec_review_stars."/5 stars from ".$rec_review_count." reviews</p>";
				$rec .= "<p>Located in ".$rec_review_neighborhood."</p>";
				$rec .= "</div>";

				// template
				echo $rec;
			}

			echo "</div><!-- /c-section -->";
		}

		$rec_result->free();
		mysqli_close($rec_conn);

	?>
</body>
</html>