<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php')) {
	require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';
} else {
	jexit("Bixie Printshop required!");
}

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.mootools');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

BixTools::loadCSS();
JFactory::getLanguage()->load('com_bixprintshop');

$sRegisterItemid = BixTools::config('algemeen.registerItemid')?'&Itemid='.BixTools::config('algemeen.registerItemid'):'';
$return = JRoute::_('index.php?option=com_bixprintshop&view=user'.$sRegisterItemid);

?>
<script>
window.addEvent('domready', function() {
	new bixRegisterHelp();
});
var bixRegisterHelp = new Class ({
	initialize: function () {
		this.voornaam = document.getElement('input[name*=\[voornaam\]]');
		this.achternaam = document.getElement('input[name*=\[achternaam\]]');
		this.name = document.getElement('input[name*=\[name\]]');
		this.email1 = document.getElement('input[name*=\[email1\]]');
		this.email2 = document.getElement('input[name*=\[email2\]]');
		var self = this;
		[this.voornaam,this.achternaam].each(function(inputEl) {
			inputEl.addEvent('change',function() {
				self.setName();
			});
		});
		this.email1.addEvent('change',function() {
			self.email2.set('value',self.email1.get('value'));
		});
		this.setName();
		this.email2.set('value',this.email1.get('value'));
	},
	setName: function () {
		var voornaam = this.voornaam.get('value');
		var vollnaam = voornaam!=''?voornaam+' '+this.achternaam.get('value'):this.achternaam.get('value');
		this.name.set('value',vollnaam);
		
	}
});
</script>
<div id="system" class="contentwrapper">
	
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
	<h1><?php echo JText::_('COM_BIXPRINTSHOP_ACCOUNT_AANVRAGEN'); ?></h1>
	<p><?php echo JText::sprintf('COM_BIXPRINTSHOP_ACCOUNT_AANVRAGEN_INTRO_SPR',BixTools::config('algemeen.gegevens.bedrijfsnaam')); ?></p>
	<form id="register" class="small style form-validate" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post">
		<div class="grid-block width100">
		<div class="grid-box width50">
			<div class="form">
			<h3>Mijn gegevens</h3>
				<ul class="rawlist formlist">					
					<li>
						<?php echo $this->form->getField('geslacht','profile')->input; ?>
					</li>
					<li><?php echo $this->form->getField('voornaam','profile')->label; ?>
						<?php echo $this->form->getField('voornaam','profile')->input; ?>
					</li>
					<li><?php echo $this->form->getField('achternaam','profile')->label; ?>
						<?php echo $this->form->getField('achternaam','profile')->input; ?>
					</li>
					<li><?php echo $this->form->getField('email1')->label; ?>
						<?php echo $this->form->getField('email1')->input; ?>
					</li>					
				</ul>
				<ul class="rawlist formlist">
					<li class="reg_adresform">
						<label><?php echo JText::_('COM_BIXPRINTSHOP_REGISTRATION_ADRES'); ?>*</label>
							<div class="form">
								<?php 
								$bixUser = BixTools::getFrontUser();
								echo $bixUser->displayAdresForm(array('control'=>'jform[adres]','context'=>'com_bixprintshop.shortadresform'));
								//pr($bixUser);
								?>
								<p class="box-info"><?php echo JText::_('COM_BIXPRINTSHOP_REGISTRATION_EXTRA_ADRES'); ?></p>
							</div>
							<div class="clear"></div>
					</li>
				</ul>					
				<div class="hidden">
					<?php echo $this->form->getField('name')->input; ?>
					<?php echo $this->form->getField('email2')->input; ?>
				</div>
			</div>
		</div>
		<div class="grid-box width50">
			<div class="form">
			<h3><?php echo JText::_('COM_BIXPRINTSHOP_USER_DETAILS'); ?></h3>
				<ul class="rawlist formlist">
				<li><?php echo $this->form->getField('username')->label; ?>
					<?php echo $this->form->getField('username')->input; ?>
				</li>
				<li><?php echo $this->form->getField('password1')->label; ?>
					<?php echo $this->form->getField('password1')->input; ?>
				</li>
				<li><?php echo $this->form->getField('password2')->label; ?>
					<?php echo $this->form->getField('password2')->input; ?>
				</li>
				</ul>
			</div>
			<ul class="rawlist formlist checks">
				<li><?php echo $this->form->getField('tos','profile')->input; ?>
					<?php echo $this->form->getField('tos','profile')->label; ?>
				</li>	
			</ul>
			<button class="validate flt_lft" type="submit"><?php echo JText::_('COM_BIXPRINTSHOP_REGISTRATION_REGISTER'); ?></button>
		</div>	
		</div>

	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="registration.register" />
	<?php echo JHtml::_('form.token');?>
		
	</form>

</div>