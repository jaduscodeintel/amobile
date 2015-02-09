<?php

$data = array();
if( isset( $_POST['image_upload'] ) && !empty( $_FILES['images'] )){

	$image = $_FILES['images'];
	$allowedExts = array("gif", "jpeg", "jpg", "png");

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	//create directory if not exists
	if (!file_exists('images')) {
		mkdir('images', 0777, true);
	}
	$image_name = $image['name'];
	//get image extension
	$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
	//assign unique name to image
	$name = time().'.'.$ext;
	//$name = $image_name;
	//image size calcuation in KB
	$image_size = $image["size"] / 1024;
	$image_flag = true;
	//max image size
	$max_size = 512;
	if( in_array($ext, $allowedExts) && $image_size < $max_size ){
		$image_flag = true;
	} else {
		$image_flag = false;
		$data['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
	} 

	if( $image["error"] > 0 ){
		$image_flag = false;
		$data['error'] = '';
		$data['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$image["error"];
	}

	if($image_flag){
		move_uploaded_file($image["tmp_name"], "images/".$name);
		$src = "images/".$name;
		$dist = "images/thumbnail_".$name;
		$data['success'] = $thumbnail = 'thumbnail_'.$name;
		thumbnail($src, $dist, 200);
		$sql="INSERT INTO images (`id`, `original_image`, `thumbnail_image`, `ip_address`) VALUES (NULL, '$name', '$thumbnail', '$ip');";
		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error($con));
		} 

	}

	mysqli_close($con);
	echo json_encode($data);

} else {
	$data[] = 'No Image Selected..';
}?>