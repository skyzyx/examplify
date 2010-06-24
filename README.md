# Examplify!

* **example** |igˈzampəl| (verb) be illustrated or exemplified : _the extent of Allied naval support is exampled by the navigational specialists provided._
* **exemplify** |igˈzempləˌfī| (verb) be a typical example of : _give an example of; illustrate by giving an example._
* **amplify** |ˈampləˌfī| (verb) enlarge upon or add detail to (a story or statement) : _the notes amplify information contained in the statement._


## What?

Provides a simple, comment-based syntax for editing working code samples for public consumption.

This is particularly useful when you use working unit tests for code samples, but not all parts of the unit test are appropriate for a code sample.

You can skip individual lines, blocks of lines, swap values within lines, and skip all lines containing certain patterns.


## How?

All Examplify! comments start with `/*#` (a fairly uncommon, but still perfectly valid comment pattern).

### Skip

`/*#skip*/` - Skip the entire line that this comment is on.

`/*#skip-start*/` - Skip the entire line that this comment is on (so that you can place it at the end of a line), and continue skipping until you reach `/*#skip-end*/`.

`/*#skip-end*/` - See above.

### Swap

`/*#swap:{"/pattern/ig" : "replacement"}*/` - Swap the PCRE pattern with the replacement in a given line. After `swap:`, you should have a valid, single-level JSON object.

`/*#swap-start:{"/pattern/ig" : "replacement"}*/` - Swap the PCRE pattern with the replacement in a given line, and continue swapping until you reach `/*#swap-end*/`. After `swap:`, you should have a valid, single-level JSON object.

`/*#swap-end*/` - See above.

### Block

`/*#block:["pattern1", "pattern2"]*/` - Blocks all lines containing the PCRE patterns in the entire document.


## License & Copyright

This code is Copyright (c) 2010, Ryan Parman. However, I'm licensing this code for others to use under the [MIT license](http://www.opensource.org/licenses/mit-license.php).
