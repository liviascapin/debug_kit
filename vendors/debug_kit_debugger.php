<?php
/* SVN FILE: $Id$ */
/**
 * 
 *
 * 
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link			http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package			cake
 * @subpackage		cake.cake.libs.
 * @since			CakePHP v 1.2.0.4487
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Debug Kit Temporary Debugger Class
 *
 * Provides the future features that are planned. Yet not implemented in the 1.2 code base
 *
 * This file will not be needed in future version of CakePHP.
 * @todo merge these changes with core Debugger
 */
class DebugKitDebugger extends Debugger {

/**
 * Start an benchmarking timer.
 * 
 * @param string $name The name of the timer to start.
 * @param string $message A message for your timer
 * @return bool true
 * @static
 **/
	function startTimer($name = 'default', $message = '') {
		$now = getMicrotime();
		$_this = DebugKitDebugger::getInstance();
		$_this->__benchmarks[$name] = array(
			'start' => $now,
			'message' => $message,
		);
		return true;
	}

/**
 * Stop a benchmarking timer.
 *
 * $name should be the same as the $name used in startTimer().
 *
 * @param string $name The name of the timer to end.
 * @access public
 * @return boolean true if timer was ended, false if timer was not started.
 * @static
 */
	function stopTimer($name = 'default') {
		$now = getMicrotime();
		$_this = DebugKitDebugger::getInstance();
		if (!isset($_this->__benchmarks[$name])) {
			return false;
		}
		$_this->__benchmarks[$name]['end'] = $now;
		return true;
	}

/**
 * Get all timers that have been started and stopped.
 * Calculates elapsed time for each timer.
 *
 * @return array
 **/
	function getTimers() {
		$_this =& DebugKitDebugger::getInstance();
		$times = array();
		foreach ($_this->__benchmarks as $name => $timer) {
			$times[$name]['time'] = DebugKitDebugger::elapsedTime($name);
			$times[$name]['message'] = $timer['message'];
		}
		return $times;
	}

/**
 * Clear all existing timers
 *
 * @return bool true
 **/
	function clearTimers() {
		$_this =& DebugKitDebugger::getInstance();
		$_this->__benchmarks = array();
		return true;
	}

/**
 * Get the difference in time between the timer start and timer end.
 *
 * @param $name string the name of the timer you want elapsed time for.
 * @param $precision int the number of decimal places to return, defaults to 5.
 * @return float number of seconds elapsed for timer name, 0 on missing key
 * @static
 **/
	function elapsedTime($name = 'default', $precision = 5) {
		$_this =& DebugKitDebugger::getInstance();
		if (!isset($_this->__benchmarks[$name]['start']) || !isset($_this->__benchmarks[$name]['end'])) {
			return 0;
		}
		return round($_this->__benchmarks[$name]['end'] - $_this->__benchmarks[$name]['start'], $precision);
	}

/**
 * Get the total execution time until this point
 *
 * @access public
 * @return float elapsed time in seconds since script start.
 * @static
 */
	function requestTime() {
		if (defined('TIME_START')) {
			$start = TIME_START;
		} else if (isset($_GLOBALS['TIME_START'])) {
			$start = $_GLOBALS['TIME_START'];
		} else {
			$start = env('REQUEST_TIME');
		}
		$now = getMicroTime();
		return ($start - $now);
	}

/**
 * get current memory usage
 *
 * @return integer number of bytes ram currently in use. 0 if memory_get_usage() is not available.
 * @static
 **/
	function getMemoryUse() {
		if (!function_exists('memory_get_usage')) {
			return 0;
		}
		return memory_get_usage();
	}

/**
 * Get peak memory use
 *
 * @return integer peak memory use (in bytes).  Returns 0 if memory_get_peak_usage() is not available
 * @static
 **/
	function getPeakMemoryUse() {
		if (!function_exists('memory_get_peak_usage')) {
			return 0;
		}
		return memory_get_peak_usage();
	}

}


Debugger::invoke(DebugKitDebugger::getInstance());

?>