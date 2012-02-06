<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
		body {
		background:#9fffef url(mario.png) repeat-x fixed 0 bottom;
		}
		body {
		height: 2000px;
		}
		#disp {
		position: fixed;
		}
		</style>
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>    
<script type='text/javascript'>
$(document).scroll(function() {
	$('body').css('background-position-x', $(window).scrollTop()*-.5);
});
</script>
	</head>
	<body>
		<p id="disp">0</p>
	</body>
</html>
