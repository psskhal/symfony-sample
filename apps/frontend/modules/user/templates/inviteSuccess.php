<?php slot('title',__('Jotag - invite friends')) ?>
<?php slot('header','Invite Friends') ?>
<?php use_helper('Javascript') ?>
		<script type="text/javascript">
			function addMoreEmails()
			{
				$("more_emails").show();
				$("add_more_link").remove();
				
				return false;
			}
		</script>
		<div class="title">
			<h1><?php echo __("Jotag is free to use. Invite friends to join.") ?></h1>
			<p><?php echo __("Like Jotag? Help us spread the word about it. Send invitations to your friends via email.") ?></p>
		</div>		

		<div class="invite_friends">
		
			<?php if ($sf_user->hasFlash('message')): ?>
				<div id="message_<?=strtolower($sf_user->getFlash('type')) ?>">
					<?php 
						switch($sf_user->getFlash('message'))
						{
							case "ALL_REGISTERED": print __("All of your contacts are already JoTAG members"); break;
							case "SENT": print __("%count% invites sent!",array("%count%"=>$sf_user->getFlash('params'))); break;
						}
					?>
				</div>	
			<?php endif; ?>

			<h2><?php echo __("Option 1: Retrieve addresses from your email account<br />and select which friends will receive invitation:") ?></h2>
			<?php echo image_tag("jotag/email-logos.png",array("class"=>"png providers")) ?>
			
			<?=form_remote_tag(array(
				'update'	=> 'provider_script',
				'url'		=> '@invite_webmail',
  				'loading'	=> "Element.show('indicator');Element.writeAttribute('webmail_display','disabled',true)",
  				'complete'	=> "Element.hide('indicator');Element.writeAttribute('webmail_display','disabled',false)",
				'script'	=> true),array("class"=>"generic")) ?>

				<?php echo $wbForm["username"]->renderLabel() ?>
				<?php echo $wbForm["password"]->renderLabel() ?>
				<br />
				<?php echo $wbForm["username"]->render() ?>
				<?php echo $wbForm["password"]->render() ?>
				<button id="webmail_display">OK</button>
				<?echo image_tag('indicator.gif',array('style'=>'display:none','id'=>'indicator')) ?>

				<br />
				<div id="provider_script"></div>
			</form>
			
			<h2><?php echo __("Option 2: Enter emails manually:") ?></h2>
			
			<form action="<?php echo url_for('@invite') ?>" method="post" class="generic">
				<label><?php echo __("First Name") ?></label> <label><?php echo __("Last Name") ?></label> <label><?php echo __("Email") ?></label>
				<br />
				<?php echo $form["emails"][0]["first_name"]->render() ?> <?php echo $form["emails"][0]["last_name"]->render() ?> <?php echo $form["emails"][0]["email"]->render() ?> <?php if($form["emails"][0]["email"]->hasError()): ?> <span class="form-error">&larr; <?=$form["emails"][0]["email"]->getError() ?></span><?php endif; ?><br/>
				<?php echo $form["emails"][1]["first_name"]->render() ?> <?php echo $form["emails"][1]["last_name"]->render() ?> <?php echo $form["emails"][1]["email"]->render() ?> <?php if($form["emails"][1]["email"]->hasError()): ?> <span class="form-error">&larr; <?=$form["emails"][1]["email"]->getError() ?></span><?php endif; ?><br/>
				<?php echo $form["emails"][2]["first_name"]->render() ?> <?php echo $form["emails"][2]["last_name"]->render() ?> <?php echo $form["emails"][2]["email"]->render() ?> <?php if($form["emails"][2]["email"]->hasError()): ?> <span class="form-error">&larr; <?=$form["emails"][2]["email"]->getError() ?></span><?php endif; ?><br/>
				<?php if(!$show_more): ?>
					<p id="add_more_link"><a href="#" onclick="return addMoreEmails()"><?php echo __("[More Emails]") ?></a></p>
				<?php endif ?>
				<div id="more_emails"<?php if(!$show_more): ?> style="display:none;"<?php endif ?>>
					<?php echo $form["emails"][3]["first_name"]->render() ?> <?php echo $form["emails"][3]["last_name"]->render() ?> <?php echo $form["emails"][3]["email"]->render() ?> <?php if($form["emails"][3]["email"]->hasError()): ?> <span class="form-error">&larr; <?=$form["emails"][3]["email"]->getError() ?></span><?php endif; ?><br/>
					<?php echo $form["emails"][4]["first_name"]->render() ?> <?php echo $form["emails"][4]["last_name"]->render() ?> <?php echo $form["emails"][4]["email"]->render() ?> <?php if($form["emails"][4]["email"]->hasError()): ?> <span class="form-error">&larr; <?=$form["emails"][4]["email"]->getError() ?></span><?php endif; ?><br/>
					<?php echo $form["emails"][5]["first_name"]->render() ?> <?php echo $form["emails"][5]["last_name"]->render() ?> <?php echo $form["emails"][5]["email"]->render() ?> <?php if($form["emails"][5]["email"]->hasError()): ?> <span class="form-error">&larr; <?=$form["emails"][5]["email"]->getError() ?></span><?php endif; ?><br/>
				</div>
				<br />
				<button>INVITE FRIENDS</button>
			</form>
            <br />
            <h2><?php echo __("Option 3: Post On Your Facebook Wall:") ?></h2>
            <div id="message_success" style="display:none;">Content Successfully posted on your facebook wall</div>
            <script type="text/javascript">
			function onConnected()
			{
				document.getElementById('connectBtn').style.display="none";
				document.getElementById('postLink').style.display="block";
			}
			function onNotConnected()
			{
				document.getElementById('connectBtn').style.display="block";
				document.getElementById('postLink').style.display="none";
			}
			</script>
            <script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US" type="text/javascript"></script><script type="text/javascript">
			FB.init("61fc97ef2173ce0fcf4b0ae7be3dbaac");
            //FB.init({"ifUserConnected":onConnected(), "ifUserNotConnected":onNotConnected()});
			function hideLoginBtn()
			{
				document.getElementById('connectBtn').style.display="none";
				document.getElementById('postLink').style.display="block";
			}
            </script>
            <fb:login-button v="2" id="connectBtn" onlogin="hideLoginBtn()" size="medium">Connect</fb:login-button>
            
            <a href="javascript:;" id="postLink" onClick="postthis();" style="display:none;">Post On Wall</a>
            <script type="text/javascript">
			function stream_callback (post_id, exception) 
			{
              if(post_id!="null")
			  {
				 <?php echo remote_function(array(
					'update'  => 'message_success',
					'url'     => '@fbpost',
				  )); ?>
				  //alert(post_id);
				  document.getElementById('postLink').style.display='none';
				  document.getElementById('connectBtn').style.display='none';
				  document.getElementById('message_success').style.display='block'
				  //FB.Connect.logout(alert("Thanks"));
			  }
            }
            function postthis()
            {
			var message = 'Check out this cool site.';
			var attachment = {
				'name': 'JoTag',
				'href': 'http://'+document.domain+'/jotag/web',
				'description': 'Jotag is a simple method to share all your contact details. To keep in touch, just tell them your Jotag!',
				'media': [{ 'type': 'image', 'src': 'http://'+document.domain+'/jotag/web/images/jotag/logo-s.png', 'href': 'http://'+document.domain+'/jotag/web'}]
				}; 
			var action_links = [{'text':'Recaption this', 'href':'http://bit.ly/19DTbF'}];  
			FB.Connect.streamPublish(message, attachment, action_links, null, null, stream_callback);
            
            }
			//alert(FB.Connect.ifUserConnected);
            </script>
            
		</div>