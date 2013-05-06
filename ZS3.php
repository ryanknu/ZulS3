<?php

namespace ZS3;

class S3Exception extends \Exception {}

class ZS3
{
	const DEFAULT_TIMEOUT = '20 minutes';
	
	private $awsAccessKey;
	private $awsSecretKey;
	private $bucket;
	private $timeout;
	private $headers = '';
	
	public function __construct($config = array())
	{
		if ( !count($config) ) {
			throw new S3Exception('You must instantiate with a config.');
		}
		
		if ( !isset($config['bucket']) || !isset($config['access_key']) || !isset($config['secret_key']) ) {
			throw new S3Exception('Missing a parameter');
		}
		
		$this->awsAccessKey = $config['access_key'];
		$this->awsSecretKey = $config['secret_key'];
		$this->bucket = $config['bucket'];
		$timeout_str = '+' . ( isset($config['timeout']) ? $config['timeout'] : self::DEFAULT_TIMEOUT );
		$this->timeout = strtotime($timeout_str);
	}
	
	public function addHeaders($headers)
	{
		$this->headers .= $headers;
	}
	
	public function getUrl($file, $additionalHeaders = '')
	{
		$headers = $this->headers . $additionalHeaders;
		$string = sprintf("GET\n\n\n%s\n/%s/%s", $this->timeout, $this->bucket, $file);
		$signature = $this->sign($string);
		$url = '//%s.s3.amazonaws.com/%s?AWSAccessKeyId=%s&Signature=%s&Expires=%s';
		return sprintf($url, $this->bucket, $file, $this->awsAccessKey, $signature, $this->timeout);
	}
	
	private function sign($string)
	{
		$key = $this->awsSecretKey;
		$data = utf8_encode($string);
		$blocksize = 64;
		$hashfunc = 'sha1';
		if (strlen($key)>$blocksize) {
			$key = pack('H*', $hashfunc($key));
		}
		$key = str_pad($key,$blocksize,chr(0x00));
		$ipad = str_repeat(chr(0x36),$blocksize);
		$opad = str_repeat(chr(0x5c),$blocksize);
		$hmac = pack('H*', $hashfunc( ($key^$opad).pack( 'H*',$hashfunc( ($key^$ipad).$data ) ) ) );
		$hexData = bin2hex($hmac);
		
		$raw = '';
		for ( $i = 0; $i < strlen($hexData); $i += 2) {
			$raw .= chr(hexdec(substr($hexData, $i, 2)));
		}
		return urlencode( base64_encode($raw) );
	}
}
