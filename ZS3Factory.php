<?php

namespace ZS3;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ZS3Factory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get('Config');
		if ( $config && isset($config['ZS3']) ) {
			$configParams = $config['ZS3'];
		} else {
			$configParams = array();
		}
		
		return new ZS3($configParams);
	}
}
