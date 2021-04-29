<?php

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$recipename   = $_POST['recipename'];
		$description  = $_POST['description'];
		$image  = $_FILES['photo']['name'];
		$extension  = strtolower(pathinfo($image,PATHINFO_EXTENSION));

		$randName  = 'uploads/' . md5(time() . uniqid("",true))   .  '.'  . $extension;
		
		$isUploaded  =  move_uploaded_file($_FILES['photo']['tmp_name'],$randName);
		//TODO Validate data
		

		require 'includes/db.php';

		$con   = getConnection();

		//Do not trust user input
		//$query  =  "INSERT INTO recipe_t(name,description) VALUES('$recipename','$description')";
		//$affected   = $con->exec($query); Do not use exec when inserting data typed by users
		
		$query  =  "INSERT INTO recipe_t(name,description,image) VALUES(:name,:description,:image)";
		$stmt  = $con->prepare($query);
		$stmt->bindParam(":name",$recipename);
		$stmt->bindParam("description",$description);
		if($isUploaded)
			$stmt->bindParam("image",$randName);
		else
			$stmt->bindParam("image","");

		$stmt->execute();
		$inserted  = $stmt->rowCount();
		//Close
		$con  = null;
		
		if( $inserted > 0){
			echo "Recipe Added";
			//TODO redirect to home page
			header("Location: index.php");
		}
		else{
			echo "Recipe Added";
		}
	}
	else{
		echo "NOT a POST Request";
	}


?>