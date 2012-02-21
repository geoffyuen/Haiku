<?php
/* function:  generates thumbnail */
function make_thumb($src,$dest,$desired_width) {

	/* read the source image */
	$ext = strtolower(pathinfo($src,PATHINFO_EXTENSION));
	if ($ext=='png') {
		$source_image = imagecreatefrompng($src);
	} elseif ($ext=='jpg') {
		$source_image = imagecreatefromjpeg($src);
	} elseif ($ext=='gif') {
		$source_image = imagecreatefromgif($src);
	}
	
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height*($desired_width/$width));
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);

	/* create the physical thumbnail image to its destination */
	if ($ext=='png') {
		imagepng($virtual_image,$dest);
	} elseif ($ext=='jpg') {
		imagejpeg($virtual_image,$dest,80);
	} elseif ($ext=='gif') {
		imagegif($virtual_image,$dest);
	}

	
}

/** settings **/
$images_dir = 'img/';
$thumbs_dir = 'thumb-';
$thumbs_width = 100;
$output = '';

/** generate photo gallery **/
$image_files = glob("{$images_dir}*.{jpg,gif,png}", GLOB_BRACE);
if(count($image_files)) {
	$index = 0;
	foreach($image_files as $index=>$file) {
		$index++;
		$thumbnail_image = $thumbs_dir.$file;
		if(!file_exists($thumbnail_image)) {
			$extension = pathinfo($thumbnail_image,PATHINFO_EXTENSION);
			if($extension) {
				make_thumb($file,$thumbnail_image,$thumbs_width);
			}
		}
		$nice = str_replace('_',' ',pathinfo($file,PATHINFO_BASENAME));
		$output .= "<a href='$file'><img src='$thumbnail_image'><p>$nice</p></a>\n";
	}
}
else {
	$output .= '<p>There are no images in this gallery.</p>';
}
?>
<DOCTYPE html>
<html>
	<head>
		<title></title>
		<style>
			html { font-family: sans-serif}
			#gallery { font-size: 0}
			#gallery * {font-size:12px}
			#gallery a {
				display: inline-block;
				margin: 10px;
				width: 150px;
				text-align: center;
				text-decoration: none;
			}
		</style>
	</head>
	<body>
	<div id='gallery'>
<?=$output?>
	</div>
	</body>
</html>
