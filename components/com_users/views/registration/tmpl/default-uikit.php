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
	<h1 class="uk-h4"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
	<h1 class="uk-h3"><?php echo JText::_('COM_BIXPRINTSHOP_ACCOUNT_AANVRAGEN'); ?></h1>
	<p><?php echo JText::sprintf('COM_BIXPRINTSHOP_ACCOUNT_AANVRAGEN_INTRO_SPR',BixTools::config('algemeen.gegevens.bedrijfsnaam')); ?></p>
	<form id="register" class="uk-form uk-form-stacked form-validate" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post">
		<div class="uk-grid">
			<div class="uk-width-medium-1-2">
				<fieldset>
					<legend><?php echo JText::_('COM_BIXPRINTSHOP_USER_PROFILE'); ?></legend>
					<div class="uk-form-row">
						<?php echo $this->form->getLabel('geslacht','profile'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('geslacht','profile'); ?></div>
					</div>
					<div class="uk-form-row">
						<?php echo $this->form->getLabel('voornaam','profile'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('voornaam','profile'); ?></div>
					</div>
					<div class="uk-form-row">
						<?php echo $this->form->getLabel('achternaam','profile'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('achternaam','profile'); ?></div>
					</div>
					<div class="uk-form-row">
						<?php echo $this->form->getLabel('email1'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('email1'); ?></div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"><?php echo JText::_('COM_BIXPRINTSHOP_REGISTRATION_ADRES'); ?>*</label>
							<?php 
							$bixUser = BixTools::getFrontUser();
							echo $bixUser->displayAdresForm(array('control'=>'jform[adres]','context'=>'com_bixprintshop.shortadresform'));
							//pr($bixUser);
							?>
							<p class="uk-alert"><?php echo JText::_('COM_BIXPRINTSHOP_REGISTRATION_EXTRA_ADRES'); ?></p>
					</div>
					<div class="uk-hidden">
						<?php echo $this->form->getField('name')->input; ?>
						<?php echo $this->form->getField('email2')->input; ?>
					</div>
				</fieldset>
			</div>
			<div class="uk-width-medium-1-2">
				<div class="uk-panel uk-panel-box">
					<fieldset>
						<legend><?php echo JText::_('COM_BIXPRINTSHOP_USER_DETAILS'); ?></legend>
						<div class="uk-form-row">
							<?php echo $this->form->getLabel('username'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('username'); ?></div>
						</div>
						<div class="uk-form-row">
							<?php echo $this->form->getLabel('password1'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('password1'); ?></div>
						</div>
						<div class="uk-form-row">
							<?php echo $this->form->getLabel('password2'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('password2'); ?></div>
						</div>
						<div class="uk-form-row">
							<?php echo $this->form->getLabel('tos','profile'); ?><div class="uk-form-controls"><?php echo $this->form->getInput('tos','profile'); ?></div>
						</div>
					</fieldset>
				</div>
			</div>	
		</div>
		<div class="uk-grid">
			<div class="uk-width-medium-1-2">
				<br/>
			</div>
			<div class="uk-width-medium-1-2">
				<button type="submit" class="uk-button uk-button-primary uk-button-large uk-button-expand validate">
					<i class="uk-icon-user"></i>&nbsp;&nbsp;&nbsp;<?php echo JText::_('COM_BIXPRINTSHOP_REGISTRATION_REGISTER'); ?>
				</button>
			</div>
		</div>

		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="registration.register" />
		<?php echo JHtml::_('form.token');?>
		
	</form>

</div>