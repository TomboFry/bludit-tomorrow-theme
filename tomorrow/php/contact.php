<?php 
/**
 *  Contact layout
 *
 *  @package: Bludit
 *  @subpackage: Contact
 *  @author: Frédéric K.
 *  @copyright: 2015-2016 Frédéric K.
 *  @info: Duplicate this layout in your themes/YOUR_THEME/php/ 
 *	for a custom template.
 */		
?>
<form method="post" action="<?php echo $Site->url(). $Page->slug(); ?>" id="form-contact">
			<input type="hidden" name="token" value="<?php echo $Security->printTokenCSRF(); ?>">
			<label for="form-name"><?php echo $Language->get('Name'); ?>:</label>
			<input id="form-name" type="text" name="name" value="<?php echo sanitize::html($name); ?>" placeholder="<?php echo $Language->get('Name'); ?>" required>
			<label for="form-email"><?php echo $Language->get('Email'); ?>:</label>
			<input id="form-email" type="email" name="email" value="<?php echo sanitize::email($email); ?>" placeholder="<?php echo $Language->get('Email'); ?>" required>
			<label for="form-message"><?php echo $Language->get('Message'); ?>:</label>
			<textarea id="form-message" rows="6" name="message" placeholder="<?php echo $Language->get('Message'); ?>" required><?php echo sanitize::html($message); ?></textarea>
		<input type="checkbox" name="interested">
		<button id="submit" name="submit" type="submit"><?php echo $Language->get('Send'); ?></button>
</form>
