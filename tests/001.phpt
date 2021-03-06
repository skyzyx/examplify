--TEST--
Apply filters

--FILE--
<?php
	require_once dirname(__DIR__) . '/src/Examplify.php';
	use Skyzyx\Components\Examplify;

	$file = file_get_contents(__DIR__ . '/sample.php');
	$example = new Examplify($file);
	echo $example->output();
?>

--EXPECT--
<?php

// Instantiate object
$s3 = new AmazonS3();
$rfc2616 = $s3->util->konst($s3->util, 'DATE_FORMAT_RFC2616');

$version_id = (string) $s3->get_object('bucket', 'filename', array(
	'versionId' => 'abc999',
))->body->Versions->VersionId;

$version_id = (string) $s3->get_object('bucket', 'filename', array(
	'versionId' => 'abc123',
	'secret_code' => '123456'
))->body->Versions->VersionId;

$response = $s3->copy_object('bucket', 'filename', array(
	'fishsticks1' => 'true',
	'fishsticks2' => 'false'
));

$more_code = $s3->get_object('bucket', 'filename.ext');

?>
