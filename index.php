<?
include_once('markdown.php');

/* where to store your pages and where to move them when deleted */
$path['docs'] = 'documents/';
$path['trash'] = 'trash/';
$name = array();

/* your site's name/title */
$title = file_get_contents($path['docs'].'.title.txt');

function convertname($rawname) {
	global $name;
	$name['display'] = str_replace("_"," ",$rawname);
	$rawname = str_replace(" ","_",$rawname);
	if ($rawname == 'css' or $rawname == 'js') {
		$name['file'] = $rawname.'.'.$rawname;
	} else {
		$name['file'] = $rawname . '.txt';
	}
}

function listdocs() {
	global $path;
	$documents = glob($path['docs'].'*.txt');
	echo "<ol>\n";
	foreach($documents as $p)
	{
		$filename = basename($p,'.txt');
		$displayname = str_replace('_', ' ', $filename);
		echo "<li><a href='?p=$filename'>$displayname</a></li>\n";
	}
	echo "</ol>\n";
}

function displaycontent() {
	global $path, $form, $name;
	
	$form['fname'] = $name['display'];
	
	$form['fnotes'] = file_get_contents($path['docs'].$name['file']);
	$c = "<div id='content'>\n<h1>{$form['fname']}</h1>\n";
	if ($form['fnotes'] !='')   $c .= "<div id='notes'>" . Markdown($form['fnotes']) . "</div>\n";
	$c .= "<input type='button' value='Edit' id='editbtn'>\n</div>";

	return $c;
}

if (isset($_POST['fname'])) {
	convertname($_POST['fname']);
	$message = '';
	if ($_POST['save']) {
		$form = $_POST;
		$message = "<div id='announcement'><p>{$name['display']} information saved. Click to close.</p></div>";
		$x = file_put_contents($path['docs'].$name['file'], $_POST['fnotes']);
		$content = displaycontent();
	} else if ($_POST['delete']) {
		if (rename($path['docs'].$name['file'],$path['trash'].$name['file'])) {
			$message = "<div id='announcement'><p>{$name['file']} deleted. Click to close.</p></div>";
		} else {
			$message = "<div id='announcement'><p>Could not delete {$name['file']}. Click to close.</p></div>";
		};
		convertname($defaultpage);
		$content = displaycontent();
	}
} else {
	if (isset($_GET['p'])) {
		convertname($_GET['p']);
	} else {
		$defaultpage = file_get_contents($path['docs'].'.homepage.txt'); /* your default page (index.php)*/
		convertname($defaultpage);
	}
	$content = displaycontent();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=$name['display']?> - <?=$title?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<link rel="stylesheet" type="text/css" href="<?=$path['docs']?>css.css">         

<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>    
<script type="text/javascript" src="jquery.textarea.js"></script>    
<script type="text/javascript" src="jwerty.js"></script>    
<script type="text/javascript" src="<?=$path['docs']?>js.js"></script>    

		
</head>
<body>

<div id="wrapper">

<form id="login" method="post">
<label for='username'>Username</label> <input name='username' id='username' value='username' type="text"> <label for='password'>Password</label> <input name='password' id='password' value='password' type="text"> <input type="submit" value='Login'>
</form>

<?=$message?>

<h1><a href="index.php"><?=$title?></a></h1>

<div id="documents">
<p><input type="button" value="New+" id="newbtn"></p>
<p><input value="Search" id="search"></p>
<? listdocs(); ?>
</div>



<?=$content?>



<form action="index.php?p=<?=basename($name['file'],'.txt')?>" method="post" id="feditor">
<ol>

<li>
<label for='fname'>Page Name<br></label>
<input name='fname' id='fname' value='<?=$form['fname']?>'>(required for link in the lefthand sidebar)
</li>

<li>
	<label for='fnotes'>Notes</label>
	<textarea name='fnotes' id='fnotes'><?=$form['fnotes']?></textarea>
</li>

<li id="forminteract">
<input type="button" value="Cancel" id="fcancel">
<!-- <input type="button" value="Clear" id="fcancel"> -->
<input type="submit" value="Delete" name="delete" id="fdelete">
<!-- <input type="button" value="Revert" id="frevert"> -->
<input type="submit" value="Save" name="save" id="fsave">
</li>

<li>
	<div id="formattinghelp">
		<? echo Markdown(file_get_contents($path['docs'].'System_-_Quick_Start.css')) ?>
	</div>
</li>

</ol>

</form>

</div><!--wrapper-->

    </body>
</html>
