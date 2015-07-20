<div id="footerwrapper">
	<div id="footer" class="png">
        <div id="about">
        <?php echo image_tag('jotag/'.$sf_user->getCulture().'/footer-whatabout.jpg',array('width'=>224,'height'=>56)) ?>
        <p><?php echo __("The idea of Jotag is to manage all your contact details, both online and offline with one simple id that you choose and personalise.") ?></p>

		<p><?php echo __("It is platform independent so you can share it by voice, print, media and whatever comes to your mind.") ?></p>
        </div>
        <div id="news">
        	<div id="newscontent">
            <p><a href="#"><?php echo __("&ldquo;The best thing since Twitter&rdquo; - <strong><em>Mashable</em></strong>") ?></a></p>
            <p><a href="#"><?php echo __("&ldquo;The days of paper cards are definitely gone&rdquo; - <strong><em>Guy Kawasaki</em></strong>") ?></a></p>

            </div>
        </div>
        <div id="languages">
        <?php echo image_tag('jotag/'.$sf_user->getCulture().'/footer-languages.jpg',array('alt'=>__("languages"))) ?>
          <form action="<?php echo url_for('@switch_language_form') ?>" method="post">
            <select name='culture' onchange='this.form.submit()'>
              <?php foreach(LanguagePeer::retrieveActiveLanguages() as $language): ?>
              	<option value="<?php echo $language->getCulture() ?>"<?php if($sf_user->getCulture() == $language->getCulture()): ?> selected="selected"<?php endif; ?>><?php echo $language->getName() ?></option>
              <?php endforeach; ?>
            </select>
          </form>

        </div>
        <div id="links">
            <?php echo image_tag("jotag/".$sf_user->getCulture()."/footer-links.jpg",array('width'=>54,'height'=>24,'alt'=>__('links'))) ?>
            <ul>
            <li><?php echo link_to(__("About Jotag"),'@page?page=_about') ?></li>
            <li><?php echo link_to(__("Features"),'@page?page=_features') ?></li>
            <li><?php echo link_to(__("Press Releases"),'@page?page=_press') ?></li>

            <li><?php echo link_to(__("Contact Us"),'@page?page=_contact') ?></li>
          </ul>
        </div>
    </div>
    <!--END OF FOOTER-->
</div>
<!--END OF FOOTERWRAPPER-->