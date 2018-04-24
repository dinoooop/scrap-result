<?php

class Amazon {

	// private $url = 'http://www.amazon.com/s/?url=search-alias%3Daps&field-keywords={{search}}';
	private $url = "http://localhost/scrap-result/sample.html";
	

	public function __construct(){

	}

	public function set_url($query){
		$query = urlencode($query);
		$this->url = str_replace('{{search}}', $query, $this->url);
	}

	public function set_pattern(){

		// Ttile
		$this->pattern = '/<div class="product-name" title=".*" id="\w+">.*<\/div>/';
		$names = $this->matches();

		// Price
		$this->pattern = '/<div class="price" id="\w+">.*<\/div>/';
		$prices = $this->matches();

		$products = [];
		foreach ($names as $key => $value) {
			$products[$key][] = $value;
			$products[$key][] = $prices[$key] ?? null;
		}

		print_r($products);
	}

	public function matches(){
		
		$homepage = file_get_contents($this->url);
		preg_match_all($this->pattern, $homepage, $matches, PREG_OFFSET_CAPTURE);
		$records = [];

		if(isset($matches[0])){
			foreach ($matches[0] as $key => $value) {
				$records[] = preg_replace('/<[^>]*>/', '', $value[0]);
			}
		}
		
		return $records;
	}


	public function find2(){
		$url = "http://localhost/scrap-result/sample.html";
		$html = file_get_html($url);
		$elem = $html->find('div[id=wrapper_content]', 0);
		echo '<pre>' , print_r($elem) , '</pre>';
		
	}


}