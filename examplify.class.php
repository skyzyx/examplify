<?php
/**
 * File: Examplify!
 * 	Provides a simple, comment-based syntax for editing working code samples for public consumption.
 *
 * Version:
 * 	2010.06.23
 *
 * Copyright:
 * 	2010 Ryan Parman
 *
 * License:
 * 	MIT License - http://www.opensource.org/licenses/mit-license.php
 */


/*%******************************************************************************************%*/
// CLASS

class Examplify
{
	/**
	 * Property: content
	 * 	Contains the current state of the content that we're processing.
	 */
	public $content;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	Examplify $this
	 */
	public function __construct($content)
	{
		$this->content = $content;
		$this->_apply_edits();
		return $this;
	}

	/**
	 * Method: output()
	 * 	Returns the post-processed string.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_string_ The post-processed string.
	 */
	public function output()
	{
		return $this->content;
	}


	/*%******************************************************************************************%*/
	// PROCESSING

	/**
	 * Method: _apply_edits()
	 * 	Applies the processes to the content.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _apply_edits()
	{
		$this->_apply_block();
		$this->_apply_skip();
		$this->_apply_skip_block();
		$this->_apply_swap();
		$this->_apply_swap_block();
		$this->_cleanup();
	}

	/**
	 * Method: _apply_block()
	 * 	Handles the /*#block:[] rules.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _apply_block()
	{
		preg_match_all("/\/\*#block:(.*)\*\//U", $this->content, $matches);
		$blocks = json_decode($matches[1][0], true);

		foreach ($blocks as $block)
		{
			while (preg_match("/\n(.*)" . $block . "(.*)\n/", $this->content))
			{
				$this->content = preg_replace("/\n(.*)" . $block . "(.*)\n/U", "\n", $this->content);
			}
		}
	}

	/**
	 * Method: _apply_skip()
	 * 	Handles the /*#skip rules.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _apply_skip()
	{
		while (preg_match("/\n(.*)\/\*#skip\*\/(.*)\n/U", $this->content))
		{
			$this->content = preg_replace("/\n(.*)\/\*#skip\*\/(.*)\n/U", "\n", $this->content);
		}
	}

	/**
	 * Method: _apply_skip_block()
	 * 	Handles the /*#skip-start ... /*#skip-end rules.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _apply_skip_block()
	{
		while (preg_match("/\n(.*)\/\*#skip-start\*\/(.|\n)*\/\*#skip-end\*\/\n/Um", $this->content))
		{
			$this->content = preg_replace("/\n(.*)\/\*#skip-start\*\/(.|\n)*\/\*#skip-end\*\/\n/Um", "\n", $this->content);
		}
	}

	/**
	 * Method: _apply_swap()
	 * 	Handles the /*#swap rules.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _apply_swap()
	{

	}

	/**
	 * Method: _apply_skip_block()
	 * 	Handles the /*#swap-start:{} ... /*#swap-end rules.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _apply_swap_block()
	{

	}

	/**
	 * Method: _cleanup()
	 * 	Handles the final cleanup after the rules have been applied.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	void
	 */
	private function _cleanup()
	{
		while (strpos($this->content, "\n\n\n") !== false)
		{
			$this->content = str_replace("\n\n\n", "\n\n", $this->content);
		}
	}
}
