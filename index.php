<?php
error_reporting(E_ERROR);
include('config.php');
?>

<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<title>RAW Cow</title>
	<link rel="icon" href="cow.png">
	<link rel="stylesheet" href="css/lit.css">
	<link href="css/featherlight.min.css" type="text/css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	 img.cow {
	     border-radius: 50%;
	     display: block;
	     margin-left: auto;
	     margin-right: auto;
	     margin-bottom: 1.5em;
	 }
	 
	 div.gallery {
	     border: 1px solid #ccc;
	 }
	 
	 div.gallery:hover {
	     border: 1px solid #777;
	 }
	 
	 div.gallery img {
	     width: 100%;
	     height: auto;
	 }
	 div.desc {
	     padding: 5px;
	     text-align: center;
	 }
	 
	 * {
	     box-sizing: border-box;
	 }

	 .responsive {
	     padding: 0 6px;
	     float: left;
	     width: 24.99999%;
	 }

	 @media only screen and (max-width: 800px) {
	     .responsive {
		 width: 49.99999%;
		 margin: 6px 0;
	     }
	 }

	 @media only screen and (max-width: 500px) {
	     .responsive {
		 width: 100%;
	     }
	 }

	 .clearfix:after {
	     content: "";
	     display: table;
	     clear: both;
	 }
	</style>
    </head>
    <body>
	<script src="js/jquery.min.js"></script>
	<script src="js/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
	<div class="c">
	    <img class="cow" src="cow.png" alt="RAW Cow" width="100">
	    <hr>

	    <?php
	    function extract_preview_jpeg($work_dir, $prev_dir, $file_ext) {
		shell_exec('exiv2 -e p2 '.$work_dir.$file_ext);
		$files = glob($work_dir.'*.jpg');
		foreach($files as $file)
		{
		    rename($file, $work_dir.$prev_dir.basename($file));
		}
	    } 
	    function is_dir_empty($dir) {
		if (!is_readable($dir)) return NULL; 
		return (count(scandir($dir)) == 3);
	    }
	    if (is_dir_empty($work_dir))
	    {
		echo '<img src="wtf-cow.jpg" alt="WTF Cow" width="600"><br>';
		exit("No RAW files. WTF?");
	    }
	    if (!file_exists($work_dir.$prev_dir))
	    {
		shell_exec('mkdir -p '.$work_dir.$prev_dir);
		extract_preview_jpeg($work_dir, $prev_dir, $file_ext);
	    }

	    define('IMAGEPATH', $work_dir.$prev_dir);
	    foreach(glob(IMAGEPATH.'*') as $filename){
		echo '<div class="responsive">';
		echo '<div class="gallery">';
		echo '<a target="_blank" href="'.$filename.'" data-featherlight="image">';
		echo '<img src="'.$filename.'" alt="'.$filename.'" width="600">';
		echo '</a>';
		echo '<div class="desc">'.basename($filename).'</div>';
		echo '</div>';
		echo '</div>';
	    }
	    ?>
	    <div class="clearfix"></div>
	    <hr>
	    <form method='POST' action=''>
		<input class="btn primary"  type="submit" name="refresh" value="Refresh"> 
	    </form>
	    <?php
	    if(isset($_POST["refresh"])) {
		shell_exec('rm -rf '.$work_dir.$prev_dir);
		shell_exec('mkdir -p '.$work_dir.$prev_dir);
		extract_preview_jpeg($work_dir, $prev_dir, $file_ext);
		echo '<meta http-equiv="refresh" content="0">';
	    }
	    ?>
	    <p>That's <a href="https://gitlab.com/dmpop/raw-cow"> RAW Cow</a> for you!</p>
	</div>
    </body>
</html>
