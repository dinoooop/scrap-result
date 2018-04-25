var input = document.getElementById("search-input");


input.addEventListener("keyup", function(event) {  
  event.preventDefault();
  if (event.keyCode === 13) {
    http_request();
  }
});


function http_request(){

	var query = document.getElementById("search-input").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
			// document.getElementsByClassName("result-box").innerHTML = this.responseText;
			var response = this.responseText;
			//var response = [{name: "test"}, {name: "test 2"}];
			response = JSON.parse(response);
			var str = '';
			response.forEach(function(item, index){
				str += '<div class="item">';
				str += '<div class="name">' + item.name + '</div>';
				str += '<div class="price">' + item.price + '</div>';
				str += '</div>';
			});

			document.getElementById("result-box").innerHTML = str;
		}
	};
	xhttp.open("GET", "http://localhost/scrap-result/search.php?q=" + query, true);
	xhttp.send();
}