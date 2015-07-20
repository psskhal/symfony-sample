<ul>
	<?php foreach ( $results as $u ): ?>
		<li id="<?php echo $u->getUserId() ?>"><?php echo $u->getEmail() ?></li>	
	<?php endforeach; ?>
</ul>