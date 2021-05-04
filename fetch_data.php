<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM projet_cons WHERE projet_status = '1'
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND projet_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["client"]))
	{
		$brand_filter = implode("','", $_POST["client"]);
		$query .= "
		 AND projet_client IN('".$brand_filter."')
		";
	}
	if(isset($_POST["etage"]))
	{
		$ram_filter = implode("','", $_POST["etage"]);
		$query .= "
		 AND projet_etage IN('".$ram_filter."')
		";
	}
	if(isset($_POST["niveau"]))
	{
		$storage_filter = implode("','", $_POST["niveau"]);
		$query .= "
		 AND projet_niveau IN('".$storage_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
					<img src="image/'. $row['projet_image'] .'" alt="" class="img-responsive" >
					<p align="center"><strong><a href="#">'. $row['projet_name'] .'</a></strong></p>
					<h4 style="text-align:center;" class="text-danger" >'. $row['projet_price'] .'</h4>
					<p>annee : '. $row['projet_annee'].' MP<br />
					client : '. $row['projet_client'] .' <br />
					etage : '. $row['projet_etage'] .' GB<br />
					niveau : '. $row['projet_niveau'] .' GB </p>
				</div>

			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>