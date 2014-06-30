<?php
	// This file is used to import rating value 
    set_time_limit(-1);
    ini_set('memory_limit', '2048M');
	
	include_once("wp-config.php");
	
    $cn = mysql_connect('localhost','root','1');
    mysql_select_db('bitnami_wordpress',$cn);
	
    $path = "import_files/ratings.txt"; // SET YOUR CSV FILE PATH HERE
    
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
				
					$sql = "SELECT post_id FROM ".$table_prefix."postmeta WHERE meta_key = 'list-id' AND meta_value = '".$exp[0]."'";
					$result1 = mysql_query($sql);
					
					if ($row = mysql_fetch_array($result1)) {
					
					$post_id = $row['post_id'];
					
					if($post_id){
					//Update
						$sql2 = "UPDATE ".$table_prefix."postmeta SET meta_value = '".$exp[1]."' WHERE meta_key = 'property_rating' AND post_id = '".$row['post_id']."'";
						$result2 = mysql_query($sql2);
					}else{
					
					//Insert
						$sql2 = "INSERT INTO ".$table_prefix."postmeta (meta_key, meta_value, post_id) VALUES ('property_rating','".$exp[1]."', '".$post_id."')";
						$result2 = mysql_query($sql2);
					}
					
					if($result2)
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
<title>Property Rating Importer</title>
</head>
<body>
<h2>Property Rating Importer</h2>
<hr>
<form name="importer" method="post">
<input type="submit" name="Submit" value="Start Import" style="width:200px; height:50px; font-size:16px;">
</form>
</body>
</html>
