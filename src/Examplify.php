<?php
/**
 * Copyright (c) 2010-2012 [Ryan Parman](http://ryanparman.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * <http://www.opensource.org/licenses/mit-license.php>
 */


namespace Skyzyx\Components
{
	/**
	 * Examplify! makes it easy to re-use your tests as usage examples by enabling you to annotate
	 * lines with specialized comments for skipping or swapping.
	 *
	 * @version 2012.02.05
	 * @author Ryan Parman <http://ryanparman.com>
	 */
	class Examplify
	{
		/**
		 * Stores the text of the test file.
		 */
		private $text;


		/*%******************************************************************************************%*/
		// CONSTRUCTOR

		/**
		 * Constructs a new instance of <Skyzyx\Components\Examplify>.
		 *
		 * @param string $text (Required) The text of the PHPT file.
		 * @return void
		 */
		public function __construct($text)
		{
			$this->text = $text;
			$this->_apply_edits();
		}

		/**
		 * Returns the post-processed string.
		 *
		 * @return string The post-processed string.
		 */
		public function output()
		{
			return $this->text;
		}


		/*%******************************************************************************************%*/
		// PROCESSING

		/**
		 * Applies the processes to the content.
		 *
		 * @return void
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
		 * Handles the `/*#block:[]` rules.
		 *
		 * @return void
		 */
		private function _apply_block()
		{
			preg_match_all("/\/\*#block:(.*)\*\//U", $this->text, $matches);
			$blocks = @json_decode($matches[1][0], true);

			if (count($blocks))
			{
				foreach ($blocks as $block)
				{
					while (preg_match("/\n(.*)" . $block . "(.*)\n/", $this->text))
					{
						$this->text = preg_replace("/\n(.*)" . $block . "(.*)\n/U", "\n", $this->text);
					}
				}
			}
		}

		/**
		 * Handles the `/*#skip` rules.
		 *
		 * @return void
		 */
		private function _apply_skip()
		{
			while (preg_match("/\/\*#skip\*\//U", $this->text))
			{
				$this->text = preg_replace("/\n(.*)\/\*#skip\*\/(.*)\n/U", "\n", $this->text);
			}
		}

		/**
		 * Handles the `/*#skip-start` ... `/*#skip-end` rules.
		 *
		 * @return void
		 */
		private function _apply_skip_block()
		{
			while (preg_match("/\/\*#skip-start\*\/(.|\n)*\/\*#skip-end\*\//Um", $this->text))
			{
				$this->text = preg_replace("/\n(.*)\/\*#skip-start\*\/(.|\n)*\/\*#skip-end\*\/\n/Um", "\n", $this->text);
			}
		}

		/**
		 * Handles the `/*#swap` rules.
		 *
		 * @return void
		 */
		private function _apply_swap()
		{
			preg_match_all("/\n(.*)\/\*#swap:(.*)\*\/(.*)/U", $this->text, $matches);

			if (count($matches[0]))
			{
				for ($i = 0, $max = count($matches[0]); $i < $max; $i++)
				{
					$replace = $matches[0][$i];
					$line = $matches[1][$i];
					$swaps = json_decode($matches[2][$i], true);

					foreach ($swaps as $pattern => $replacement)
					{
						$line = preg_replace('/' . $pattern . '/i', $replacement, $line);
						$line = rtrim($line);
					}

					$this->text = str_replace($replace, "\n" . $line, $this->text);
				}
			}
		}

		/**
		 * Handles the `/*#swap-start:{}` ... `/*#swap-end` rules.
		 *
		 * @return void
		 */
		private function _apply_swap_block()
		{
			preg_match_all("/\n(.*)\/\*#swap-start:(.*)\*\/(.|\n)*\/\*#swap-end\*\/(.*)\n/U", $this->text, $matches);

			if (count($matches[0]))
			{
				for ($i = 0, $max = count($matches[0]); $i < $max; $i++)
				{
					$block = $matches[0][$i];
					$block = preg_replace("/\/\*#swap-start:(.*)\*\//", '', $block);
					$block = preg_replace("/\/\*#swap-end\*\//", '', $block);

					$replace = $matches[0][$i];
					$swaps = json_decode($matches[2][$i], true);

					foreach ($swaps as $pattern => $replacement)
					{
						$block = preg_replace('/' . $pattern . '/i', $replacement, $block);

						// Strip right-hand whitespace
						$blocks = explode("\n", $block);
						$cblock = array();
						foreach ($blocks as $block) { $cblock[] = rtrim($block); }
						$block = implode("\n", $cblock);
					}

					$this->text = str_replace($replace, "\n" . $block . "\n", $this->text);
				}
			}
		}

		/**
		 * Handles the final cleanup after the rules have been applied.
		 *
		 * @return void
		 */
		private function _cleanup()
		{
			while (strpos($this->text, "\n\n\n") !== false)
			{
				$this->text = str_replace("\n\n\n", "\n\n", $this->text);
			}
		}
	}
}
