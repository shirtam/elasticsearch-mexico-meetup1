<?php

/*
this code as 3 vulnerabilities:
* SSRF
* File Reading (using php streams)
* XSS
*/

function random_name(){
	return sha1(rand(0, 0xFFFFFFFF));
}

if(isset($_POST['url']) && ($url = $_POST['url'])) {

	if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			
		$filename = "files/" . random_name() . ".png";

	    if(file_put_contents($filename, file_get_contents($url))) {
	    	echo "File uploaded successfuly.";
	    }

	} else {
		// ignore the xss plz
	    die("$url is not a valid URL");
	}
}

?>

<center>
<img src="logo.gif" width="250"> <br>

<form method="post">
<input placeholder="http://example.com/image.png" type="text" name="url" style="min-width: 480px; min-height: 30px; font-size: 26px;">
<br>
<input type="submit">
</form>
<hr>

<br><br><br>

<?php
foreach (glob("files/*.png") as $filename) {
    echo "<img src='{$filename}' width='250' />";
}
?>