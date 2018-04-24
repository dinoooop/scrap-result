<?php

class Scrap {
	

	public function set_url($query){
		$query = htmlspecialchars($query);
		$query = urlencode($query);
		$this->url = str_replace('{{search}}', $query, $this->url);
	}

	public function htmlcontent(){
		
		
		preg_match_all($this->pattern, $this->page_content, $matches, PREG_OFFSET_CAPTURE);
		$records = [];

		if(isset($matches[0])){
			foreach ($matches[0] as $key => $value) {
				$records[] = preg_replace('/<[^>]*>/', '', $value[0]);
			}
		}
		
		return $records;
	}

	public function attr($start, $end){
		
		
		preg_match_all($this->pattern, $this->page_content, $matches, PREG_OFFSET_CAPTURE);
		$records = [];
		

		if(isset($matches[0])){
			foreach ($matches[0] as $key => $value) {
				$records[] = substr($value[0], $start, $end);
			}
		}
		
		return $records;
	}

	public function render_json($param){
		if(is_array($param)){
			echo json_encode($param);
		}else{
			echo $param;
		}

		exit();
	}
}