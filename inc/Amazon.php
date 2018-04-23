<?php

class Amazon {

	private $url = 'http://www.amazon.com/s/?url=search-alias%3Daps&field-keywords={{search}}';
	private $url_query;

	public function __construct(){

	}

	public function set_url($query){
		$query = urlencode($query);
		$this->url_query = str_replace('{{search}}', $query, $this->url);
	}

	public function find(){
		$url = "http://localhost/scrap-result/sample.html";
		$homepage = file_get_contents($url);
		preg_match_all('/<div class="product-row" id="\d+">\w+<\/div>/', $homepage, $matches, PREG_OFFSET_CAPTURE);
		$records = [];

		if(isset($matches[0])){
			foreach ($matches[0] as $key => $value) {
				$records[] = $value[0];
				$records[] = preg_replace('/<[^>]*>/', '', $value[0]);
			}
		}
		

		print_r($records);
	}


}