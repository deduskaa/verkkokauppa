<?php 
require_once('../login.php');
require_once('../yhteiset/dbYhteys.php');
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pokemondeals</title>
	<link href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/shift.css" rel="stylesheet">
	<link rel="stylesheet" href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css">
	<link rel="stylesheet" href="../css/main.css">
	<script src="../js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="../js/jquery.leanModal.min.js"></script>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../css/loginbox.css" />
	<script type="text/javascript" id="snipcart" src="https://app.snipcart.com/scripts/snipcart.js"
    data-api-key="ZTIyNzAwMTYtOThjZC00NDcxLThlYjYtOGVmNmYzYjIwMTk5"></script>
	<link id="snipcart-theme" type="text/css" href="https://app.snipcart.com/themes/base/snipcart.css" rel="stylesheet">
  </head>
  <body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="../index.php">Pokemondeals</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li><a href="../products.php">Products</a></li>
		  </ul>
		  <form class="navbar-form navbar-left" role="search" action="Hakutulos.php">
			<div class="form-group">
			  <input type="text" class="form-control" size="100" name="searchText" placeholder="Search by name or type">
			</div>
			<button type="submit" name="submit" class="btn btn-default">Submit</button>
		  </form>
		  <ul class="nav navbar-nav navbar-right">
			<?php if ($_SESSION['kirjautunut'] == 'juujuu'): ?>
				  <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=logout" data-auto-logout-link="true">Logout</a></li>
				  <?php else: ?>
				  <li><a id="modal_trigger" href="#modal" action="../js/loginpopup.php">Log In</a></li>
				  <?php endif;?>
				  <li><a href="#" class="snipcart-checkout">Checkout</a></li>
				  <li><span class="snipcart-summary">
				  <p>Number of items: <span class="snipcart-total-items"></span><br />
				  Total price: <span class="snipcart-total-price"></span></p>
				  </span></li>	  
		  </ul>
		  
			<div id="modal" class="popupContainer" style="display:none;">
				<header class="popupHeader">
					<span class="header_title">Login</span>
					<span class="modal_close"><i class="fa fa-times"></i></span>
				</header>	
				<section class="popupBody">
				<!-- Social Login -->
					<div class="social_login">
						<div class="centeredText">
							<div class="fb-login-button" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>
						</div>

						<div class="centeredText">
							<span>Or use your Email address</span>
						</div>

						<div class="action_btns">
							<div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
							<div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
						</div>
					</div>

				<!-- Username & Password Login form -->
					<div class="user_login">
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							<label>Email</label>
							<input type="text" name="email" /><br />
							<label>Password</label>
							<input type="password" name="pwd" /><br />
							<div class="checkbox">
								<input id="remember" type="checkbox" />
								<label for="remember">Remember me on this computer</label>
							</div>
							<div class="action_btns">
								<div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
								<div class="one_half last"><input type="submit" name="login" value="Login" class="btn btn_red" /></div>		
							</div>
						</form>

						<a href="#" class="forgot_password">Forgot password?</a>
					</div>

				<!-- Register Form -->
					<div class="user_register">
						<form method="POST" action="save.php">
							<label>Full Name</label>
							<input type="text" name="fullName" /><br />
							<label>Email Address</label>
							<input type="email" name="newEmail"/><br />
							<label>Password</label>
							<input type="password" name="newPwd"/><br />
							<div class="checkbox">
								<input id="send_updates" type="checkbox" />
								<label for="send_updates">Send me occasional email updates</label>
							</div>
							<div class="action_btns">
								<div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
								<div class="one_half last"><input type="submit" class="btn btn_red" value="Register"></div>
							</div>
						</form>
					</div>
				</section>
			</div>	
			<script type="text/javascript" src="js/login.js"></script>	  
		</div>
	  </div>
	</nav>
      <div class="container">
    </div>
	<?php 
		$sql = "SELECT 
			Pokemon.ID,
			Pokemon.Nimi,
			Sukupuoli.Sukupuoli,
			Hinta.Hinta,
			Pokemon.SivuUrl,
			Pokemon.Kuvaus,
			Kuva.URL,
			Tyyppi.Tyyppi
		FROM
			Pokemon,
			Tyyppi,
			PokemonTyyppi,
			Sukupuoli,
			Hinta,
			Kuva,
			PokemonKuva
		WHERE
			Hinta.ID = Pokemon.Hinta AND
			Sukupuoli.ID = Pokemon.Sukupuoli AND
			Pokemon.Nimi = \"Ekans\" AND
			Kuva.ID = PokemonKuva.KuvaID AND
			PokemonKuva.PokemonID = Pokemon.ID AND
			Pokemon.ID=PokemonTyyppi.PokemonID AND
			Tyyppi.ID=PokemonTyyppi.TyyppiID; ";
				
			$STH = @$DBH->query($sql);
			$STH->setFetchMode(PDO::FETCH_ASSOC);
			$row = $STH->fetch();
	?>
	<div class="page-header">
		<h1><?php echo $row['Nimi']; ?></h1>
	</div>
	<div class="row">
		<div class="pokemonCont">
			<div class="container"> 
				<div class="col-sm-6 col-md-6">
					<div class='imageCont'>
					  <img src="<?php echo $row['URL']; ?>" alt="kuva">
					</div>
				</div>
			  	<div class="col-sm-6 col-md-6">
					<h3><?php echo $row['Nimi']; ?></h3>
					<p><?php echo $row['Kuvaus']; ?></p>
					<h2>Type1: <?php echo $row['Tyyppi']; ?></h2>
					<h2>Type2: <?php echo $row['Tyyppi2']; ?></h2>
					<h2>Gender: <?php echo $row['Sukupuoli'] ?></h2>
					<h2>Price: <?php echo $row['Hinta']; ?> € </h2>
					<p><a href="#" class="snipcart-add-item btn btn-default"
							data-item-id="<?php echo $row['ID']; ?>"
							data-item-name="<?php echo $row['Nimi']; ?>"
							data-item-price="<?php echo $row['Hinta']; ?>"
							data-item-url="<?php echo $row['SivuUrl']; ?>"
							data-item-description="<?php echo $row['Kuvaus']; ?>"
							role="button">Add to cart</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	
    <div class="learn-more">
	  <div class="container">
		<div class="row">
	      <div class="col-md-4">
			<h3>About Us</h3>
			<p>POKEMONDIILERS DIILING POKEMON FOR EVERYONE</p>			
			<p><a href="#">Contact Us</a></p>
	      </div>
		  <div class="col-md-4">
			<h3>Terms & Conditions</h3>
			<p>You don't have any</p>
			<p><a href="#">Don't read these</a></p>
		  </div>
		  <div class="col-md-4">
			<h3>Trust and Safety</h3>
			<p>We will steal all your money</p>
			<p><a href="#">Why are you still here?</a></p>
		  </div>
	    </div>
	  </div>
	</div>
  </body>
</html>