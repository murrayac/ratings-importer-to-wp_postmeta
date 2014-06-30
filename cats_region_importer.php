<?php
	// This file is used to import rating value 
    set_time_limit(0);
    ini_set('memory_limit', '2048M');
	include_once("wp-config.php");
	$cn = mysql_connect('localhost','root','1');
    mysql_select_db('bitnami_wordpress',$cn);
	
    $path = "import_files/hotels-cat-region.txt"; // SET YOUR CSV FILE PATH HERE
	
	//Formats >> list-id|job_listing_region|job_listing_category <<
    
if(isset($_POST['Submit']))
{
	if (($handle = fopen($path, "r")) !== FALSE) 
	{
		$i=1;
		while (($data = fgetcsv($handle, 1000, "/n")) !== FALSE) 
		{
			
			// do something with the data here
			if($i!=1)
			{
				$exp = explode('|',$data[0]);
				
				if($exp[0]) { // check for empty lines
				
				 $list_id = $exp[0];
				 $job_listing_region = $exp[1];
				 $job_listing_category = $exp[2];
				
				
					$sql = "SELECT post_id FROM ".$table_prefix."postmeta WHERE meta_key = 'list-id' AND meta_value = '".$list_id."'";
					$result1 = mysql_query($sql);
					
					while ($row = mysql_fetch_array($result1)) {
					
					$post_id = $row['post_id'];
					
					//echo $sql2 = "UPDATE ".$table_prefix."postmeta SET meta_value = '".$exp[1]."' WHERE post_id ='".$row['post_id']."'";
					$sql2 = "UPDATE ".$table_prefix."postmeta SET meta_value = '".$job_listing_region."' WHERE meta_key = 'job_listing_region' AND post_id = '".$post_id."'";
					$result2 = mysql_query($sql2);
					
					
					$sql3 = "UPDATE ".$table_prefix."postmeta SET meta_value = '".$job_listing_category."' WHERE meta_key = 'job_listing_category' AND post_id = '".$post_id."'";
					$result3 = mysql_query($sql3);


					if($result2 && $result3)
					{
						$j = $i-1;
						echo $j." Row Updated! <br>";
					}
					
					}
				} // END check for empty lines
				
				
			}
			
			$i++;
		}
		
		fclose($handle);
	}
	
}//End Submit
?>
<html>
<head>
<title>Category / Region Importer</title>
</head>
<body>
<h2>Category / Region Importer</h2>
<hr>
<form name="importer" method="post">
<input type="submit" name="Submit" value="Start Import" style="width:200px; height:50px; font-size:16px;">
</form>
</body>
</html>
