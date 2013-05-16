<?php
/**
 * @author XE Magazine <info@xemagazine.com>
 * @link http://xemagazine.com/
 **/
class ncenterliteAdminView extends ncenterlite
{
	function init()
	{
		$this->setTemplatePath($this->module_path.'tpl');

		if(version_compare(__ZBXE_VERSION__, '1.7.0', '>='))
		{
			$this->setTemplateFile(str_replace('dispNcenterliteAdmin', '', $this->act));
		}
		else
		{
			$this->setTemplateFile(str_replace('dispNcenterliteAdmin', '', $this->act) . '.1.5');
		}
	}

	function dispNcenterliteAdminConfig()
	{
		$oModuleModel = &getModel('module');
		$oNcenterliteModel = &getModel('ncenterlite');
		$config = $oNcenterliteModel->getConfig();
		Context::set('config', $config);

		$skin_list = $oModuleModel->getSkins($this->module_path);
		Context::set('skin_list', $skin_list);

		if(!$skin_list[$config->skin]) $config->skin = 'default';
		Context::set('colorset_list', $skin_list[$config->skin]->colorset);

		$security = new Security();
		$security->encodeHTML('config..');
		$security->encodeHTML('skin_list..title');
		$security->encodeHTML('colorset_list..name','colorset_list..title');

		$mid_list = $oModuleModel->getMidList(null, array('module_srl', 'mid', 'browser_title', 'module'));

		Context::set('mid_list', $mid_list);

		// 사용환경정보 전송 확인
		$ncenterlite_module_info = $oModuleModel->getModuleInfoXml('ncenterlite');
		$agreement_file = FileHandler::getRealPath(sprintf('%s%s.txt', './files/cache/ncenterlite-', $ncenterlite_module_info->version));

		if(file_exists($agreement_file))
		{
			$agreement = FileHandler::readFile($agreement_file);
			Context::set('_ncenterlite_env_agreement', $agreement);
			if($agreement == 'Y')
			{
				$_ncenterlite_iframe_url = 'http://xmz.kr/index.php?mid=ncenterlite_iframe';
				$_host_info = urlencode($_SERVER['HTTP_HOST']) . '-NC' . $ncenterlite_module_info->version . '-PHP' . phpversion() . '-XE' . __XE_VERSION__;
				Context::set('_ncenterlite_iframe_url', $_ncenterlite_iframe_url . '&_host='. $_host_info);
				Context::set('ncenterlite_module_info', $ncenterlite_module_info);
			}
		}
		else Context::set('_ncenterlite_env_agreement', 'NULL');
	}
}
