ZulS3
=====

A zend framework / general purpose S3 signing library. Currently it can only sign get requests,
but hopefully will be able to do more soon.

Full ZF2 integration

ZF2 Usage
=====
1. Clone directory to /vendor/ZS3
2. add to application.config.php modules section: 'ZS3'
3. add to global/local.config.php the ZS3 configuration array (see below)
4. From a controller, call $this->getServiceLocator()->get('ZS3');
5. call getUrl('file_name.ext'); to get a signed url to your bucket and file path.

General Usage
=====
1. create a ZS3 config array
2. use: $zs3 = new ZS3($config);
3. call getUrl('file_name.ext'); to get a signed url to your bucket and file path.
 
ZS3 Config Array
=====
	'ZS3' => array(
        'access_key' => 'sample',
        'secret_key' => 'sample',
        'bucket' =>     'bucket',
    ),