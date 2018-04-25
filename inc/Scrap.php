<?php

class Scrap {
	

	public function set_url($query){
		$query = htmlspecialchars($query);
		$this->query = urlencode($query);
		$this->url = str_replace('{{search}}', $this->query, $this->url);
	}

	public function htmlcontent(){
		
		preg_match_all($this->pattern, $this->page_content, $matches, PREG_OFFSET_CAPTURE);

		$records = [];

		if(isset($matches[0])){
			foreach ($matches[0] as $key => $value) {
				$val = preg_replace('/<[^>]*>/', '', $value[0]);
				$records[] = preg_replace('/[\n]*/', '', trim($val));
			}
		}
		
		return $records;
	}

	

	public function render_json($param){

		if(is_array($param)){
			echo json_encode($param);
		} else {
			echo $param;
		}

		exit();
	}

	public function file_append($records){

		if(empty($records)){
			return false;
		}

		$data = [];
		$data[$this->query] = $records;
		$json_str = json_encode($data) . PHP_EOL;
		
		$file = fopen('public/result.json', 'a+');
		fwrite($file, $json_str);
		fclose($file);
	}

	public function file_find_query(){
		
		$handle = fopen('public/result.json', 'a+');

		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        
		        if(strpos($line, '"'.$this->query.'"') !== false){
		        	
		        	$result = json_decode($line, true);
		        	return $result[$this->query];
		        }

		    }

		    fclose($handle);
		}

		return false;
	}

	function collect(){

		$results =  $this->file_find_query();
		if($results){
			// Return result in the local file
			return $results;
		}else{
			// Get result from remote
			$results = $this->remote_collect();
			$this->file_append($results);
			return $results;
		}
		
	}
}