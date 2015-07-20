<?php slot('title',__("Jotag - Login")) ?>
	<div id="login">
		<div class="logo">
			<h1><?php echo link_to("Jotag","@homepage",array("class"=>"png")) ?></h1>
			<h2><?php echo __("Welcome back! Log in to access<br />and edit your contact details!") ?></h2>
		</div>
		<div class="forms">
			<form action="<?php echo url_for('@login') ?>" method="post">
				<?php echo $login_form["referal"]->render() ?>
				<h3><?php echo __("Log into your account:") ?></h3>
				<?php if($login_form["email"]->hasError()): ?>
					<p><font color="#ff0000"><b><?php echo $login_form["email"]->getError() ?></b></font></p>
				<?php endif; ?>
				
				<?php echo $login_form["email"]->renderLabel() ?>
				<?php echo $login_form["email"]->render(array("class"=>"field")) ?>
				<br />
				<?php echo $login_form["password"]->renderLabel() ?>
				<?php echo $login_form["password"]->render(array("class"=>"field")) ?>
				<br />
				<?php echo $login_form["remember"]->render() ?> <?php echo $login_form["remember"]->renderLabel(null,array("style"=>"float:none")) ?><br />
				<input type="submit" value="Login" />
				<p><br /><?php echo __("In case of forgotten password, <a href=\"%url%\">click here</a>.",array("%url%"=>url_for("@forgotpwd"))) ?></p>
			</form>
			<h4><?php echo __("Still without Jotag?") ?></h4>
			<input type="image" src="<?php echo image_path("jotag/".$sf_user->getCulture()."/bg-create.gif") ?>" onclick="window.location.href='<?php echo url_for("@signup") ?>'" />
		</div>
	</div>
	<div class="plane"></div>