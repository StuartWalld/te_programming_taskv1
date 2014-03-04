<?php
require_once("includes/phpFlickr.php");
//the phpFlickr file starts the session

//setting the page number by get method in url or form
if(isset($_POST['page_num'])){
	//set current page number to 1 after form post
	$current_page = 1;
	$_SESSION['page_num'] = $current_page;
	
}elseif(isset($_GET['page_num']) && is_numeric($_GET['page_num'])){
	// check page_num variable is passed from url and it is a number
	$_SESSION['page_num']= $_GET['page_num'];
	$current_page = $_SESSION['page_num'];
}else{
	//page_num not set from form or session, defaults to page number 1
	$current_page = 1;
}

//setting the search query by form variable
if(isset($_POST['search_q'])) {
	//set from form variable
	$_SESSION['search_q'] = $_POST['search_q'];
	$search_q = $_SESSION['search_q'];
}elseif(isset($_SESSION['search_q'])){
	//set from session variable
	$search_q = $_SESSION['search_q'];
}else{
	//search query not set this later redirects to index
	$search_q = FALSE;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="javascript" language"javascript"></script>


<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="css/lightbox.css" />
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/lightbox-2.6.min.js"></script>

<title>Search</title>
</head>
<body>
<div id="top">
	<a href="index.html">Home</a>&nbsp;|&nbsp; <a href="sign_up.php">Sign Up</a>
</div>

<div id="header">
	FLICKR Search for: 
	<?php if($search_q){ echo $search_q; }else{ echo 'No search specified';} ?>
</div>

<div id="main_search_container">
	<p style="text-align:center;">
	Enter 1 or more key words and seperate them with a comma: <br />
	Eg: fun, sunshine, random, words 
	</p>
	
	<div id="seach_container">
		<form id="search_input" method="POST" action="search.php">
			<input class="searchinput" type="text" onfocus="this.value=''" name="search_q" value="<?php if($search_q){ echo $search_q; }else{ echo 'Enter your search here...';} ?>"></input>
			<input type="hidden" id="page_num" name="page_num" value="set" />
			<input class="submit_button" type="submit" name="submit" value="Search"></input>
		</form>
	</div>
</div>

<?php

if($search_q) {
//search_q is not set to FALSE

	//passes public key to phpFlickr function
	$f = new phpFlickr("3dfb3d5b2b3bf96083621d3898f6cbd6");
	
	//additional cleaning of form input can be done here but it is sent straight to the flickr api which has its own cleaning method
	$result = $f->photos_search(array("tags"=>$search_q, "tag_mode"=>"any", "per_page"=>20, "page"=>$current_page));
	
	//all photos and details stored in this array
	$photos_array = $result['photo'];
	$total_pages =  $result['pages'];
	
	echo '<div id="main_container">';
	foreach ($photos_array as $photo) {
		//take each photo element to construct the url
		$title = $photo['title'];
		$farm_id = $photo['farm'];
		$server_id = $photo['server'];
		$photo_id = $photo['id'];
		$secret = $photo['secret'];
		//url format: http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
		$image_url = 'http://farm' . $farm_id . '.staticflickr.com/' . $server_id . '/' . $photo_id . '_' . $secret . '.jpg';
		
		
		//cut title to fit into box
		unset($cut_title);
		if (strlen($title) > 30 ){
			//if string length is longer than 30 then cut it down and add dots
			$cut_title = substr($title, 0, 30);
			$cut_title = $cut_title . '...';
		}else{
			$cut_title = $title;
		}
		//quotes break the lightbox display so remove them
		$title = str_replace('"', '', $title);
		
		echo	'<div id="picture_container">';
		echo		'<div id="detail_container">';
		echo 			$cut_title;
		echo		'</div>';
		echo		'<div id="image_container">';
		echo 			'<a href="' . $image_url . '" data-lightbox="' . $current_page . '" title=" ' . $title . ' " style="background-color:transparent;">';
		echo 			'<img src="' . $image_url . '" height="176px" width="186px"/></a>';
		echo		'</div>';
		echo	'</div>';
	} //end foreach photo
	
		echo '</div>';
		echo '<div id="footer">';
		echo 	'<p> Page ' . $current_page . ' out of ' . $total_pages . '</p>'; 
		
		$next_page = $current_page +1;
		$previous_page = $current_page -1;
	
		//url passes page number to the next page
		if($current_page == 1){
			//only display next
			echo '<a href="search.php?page_num=' . $next_page . '"> Next </a>';
		}elseif($current_page == $total_pages){
			//only display previous
			echo '<a href="search.php?page_num=' . $previous_page . '"> Previous </a>';
		}else{
			echo '<a href="search.php?page_num=' . $previous_page . '"> Previous </a>|<a href="search.php?page_num=' . $next_page . '"> Next </a>';
		}
	
		echo '</div>';
	
}else{
	//search query not set and search page was loaded
	//redirect to home
	header("Location:index.html");

}
?>

</body>
</html>