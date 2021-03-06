<?php

include_once "../lib/php/functions.php";

$empty_product = (object) [
	"title"=>"Pin_End_of_Heat",
	"price"=>"12",
	"category"=>"Pin",
	"color"=>"Blue & Pink",
	"size"=>"2.5 x 2.5 x 0.3 inches",
	"description"=>"1. Wide usages These cute enamel lapel pins can be great additions to your clothes, jackets, coats, bags, backpacks, hats, which will bring fresh and bright feeling to your outfits. 2. Easy to use Easy To Use: the brooch pin has a clasp in the back, provide convenience for you to wear on and take off. Pins ensure durability against wear-and-tear. 3. Warm note Avoid scratching the skin when wearing a brooch, please remember to put on the back clasp. Keep it dry and avoid chemicals. Avoid being struck. Clean and wipe with dry soft cloth.",
	"thumbnail"=>"Pin_End_of_Heat.jpg",
	"images"=>"Pin_End_of_Heat.jpg",
	"quantity"=>"12"
];











// CRUD LOGIC
try {

$conn = makePDOConn();
switch(@$_GET['action']) {
	case "update":
		$statement = $conn->prepare("UPDATE
		`products`
		SET
			`title`=? ,
			`price`=? ,
			`category`=? ,
			`color`=? ,
			`size`=? ,
			`description`=? ,
			`thumbnail`=? ,
			`images`=? ,
			`quantity`=? ,
			`date_modify`=NOW()
		WHERE `id`=?
		");
		$statement->execute([
			$_POST['product-title'],
			$_POST['product-price'],
			$_POST['product-category'],
			$_POST['product-color'],
			$_POST['product-size'],
			$_POST['product-description'],
			$_POST['product-thumbnail'],
			$_POST['product-images'],
			$_POST['product-quantity'],
			$_GET['id']
		]);

		header("location:{$_SERVER['PHP_SELF']}?id={$_GET['id']}");
		break;
	case "create":
		$statement = $conn->prepare("INSERT INTO
		`products`
		(
			`title`,
			`price`,
			`category`,
			`color`,
			`size`,
			`description`,
			`thumbnail`,
			`images`,
			`quantity`,
			`date_create`,
			`date_modify`
		)
		VALUES
		(?,?,?,?,?,?,?,?,?,NOW(),NOW())
		");
		$statement->execute([
			$_POST['product-title'],
			$_POST['product-price'],
			$_POST['product-category'],
			$_POST['product-color'],
			$_POST['product-size'],
			$_POST['product-description'],
			$_POST['product-thumbnail'],
			$_POST['product-images'],
			$_POST['product-quantity']
		]);
		$id = $conn->lastInsertId();

		header("location:{$_SERVER['PHP_SELF']}?id=$id");
		break;
	case "delete":
		$statement = $conn->prepare("DELETE FROM `products` WHERE id=?");
		$statement->execute([$_GET['id']]);
		$id = $conn->lastInsertId();

		header("location:{$_SERVER['PHP_SELF']}");
		break;
}


} catch(PDOException $e) {
	die($e->getMessage());
}










// TEMPLATES

function makeListItemTemplate($r,$o) {
return $r.<<<HTML
<div class="itemlist-item grid" style="margin-bottom:30px;">
	<div class="flex-none col-2">
		<div class="image-square">
			<img src="../img/$o->thumbnail">
		</div>
	</div>
	<div class="flex-stretch col-6" style="margin-left:10px">
		<div><strong>$o->title</strong></div>
		<div><span>$o->category</span></div>
	</div>
	<div class="flex-none display-flex col-4" style="flex-direction:row-reverse;">
		<div><a class="form-button" href="?id=$o->id">edit</a></div>
		<div><a class="form-button" href="../product_item.php?id=$o->id">visit</a></div>
	</div>
</div>
<hr style="margin-bottom:35px">
HTML;
}


function makeProductForm($o) {

$id = $_GET['id'];
$addoredit = $id=="new" ? 'Add' : 'Edit';
$createorupdate = $id=="new" ? 'create' : 'update';
$deletebutton = $id=="new" ? '' : <<<HTML
<li class="flex-none"><a href="{$_SERVER['PHP_SELF']}?id=$id&action=delete">Delete</a></li>
HTML;

$images = array_reduce(explode(",",$o->images),function($r,$p){
	return $r."<img src='../img/$p'>";
});

$data_show = $id=="new" ? "" : <<<HTML
<div class="card soft">

<div class="product-main">
	<img src="../img/$o->thumbnail">
</div>


<h2>$o->title</h2>

<div class="form-control">
	<strong>Price</strong>
	<span>$o->price</span>
</div>
<div class="form-control">
	<strong>Category</strong>
	<span>$o->category</span>
</div>
<div class="form-control">
	<strong>Color</strong>
	<span>$o->color</span>
</div>
<div class="form-control">
	<strong>Size</strong>
	<span>$o->size</span>
</div>
<div class="form-control">
	<strong>Description</strong>
	<span>$o->description</span>
</div>
<div class="form-control">
	<strong>Quantity</strong>
	<span>$o->quantity</span>
</div>

</div>
HTML;



echo <<<HTML
<nav class="nav-pills">
	<div >
	<ul class="display-flex" style="list-style-type:none">
		<li class="flex-none"><a href="{$_SERVER['PHP_SELF']}">Back</a></li>
		<li class="flex-stretch"></li>
		$deletebutton
	</ul>
	</div>
</nav>
<form method="post" action="{$_SERVER['PHP_SELF']}?id=$id&action=$createorupdate">
	<div class="grid gap">
		<div class="col-xs-12 col-md-5">
			$data_show
		</div>
		<div class="col-xs-12 col-md-7">
			<div class="card soft">
			<h2>$addoredit Product</h2>
			<div class="form-control">
				<label class="form-label" for="product-title">Title</label>
				<input class="form-input" id="product-title" name="product-title" value="$o->title">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-price">Price</label>
				<input class="form-input" id="product-price" name="product-price" value="$o->price">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-category">Category</label>
				<input class="form-input" id="product-category" name="product-category" value="$o->category">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-color">Color</label>
				<input class="form-input" id="product-color" name="product-color" value="$o->color">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-size">Size</label>
				<input class="form-input" id="product-size" name="product-size" value="$o->size">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-description">Description</label>
				<textarea class="form-input" id="product-description" name="product-description" style="height:4em">$o->description</textarea>
			</div>
			<div class="form-control">
				<label class="form-label" for="product-thumbnail">Thumbnail</label>
				<input class="form-input" id="product-thumbnail" name="product-thumbnail" value="$o->thumbnail">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-images">Other Images</label>
				<input class="form-input" id="product-images" name="product-images" value="$o->images">
			</div>
			<div class="form-control">
				<label class="form-label" for="product-quantity">Quantity</label>
				<input class="form-input" id="product-quantity" name="product-quantity" value="$o->quantity">
			</div>
			<div class="form-control">
				<input type="submit" class="form-button" value="Submit">
			</div>
			</div>
		</div>
	</div>
</form>
HTML;

}







// LAYOUT

?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Product Admin-24 SOLAR TERMS</title>
	
	<?php include "../parts/meta2.php" ?>
</head>
<body>

	<header class="navbar">
		<div class="container display-flex">
			<div class="flex-stretch">
				<h2>Product Admin</h2>
			</div>
			<nav class="nav flex-none">
				<ul>
					<li><a href="../index.php">Home</a></li>
					<li><a href="index.php">Product List</a></li>
					<li><a href="?id=new">Add New Product</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<div class="container">

			<?php

			$conn = makeConn();

			if(isset($_GET['id'])){

				if($_GET['id']=="new") {
					makeProductForm($empty_product);
				} else {
					$rows = getRows($conn, "SELECT * FROM `products` WHERE `id`='{$_GET['id']}'");
					makeProductForm($rows[0]);
				}


			} else {

			?>
			<div class="card soft">
			<h2>User List</h2>

			<div class="itemlist">
			<?php

			$rows = getRows($conn, "SELECT * FROM `products`");

			echo array_reduce($rows,'makeListItemTemplate');

			?>
			</div>
			</div>

			<?php 

			}

			?>
	</div>
	
</body>
</html>