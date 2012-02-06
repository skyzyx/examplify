# Examplify! Component

The purpose of writing tests should be two-fold: (a) To test the source code, and (b) to provide instruction for how to use the source code. Tests written from an instructionary point-of-view are a great way to both teach and test, but sometimes there are bits of code that are necessary for testing, but aren't necessary for instruction.

Examplify! makes it easy to re-use your tests as usage examples by enabling you to annotate lines with specialized comments for skipping or swapping.

* **example** |igˈzampəl| (verb) be illustrated or exemplified : _the extent of Allied naval support is exampled by the navigational specialists provided._
* **exemplify** |igˈzempləˌfī| (verb) be a typical example of : _give an example of; illustrate by giving an example._
* **amplify** |ˈampləˌfī| (verb) enlarge upon or add detail to (a story or statement) : _the notes amplify information contained in the statement._

And yes, the exclamation point is part of the name. :)


## Example

Using this [sample file](http://github.com/skyzyx/examplify/blob/master/_tests/sample.php) as your input:

	<?php
	use Skyzyx\Components\Examplify;

	$file = file_get_contents('sample.php');
	$example = new Examplify($file);
	echo $example->output();


This would display the following:

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


## Syntax
All Examplify! comments start with `/*#` (a fairly uncommon, but still perfectly valid comment pattern).

### Skip
* `/*#skip*/` - Skip the entire line that this comment is on.
* `/*#skip-start*/` - Skip the entire line that this comment is on (e.g., you can place it at the end of a line), and continue skipping all lines until `/*#skip-end*/` is reached.
* `/*#skip-end*/` - See above.

### Swap
* `/*#swap:{"string" : "replacement"}*/` - Swap the string with the replacement in a given line. After `swap:`, you should have a valid, single-level JSON object.
* `/*#swap-start:{"string" : "replacement"}*/` - Swap the string with the replacement in a given line, and continue swapping in all lines until `/*#swap-end*/` is reached. After `swap-start:`, you should have a valid, single-level JSON object.
* `/*#swap-end*/` - See above.

### Block
* `/*#block:["string1", "string2"]*/` - Blocks all lines containing the strings in the entire document.


## Installation
### Install source from GitHub
To install the source code:

	git clone git://github.com/skyzyx/examplify.git

And include it in your scripts:

	require_once '/path/to/examplify/src/Examplify.php';

### Install with Composer
If you're using [Composer](https://github.com/composer/composer) to manage dependencies, you can add Examplify with it.

	{
		"require": {
			"skyzyx/examplify": ">=1.1"
		}
	}

### Using a Class Loader
If you're using a class loader (e.g., [Symfony Class Loader](https://github.com/symfony/ClassLoader)):

	$loader->registerNamespace('Skyzyx\\Components\\Examplify', 'path/to/vendor/examplify/src');


## Tests
Tests are written in [PHPT](http://qa.php.net/phpt_details.php) format. You can run them with either the PEAR Test Runner or with PHPUnit 3.6+.

	cd tests/
	pear run-tests .

...or...

	cd tests/
	phpunit .


## License & Copyright
Copyright (c) 2010-2012 [Ryan Parman](http://ryanparman.com). Licensed for use under the terms of the [MIT license](http://www.opensource.org/licenses/mit-license.php).
