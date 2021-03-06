<?php

// include, require, include_once, require_once
include_once "lib/php/functions.php";
include_once "parts/templates.php";

$data = getRows(
	makeConn(),
	"SELECT * FROM `products` WHERE `id` = '{$_GET['id']}'"
);
$o = $data[0];
$images = explode(",",$o->images);


?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Product Item-24 SOLAR TERMS</title>
	
	<?php include "parts/meta.php" ?>
</head>
<body>

	<?php include "parts/navbar.php" ?>



    

<div class="cardblue">
	<div class="container">
		<nav class="nav-crumbs" style="margin:1em 0">
			<ul>
				<li><a href="product_list.php">Back</a></li>
			</ul>
		</nav>

		<div class="grid gap">
			<div class="col-xs-12 col-md-7">
				<div>
					<div class="product-main">
						<img src="img/<?= $o->thumbnail ?>" alt="">
					</div>

				</div>
			</div>
			<div class="col-xs-12 col-md-5">
				<form method="get" action="data/form_actions.php">
					<div class="card-section">
						<h2><?= $o->title ?></h2>
						<div class="product-description">
							<div class="product-price"><h3>&dollar;<?= $o->price ?></h3></div>

							<div style="margin-top:80px;">
                                <p style="display: inline;">Color:  <p style="display: inline;"><?= $o->color ?></p></p>
							    <p style="display: inline;">Size:  <p style="display: inline;"><?= $o->size ?></p></p>
						    </div>
							
						</div>
					</div>
					<div class="card-section">
						<label class="form-label"><p style="display: inline;">Amount</p></label>
						<div class="form-select" style="display: inline;">
							<select name="amount">
								<!-- option*10>{$} -->
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
							</select>
						</div>
					</div>

                    <hr>

					<div class="btnstyle card-section btnspace">
						<button class="btn first">
						<input type="hidden" name="action" value="add-to-cart">
						<input type="hidden" name="id" value="<?= $o->id ?>">
						<input type="hidden" name="price" value="<?= $o->price ?>">
						Add To Cart
					    </button>
					</div>

				</form>
			</div>
		</div>
		<div>
			<h3>Description</h3>
			<div><p><?= $o->description ?></p></div>
		</div>
	</div>

</div>


    
    <div class="container">

        <div>
			<h2>Recommended Products</h2>
			<?php recommendedSimilar($o->category,$o->id) ?>
		</div>

	</div>









	

<?php include "parts/footer.php" ?>

</body>
</html>