<?php
/* Last updated with phpFlickr 1.3.2
	*
	* urls take the following format
	* http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
	*	or
	* http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}_[mstzb].jpg
	*	or
	* http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{o-secret}_o.(jpg|gif|png)
 */

require_once("phpFlickr.php");
//passes public key to phpFlickr function to set up the subsequent functions
$f = new phpFlickr("3dfb3d5b2b3bf96083621d3898f6cbd6");

//$login = $f->test_login();
//var_dump($login);

$authenticate = $f->auth("read");





//$recent = $f->photos_getRecent(NULL, NULL, 5, NULL);
/*
$photos = $f->photos_search(array("tags"=>"brown,cow", "tag_mode"=>"any", "per_page"=>5, "page"=>1));
//print_r(array_keys($photos['photo']));
$total_pages =  $photos['pages'];
echo '<br />' . $total_pages . '<br />';
//how the arrays are return nested in nested explaination

$photos_array = $photos['photo'];

foreach ($photos_array as $photo) {

	//http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
	$farm_id = $photo['farm'];
	$server_id = $photo['server'];
	$photo_id = $photo['id'];
	$secret = $photo['secret'];
	//urls build as shown below
	//http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
	$image_url = 'http://farm' . $farm_id . '.staticflickr.com/' . $server_id . '/' . $photo_id . '_' . $secret . '.jpg';
	echo '<img src="' . $image_url . '" />';
	

}
*/
?>
