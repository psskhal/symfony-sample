<?php slot('title',__("Jotag - Signup")) ?>
	<div id="login">
		<div class="logo">
			<h1><?php echo link_to("Jotag","@homepage",array("class"=>"png")) ?></h1>
			<h2><?php echo __("Congratulations, you have just decided to create your own Jotag! It is the fastest and coolest way to share your contact details. Please enter some basic info to start.") ?></h2>
		</div>
		<div class="forms">
			<form action="<?php echo url_for('@signup') ?>" method="POST">
				<h3><?php echo __("Create an account:") ?></h3>
				<?php echo $form["first_name"]->renderRow() ?>
				<?php echo $form["last_name"]->renderRow() ?>
				<div class="cl">
					<?php echo $form["email"]->renderRow() ?>
					<?php echo $form["password"]->renderRow() ?>
					<?php echo $form["rpassword"]->renderRow() ?>
				</div>
				<input type="image" src="<?php echo image_path("jotag/".$sf_user->getCulture()."/bg-account.gif") ?>" />
			</form>
		</div>
	</div>
	<div class="plane"></div>