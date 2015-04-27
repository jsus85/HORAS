<?php	
	function phptopdf_url($source_url,$save_directory,$save_filename)
	{		


	//	$API_KEY = 'f58d697f2126225df9549be3796029f2dfaf9502';
		$API_KEY = '46ec3830aee89c9a24593ae572bcb2566821a0a8';
                $url = 'http://phptopdf.com/urltopdf.php?key='.$API_KEY.'&url='.urlencode($source_url);
		$resultsXml = file_get_contents(($url)); 		
		file_put_contents($save_directory.$save_filename,$resultsXml);
	}
	function phptopdf_html($html,$save_directory,$save_filename)
	{		

		//	$API_KEY = 'f58d697f2126225df9549be3796029f2dfaf9502';
		$API_KEY = '46ec3830aee89c9a24593ae572bcb2566821a0a8';
                $postdata = http_build_query(
			array(
				'html' => $html,
				'key' => $API_KEY
			)
		);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				"page_size" => 'A4',
				'header'  => 'Content-type: application/x-www-form-urlencoded',				
				'content' => $postdata 
			)
		);
		
		$context  = stream_context_create($opts);
		
		
		$resultsXml = file_get_contents('http://phptopdf.com/htmltopdf.php', false, $context);
		file_put_contents($save_directory.$save_filename,$resultsXml);
	}
?>