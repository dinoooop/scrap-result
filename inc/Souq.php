<?php

class Souq extends Scrap {

	protected $url = 'https://uae.souq.com/ae-en/{{search}}/s/?as=1';
	protected $query;
	protected $page_content;
	protected $pattern;
	
	public function get_page_type(){
		// A row type page design contain medium-up-1 class
		if(strpos($this->page_content, 'medium-up-1') !== false){
			return "row_type";
		}else{
			return "column_type";
		}
	}
	

	public function remote_collect(){
		
		$this->page_content = file_get_contents($this->url);
		$this->design = $this->get_page_type();


		if($this->design == "column_type"){
			// name
			$this->pattern = '/<h6 class="title itemTitle">[\w\d\s,-]*<\/h6>/';
			$names  = $this->htmlcontent();

			// price
			$this->pattern = '/<span class="itemPrice">[\d\.]+<\/span>/';
			$prices = $this->htmlcontent();

			// image
			$this->pattern = '/class="img-size-medium"[\n\s]*[data-]*src="[\w\d\s,-:]*"/';
			$images = $this->imgsrc();

			

		} elseif($this->design == "row_type"){
			
			// name
			$this->pattern = '/<h1 class="itemTitle">[\w\d\s,-]*<\/h1>/';
			$names  = $this->htmlcontent();

			// Price
			$this->pattern = '/<h3 class="itemPrice">[\w\d\s,.]+<\/h3>/';
			$prices  = $this->htmlcontent();

			// images
			$this->pattern = '/class="img-size-medium imageUrl"[\n\s]*[data-]*src="[\w\d\s,-:]*"/';
			$images = $this->imgsrc();

		}
		

		$products = [];
		foreach ($names as $key => $value) {
			$products[$key]['name'] = $value;
			$products[$key]['price'] = $prices[$key] ?? null;
			$products[$key]['image'] = $images[$key] ?? null;
		}

		
		return $products;
	
	}

	
	
	public function imgsrc(){
		preg_match_all($this->pattern, $this->page_content, $matches, PREG_OFFSET_CAPTURE);
		
		$records = [];

		if(isset($matches[0])){
			foreach ($matches[0] as $key => $value) {
				$val = preg_replace('/class="img-size-medium(\simageUrl)?"[\n\s\t]*[data-]*src="/', '', $value[0]);
				$records[] = str_replace('"', '', $val);
			}
		}

		return $records;
	}

}