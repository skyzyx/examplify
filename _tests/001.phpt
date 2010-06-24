--FILE--
Apply filters

--TEST--
<?php
	require_once '../examplify.class.php';

	$file = file_get_contents('sample.php');

	$example = new Examplify($file);
	echo $example->output();
?>

--EXPECT--
// Instantiate object
$s3 = new AmazonS3();

$version_id = (string) $s3->get_object('bucket', 'filename', array(
	'versionId' => 'abc123',
))->body->Versions->VersionId;

$response = $s3->copy_object('bucket', 'filename', array(
	'fishsticks1' => 'true',
	'fishsticks2' => 'false'
));

$more_code = $s3->get_object('bucket', 'filename.txt');
