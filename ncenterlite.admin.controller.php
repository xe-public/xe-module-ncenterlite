<?php
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
		$config->document_module_srls = context::get('document_module_srls');
		$config->document_format = Context::get('document_format');
		if(!$config->mention_format && !is_array($config->mention_format)) $config->mention_format = array();

		$config->skin = Context::get('skin');
		$config->mskin = Context::get('mskin');
		$config->mcolorset = Context::get('mcolorset');
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

	/**
	 * @brief 스킨 테스트를 위한 더미 데이터 생성
	 **/
	function procNcenterliteAdminInsertDummyData()
	{
		$oNcenterliteController = &getController('ncenterlite');
		$logged_info = Context::get('logged_info');

		for($i = 1; $i <= 5; $i++)
		{
			$args = new stdClass();
			$args->member_srl = $logged_info->member_srl;
			$args->srl = 1;
			$args->target_srl = 1;
			$args->type = $this->_TYPE_TEST;
			$args->target_type = $this->_TYPE_TEST;
			$args->target_url = getUrl('');
			$args->target_summary = '[*] 시험용 알림입니다' . rand();
			$args->target_nick_name = $logged_info->nick_name;
			$args->regdate = date('YmdHis');
			$args->notify = $oNcenterliteController->_getNotifyId($args);
			$output = $oNcenterliteController->_insertNotify($args);
		}
	}
	function procNcenterliteAdminInsertPushData()
	{
		$oNcenterliteController = getController('ncenterlite');
		$logged_info = Context::get('logged_info');

		$args = new stdClass();
		$args->member_srl = $logged_info->member_srl;
		$args->srl = 1;
		$args->target_srl = 1;
		$args->type = $this->_TYPE_DOCUMENT;
		$args->target_type = $this->_TYPE_COMMENT;
		$args->target_url = getUrl('');
		$args->target_summary = '[*] 시험용 알림입니다' . rand();
		$args->target_nick_name = $logged_info->nick_name;
		$args->regdate = date('YmdHis');
		$args->notify = $oNcenterliteController->_getNotifyId($args);
		$output = $oNcenterliteController->_insertNotify($args);
	}
}
