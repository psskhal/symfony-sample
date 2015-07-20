<?php use_helper('I18N') ?>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menubackgr" style="padding-left:5px;">
				<div id="myMenuID"></div>
		<script language="JavaScript" type="text/javascript">
		var myMenu =
		[
			[null,'<?=__('Home')?>','<?=url_for('admin/index') ?>',null,'<?=__('Home')?>'],
			[null,'<?=__("Site")?>',null,null,'<?=__("Site Management")?>',
				['<?=image_tag('sf_admin/menu/config.png') ?>','<?=__('Global Options')?>','<?=url_for('options/index') ?>',null,'<?=__('Options')?>'],
				['<?=image_tag('sf_admin/menu/language.png') ?>','<?=__('Localization')?>',null,null,'<?=__('Localization')?>',
					['<?=image_tag('sf_admin/menu/language.png') ?>','<?=__('Language Manager')?>','<?=url_for('language/index') ?>',null,'<?=__('Manage Languages')?>'],
				],
				['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Template Manager')?>',null,null,'<?=__('Manage Templates')?>',
					['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Layout Templates')?>','<?=url_for('template/list?m=layout') ?>',null,'<?=__('Layout Templates')?>'],
					_cmSplit,
					['<?=image_tag('sf_admin/menu/messaging_inbox.png') ?>','<?=__('Emails Templates')?>','<?=url_for('template/list?m=email') ?>',null,'<?=__('Emails Templates')?>'],
					['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Static Pages Templates')?>','<?=url_for('template/list?m=page') ?>',null,'<?=__('Static Pages Templates')?>'],
					['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Error Pages Templates')?>','<?=url_for('template/list?m=error') ?>',null,'<?=__('Error Pages Templates')?>'],
					['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Badge Templates')?>','<?=url_for('template/list?m=badge') ?>',null,'<?=__('Badge Templates')?>'],
					_cmSplit,
					['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Modules Templates')?>',null,null,'<?=__('Modules Templates')?>',
						['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('User')?>','<?=url_for('template/list?m=user') ?>',null,'<?=__('User')?>'],
						['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Contact')?>','<?=url_for('template/list?m=contact') ?>',null,'<?=__('Contact')?>'],
						['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Jotag')?>','<?=url_for('template/list?m=jotag') ?>',null,'<?=__('Jotag')?>'],
						['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Purchase')?>','<?=url_for('template/list?m=buy') ?>',null,'<?=__('Purchase')?>'],
					],
				],
			],
			[null,'<?=__("Contents")?>',null,null,'<?=__("Contents Manager")?>',
				['<?=image_tag('sf_admin/menu/users.png') ?>','<?=__('User Manager')?>','<?=url_for('user/index') ?>',null,'<?=__('Manage Users')?>'],
				['<?=image_tag('sf_admin/menu/controlpanel.png') ?>','<?=__('JoTAG Manager')?>','<?=url_for('tag/index') ?>',null,'<?=__('Manage JoTAGs')?>'],
				['<?=image_tag('sf_admin/menu/content.png') ?>','<?=__('Badge Manager')?>','<?=url_for('badge/index') ?>',null,'<?=__('Manage Badges')?>'],
				['<?=image_tag('sf_admin/menu/messaging.png') ?>','<?=__('Email Manager')?>','<?=url_for('email/index') ?>',null,'<?=__('Manage Emails')?>'],
				['<?=image_tag('sf_admin/menu/edit.png') ?>','<?=__('Article Manager')?>','<?=url_for('article/index') ?>',null,'<?=__('Manage Articles')?>'],
				['<?=image_tag('sf_admin/menu/query.png') ?>','<?=__('Order Manager')?>','<?=url_for('payment/index') ?>',null,'<?=__('Manage Orders')?>'],
			]
		];
		cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
		</script>
	</td>
	<td class="menubackgr" align="right">
	</td>
	<td class="menubackgr" align="right" style="padding-right:5px;">
		<?=link_to('Logout','admin/logout',array('style'=>"color: #333333; font-weight: bold")) ?>
	</td>
</tr>
</table>
