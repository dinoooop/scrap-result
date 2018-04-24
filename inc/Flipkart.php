<?php

class Flipkart extends Scrap {

	protected $url = 'https://www.flipkart.com/search?q={{search}}';

	public function __construct(){

	}
	

	public function collect(){
		
		$this->page_content = file_get_contents($this->url);

		if(strpos($this->page_content, '_3T_wwx') !== false){
			$this->design = "row_type";
		}else{
			$this->design = "column_type";
		}

		if($this->design == "column_type"){
			$this->pattern = '/class="_2cLu-l" title="[\w\d\s(),\-]+"/';
			$names = $this->attr(23, -1);

			$this->pattern = '/<div class="_1vC4OE">₹<!-- -->[,\d]+<\/div>/';
			$prices = $this->htmlcontent();
		} elseif($this->design == "row_type"){
			$this->pattern = '/<div class="_3wU53n">[\w\d\s(),\-]+<\/div>/';
			$names = $this->htmlcontent();

			$this->pattern = '/<div class="_1vC4OE _2rQ-NK">₹<!-- -->[,\d]+<\/div>/';
			$prices = $this->htmlcontent();
		}
		

		$products = [];
		foreach ($names as $key => $value) {
			$products[$key]['name'] = $value;
			$products[$key]['price'] = $prices[$key] ?? null;
		}

		return $products;
		

	}


}