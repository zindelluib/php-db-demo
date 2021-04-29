<!DOCTYPE html>
<html>
<head>
	<title>Add New Recipe</title>
</head>
<body>
	<h1>Add New Recipe</h1>
	<form action="saverecipe.php" method="post" enctype="multipart/form-data">
		<label>Recipe Name: </label>
		<input type="text" name="recipename"><br><br>
		<label>Upload Image: </label><br>
		<input type="file" name="photo"><br><br>
		<label>Description: </label><br>
		<textarea rows="10" cols="50" name="description"></textarea><br><br>
		<input type="submit" name="submit" value="Save">
	</form>
</body>
</html>