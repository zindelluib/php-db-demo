<?php require "includes/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Recipes</title>
	<style type="text/css">

		.thumbnail {
			width: 50px;
			height: 50px;
		}
		table {
			width: 600px;
			text-align: left;
		}
		th{
			background-color: #adebad;
		}
		table,th,td {
			padding: 5px;
			/*border: 1px solid black;*/
			border-collapse: collapse;
		}

		tbody > tr:nth-child(even) {
			background-color: #eee;
		}
	</style>
</head>
<body>
	<h1>Recipes</h1>
	<a href="addrecipe.php">Add Recipe</a><br><br>
	<?php
		$con  = getConnection();

		$query  = "SELECT COUNT(id) as total from recipe_t";
		$stmt   = $con->prepare($query);
		$stmt->execute();
		$result  =  $stmt->fetch(PDO::FETCH_ASSOC);
		$totalRecords   = $result['total'];
		$page  = 0;
		$perPage   = 4; // Limit
		//$page = (isset($_GET['page']))? $_GET['page']  - 1:0; //Offset
		if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0){
			$page = (int) $_GET['page'];
			$page--;
		}
		$page*= $perPage;// 0 * 10;
												//0 , 10
												//10, 10
		$query  = "SELECT * from recipe_t LIMIT :page,:perPage";
		$stmt   = $con->prepare($query);
		$stmt->bindParam(":perPage",$perPage,PDO::PARAM_INT);
		$stmt->bindParam(":page",$page,PDO::PARAM_INT);
		$stmt->execute();


		$fetched  =  $stmt->rowCount();
		$result  =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$con  = null;//Close

		$pages   = ceil($totalRecords / $perPage);

	?>
	<table>
		<thead>
			<tr>
				<th>Image</th>
				<th>Recipe Name</th>
				<th>Description</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbody>
			<?php if(count($result) > 0 ): ?>
			<?php foreach($result as $recipe):?>
			<tr>
				<td><img src="<?php echo $recipe['image']; ?>" class="thumbnail"></td>
				<td><?php echo $recipe['name']; ?></td>
				<td><?php echo $recipe['description']; ?></td>
				<td>
					<a href="">Edit</a>
					<a href="javascript:void(0)">Delete</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="3" style="text-align: center;">No Data Available!</td>
			</tr>
			<?php endif;?>
		</tbody>
	</table>
	<?php if($pages > 1): ?>
		<?php for($i=1;$i<=$pages;$i++): ?>
			<?php if($page == $i-1): ?>
				<a href="index.php?page=<?php echo $i ?>" style="color:green"><?php echo $i; ?></a>
			<?php else: ?>
				<a href="index.php?page=<?php echo $i ?>"><?php echo $i; ?></a>
			<?php endif?>
		<?php endfor;?>
	<?php endif; ?>
</body>
</html>