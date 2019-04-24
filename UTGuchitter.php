<html>
<head>
<title>PHP TEST</title>
<meta charset="UTF-8">
</head>
<body>

<p>掲示板</p>

<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
<input type="text" name="personal_name"><br><br>
<textarea name="contents" rows="8" cols="40">
</textarea><br><br>
<input type="submit" name="btn1" value="投稿する">
</form>

<?php

$personal_name = $_POST['personal_name'];
$contents = $_POST['contents'];
$contents = nl2br($contents);

print('<p>投稿者:'.$personal_name.'</p>');
print('<p>内容:</p>');
print('<p>'.$contents.'</p>');

?>
</body>
</html>
