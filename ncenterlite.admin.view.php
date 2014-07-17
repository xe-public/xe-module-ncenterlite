<?php
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

		$mskin_list = $oModuleModel->getSkins($this->module_path, "m.skins");
		Context::set('mskin_list', $mskin_list);

		if(!$skin_list[$config->skin]) $config->skin = 'default';
		Context::set('colorset_list', $skin_list[$config->skin]->colorset);

		if(!$mskin_list[$config->mskin]) $config->mskin = 'default';
		Context::set('mcolorset_list', $mskin_list[$config->mskin]->colorset);

		$security = new Security();
		$security->encodeHTML('config..');
		$security->encodeHTML('skin_list..title');
		$security->encodeHTML('colorset_list..name','colorset_list..title');

		$mid_list = $oModuleModel->getMidList(null, array('module_srl', 'mid', 'browser_title', 'module'));

		Context::set('mid_list', $mid_list);

	}
}
