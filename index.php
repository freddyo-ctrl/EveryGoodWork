<?php
    $pageTitle = "Home";

    require_once("components/header.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<main>
		<div class="container">
			<div class="row horizontal-centered">
				<div class="col-xs-12 col-lg-12"><img class="banner" src="images/welcome-desktop.jpg"></div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-5 col-lg-4 col-xl-3">
					<div class="homeImage">
					<h2>This is a filler image.</h2><img src="https://i.picsum.photos/id/634/300/300.jpg?hmac=Xydl14x40_5ZjRDqaIAqxyQcuSub_xDcabmUtuE-eD8"></div>
				</div>
				<div class="col-xs-12 col-md-7 col-lg-4 col-xl-8">
					<div class="aboutUs">
						<h2>Encouraging the youth to fuel the future.</h2>
						<p>Here at Every Good Work in N.Texas. We believe in building a communnity. A place where everyone can gather and everyone can grow. We work with the the youth to help them become the best version of themselves they can be. We do this through voluntering programs like Weekend for Good, Leading for Good Get Involved: Ways to give and other volunteer opportunities for both youth & adults! Our organization is the hub for youth in the Arlington, Mansfield, & Grand Prairie area who want to make a dierence. There's a movement happening in DFW and we want to be a part of it</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-7 col-lg-4 col-xl-7">
					<h2>Sign-Up and Volunteer now!</h2>
					<p>Looking for ways to get invloved? Login or if you're a new member you can register and head on over to our programs page and see what opportunities you would be interested in. We have programs for both youth and adults so be sure to check them out.</p>
          <div class="horizontal-centered">
            <button class="button-primary" type="button"><a href="sign-in.php">Login!</a></button>
          </div>
          <div class="horizontal-centered">
            <button class="button-primary" type="button"><a href="register.php">Register!</a></button>
          </div>
				</div>
				<div class="col-xs-12 col-md-5 col-lg-4 col-xl-4">
				<h2>Every good work begins with you!</h2><img src="https://i.picsum.photos/id/235/300/300.jpg?hmac=wFLBzuNoyxVqKVc6x7SzFmc4gQvoHndgqGaUXaX0fB4"></div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-5 col-lg-4 col-xl-3">
				<h2>Every good work begins with you!</h2><img src="https://i.picsum.photos/id/235/300/300.jpg?hmac=wFLBzuNoyxVqKVc6x7SzFmc4gQvoHndgqGaUXaX0fB4"></div>
				<div class="col-xs-12 col-md-7 col-lg-4 col-xl-8">
					<h2>Get Involved!</h2>
					<p>Looking for ways to get invloved? Check out our available programs! Explore all the possible opportunities to get involved in your community.</p><br>
          <div class="horizontal-centered">
            <button class="button-primary" type="button"><a href="programs.php">Get Involved!</a></button>
          </div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-xl-4">
				<h2>Check Out Our Blog!</h2>
				<p>Wanna know what our latest project has been or what we've been doing recently.Check out our blog. We constantly keep this updated with new information about our projects, experiences, and milestones! Check it out!</p>
        <div class="horizontal-centered">
          <button class="button-primary" type="button"><a href="blog.php">Our Blog!</a></button>
        </div>
        <img src="https://i.picsum.photos/id/235/300/300.jpg?hmac=wFLBzuNoyxVqKVc6x7SzFmc4gQvoHndgqGaUXaX0fB4">

      </div>
				<div class="col-xs-12 col-md-12 col-xl-4">
				<h2>Learn More About Us!</h2>
				<p>Intersted in what we're all about, where we started and our hopes for the future? We've got a page where you can learn about us in depth. The things we've done and what were planning next. If you wanna learn more about why we're trying to forge a strong community for the youth look no further!</p><br>
        <div class="horizontal-centered">
          <button class="button-primary" type="button"><a href="about.php">About Us!</a></button>
        </div>
				<img src="https://i.picsum.photos/id/235/300/300.jpg?hmac=wFLBzuNoyxVqKVc6x7SzFmc4gQvoHndgqGaUXaX0fB4">

      </div>
				<div class="col-xs-12 col-md-12 col-xl-4">
					<h2>Donate and make an impact!</h2>
					<p>Every donation counts. We appreciate every cent and we thank you for aiding the movement. We believe that with donations allow us to make the most of the opportunities taht we provide. The community we serve is made better thanks to donations from those who can help. The money you put in will be used to foster, growth, education, and opportunities for the communnity that we all serve.</p>
          <div class="horizontal-centered">
						<button class="button-primary" type="button"> <a href="partners.php">Donate Now!</a></button>
					</div>
					<img src="https://i.picsum.photos/id/235/300/300.jpg?hmac=wFLBzuNoyxVqKVc6x7SzFmc4gQvoHndgqGaUXaX0fB4">

				</div>
			</div>
		</div>
	</main>
	<?php
	        require_once("components/footer.php");
	    ?>
</body>
</html>
