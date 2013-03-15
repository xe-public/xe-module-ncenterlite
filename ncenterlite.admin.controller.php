<?php
/**
 * @author XE Magazine <info@xemagazine.com>
 * @link http://xemagazine.com/
 **/
class ncenterliteAdminController extends ncenterlite
{
	function procNcenterliteAdminInsertConfig()
	{
		$oModuleController = &getController('module');

		$config->use = Context::get('use');
		
		$config->mention_format = Context::get('mention_format');
		$config->document_notify = Context::get('document_notify');
		$config->message_notify = Context::get('message_notify');
		$config->hide_module_srls = Context::get('hide_module_srls');
		if(!$config->mention_format && !is_array($config->mention_format)) $config->mention_format = array();

		$config->skin = Context::get('skin');
		$config->colorset = Context::get('colorset');
		$config->zindex = Context::get('zindex');
		if(!$config->document_notify) $config->document_notify = 'direct-comment';

		$this->setMessage('success_updated');

		$oModuleController->updateModuleConfig('ncenterlite', $config);

		if(!in_array(Context::getRequestMethod(),array('XMLRPC','JSON')))
		{
			$returnUrl = Context::get('success_return_url') ? Context::get('success_return_url') : getNotEncodedUrl('', 'module', 'admin', 'act', 'dispNcenterliteAdminConfig');
			header('location: ' . $returnUrl);
			return;
		}
	}
}
