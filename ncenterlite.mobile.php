<?php

class ncenterliteMobile extends ncenterlite
{
	function init()
	{
		$oNcenterliteModel = getModel('ncenterlite');
		$config = $oNcenterliteModel->getConfig();
		$template_path = sprintf("%sm.skins/%s/",$this->module_path, $config->mskin);
		if(!is_dir($template_path)||!$config->mskin)
		{
			$config->skin = 'default';
			$template_path = sprintf("%sm.skins/%s/",$this->module_path, $config->mskin);
		}
		$this->setTemplatePath($template_path);

		$oLayoutModel = getModel('layout');
		$layout_info = $oLayoutModel->getLayout($config->mlayout_srl);

		if($layout_info)
		{
			$this->module_info->mlayout_srl = $config->mlayout_srl;
			$this->setLayoutPath($layout_info->path);
		}

	}

	function dispNcenterliteNotifyList()
	{
		$oNcenterliteModel = getModel('ncenterlite');

		$output = $oNcenterliteModel->getMyNotifyList();

		Context::set('total_count', $output->page_navigation->total_count);
		Context::set('total_page', $output->page_navigation->total_page);
		Context::set('page', $output->page);
		Context::set('ncenterlite_list', $output->data);
		Context::set('page_navigation', $output->page_navigation);

		$this->setTemplateFile('NotifyList');
	}

	function dispNcenterliteUserConfig()
	{
		$oMemberModel = getModel('member');

		$logged_info = Context::get('logged_info');
		if(!$logged_info) return new Object(-1, '로그인 사용자만 접근할 수 있습니다.');

		if($logged_info->is_admin == 'Y')
		{
			$member_srl = Context::get('member_srl');
			$member_info = $oMemberModel->getMemberInfoByMemberSrl($member_srl);
		}

		if($logged_info->is_admin != 'Y' && Context::get('member_srl'))
		{
			return new Object(-1, '다른회원의 설정을 볼 권한이 없습니다.');
		}

		$oNcenterliteModel = getModel('ncenterlite');

		if(!$member_srl)
		{
			$member_srl = $logged_info->member_srl;
		}

		$output = $oNcenterliteModel->getMemberConfig($member_srl);

		Context::set('member_info', $member_info);
		Context::set('user_config', $output->data);
		$this->setTemplateFile('userconfig');
	}

}
