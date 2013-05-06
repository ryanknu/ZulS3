<?php

namespace ZS3;

class Module
{
	public function getConfig()
    {
        return array();
    }
    
    public function getServiceConfig()
    {
        return array(
        	'factories' => array('ZS3' => 'ZS3\ZS3Factory')
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/',
                ),
            ),
        );
    }
}
