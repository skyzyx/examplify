<?php
require_once 'something.class.php';
require_once 'something_else.class.php';
require_once 'something_third.class.php';

// Instantiate object
$s3 = new AmazonS3();

$version_id = (string) $s3->get_object('bucket', 'filename', array(
	'versionId' => 'abc123', /*#swap:{"\\d{3}": "999"}*/
	'secret_code' => '123456' /*#skip*/
))->body->Versions->VersionId;

$version_id = (string) $s3->get_object('bucket', 'filename', array(
	'versionId' => 'abc123',
	'secret_code' => '123456'
))->body->Versions->VersionId;

$response = $s3->copy_object('bucket', 'filename', array( /*#swap-start:{"condition": "fishsticks"}*/
	'condition1' => 'true',
	'condition2' => 'false'
)); /*#swap-end*/

################################################################## /*#skip-start*/

// Comments and stuff
$extra_processing = 'This isn\'t supposed to be part of the example';

################################################################## /*#skip-end*/

Test::logger(__FILE__, $response); /*#skip*/

$more_code = $s3->get_object('bucket', 'filename123.txt'); /*#swap:{"filename\\d{3}": "filename", "txt": "ext"}*/

/*#block:["require_once"]*/
?>
