<?php
	// This file is used to import rating value 
    set_time_limit(0);
    ini_set('memory_limit', '2048M');
	include_once("wp-config.php");
	$cn = mysql_connect('localhost','root','1');
    mysql_select_db('bitnami_wordpress',$cn);
	
    $path = "import_files/images.csv"; // SET YOUR CSV FILE PATH HERE
	
	//Formats >> list-id|job_listing_region|job_listing_category <<
    
if(isset($_POST['Submit']))
{
	if (($handle = fopen($path, "r")) !== FALSE) 
	{
		$i=1;
		while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) 
		{
			
			// do something with the data here
			if($i!=1)
			{
			
				$list_id = $data[0];
				$slider =  $data[1];
				//$alt_tag = $data[2];
				
				    if($list_id && $slider) // Check empty lines
					{
						$sql = "SELECT post_id FROM ".$table_prefix."postmeta WHERE meta_key = 'list-id' AND meta_value = '".$list_id."'";
						$result1 = mysql_query($sql);
						
						while ($row = mysql_fetch_array($result1)) {
						
						$post_id = $row['post_id'];
						
						$sql2 = "UPDATE ".$table_prefix."postmeta SET meta_value = '".$slider."' WHERE meta_key = 'slider' AND post_id = '".$post_id."'";
						$result2 = mysql_query($sql2);
						
						
						/*$sql3 = "UPDATE ".$table_prefix."postmeta SET meta_value = '".$alt_tag."' WHERE meta_key = 'alt-tag' AND post_id = '".$post_id."'";
						$result3 = mysql_query($sql3);*/
	
	
						if($result2)
						{
							$j = $i-1;
							echo $j." Row Updated! <br>";
						}
					}// Check empty lines
					
				}//End While
				
				
				
			}
			
			$i++;
		}
		
		fclose($handle);
	}
	
}//End Submit
?>
<html>
<head>
<title>Images Importer</title>
</head>
<body>
<h2>Images Importer</h2>
<hr>
<em><strong>File Format : ".CSV"</strong></em>
<form name="importer" method="post">
<input type="submit" name="Submit" value="Start Import" style="width:200px; height:50px; font-size:16px;">
</form>
</body>
</html>
