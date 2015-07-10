<?php
// EVALBASE64DECODE Scanner V1.0
// Developed by Matt Gross (http://mattgross.net/)
// http://github.com/MattGross/
// All rights reserved.

	$config = array(    'dir' => $_SERVER['DOCUMENT_ROOT'],);
	//////////////////////////////////
	// DO NOT EDIT BELOW THIS LINE! //
	//////////////////////////////////
	function output() {
		flush();
		ob_flush();
	}

	echo '<h1>EVALBASE64DECODE Malware Detector</h1><p>Please wait, we are currently searching for possible infected files...</p><br /><hr /><br />';
	output();
	$contents_list = array("eval(base64_decode(");
	$directory = $config['dir'];
	function getDirContents($dir, &$results = array()){
		$files = scandir($dir);
		foreach($files as $key => $value){
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
			
			if(!is_dir($path)) {
				$results[] = $path;
			} else
			if(is_dir($path) && $value != "." && $value != "..") {
				getDirContents($path, $results);
				$results[] = $path;
			}

		}

		return $results;
	}

	$files = getDirContents($directory);
	foreach ($files as $filename) {
		
		if($filename != __FILE__) {
			$file_content = file($filename);
			foreach ($file_content as $line) {
				foreach($contents_list as $content) {
					
					if(strpos($line, $content) !== false) {
						echo '<p>Possible Infection Found:&nbsp;'.$line.' at '.$path.'/'.$filename.'</p>';
						output();
					}

				}

			}
			
		}
		
	}
