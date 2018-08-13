<?php
/**
 * Class for creating basic web application logs.
 *
 * @license	GNU General Public License
 */
require_once('constant.php');

class Logging
{
	/**
	 * Path to the file.
	 *
	 * @var string
	 */
	protected $logFilePath= LOG_FILE_PATH;
	 
	/**
	 *  For log priority
	 *
	 * @var string
	 */
	protected $logFile;
	 
	/**
	 *  For log priority
	 *
	 * @var string
	 */
	protected $logMaxLevel= LOG_MAX_LEVEL;
	protected $logMinLevel= LOG_MIN_LEVEL;
	protected $logLevel= LOG_LEVEL;
	protected $logEmerg = "Emergency Action Required";
	protected $logAlert = "Alerts";
	protected $logErr = "Errors";
	protected $logWarning = "Warmings";
	protected $logInfo = "Information";


	/**
	 * Log file resource.
	 *
	 * @var resource
	 */
	protected $logFileHandler;

	/**
	 * Date format that'll be used in log file.
	 *
	 * @var string
	 */
	protected $dateFormat;

	/**
	 * Time format that'll be used in log file.
	 *
	 * @var string
	 */
	protected $timeFormat;

	/**
	 * Constructor
	 *
	 * @param string Path to file which will be used as a log file.
	 * @param string Date format in log file.
	 * @param string Time format in log file.
	 */
	public function __construct($dateFormat = 'd.m.Y', $timeFormat = 'H:i:e'){

		if (!is_string($dateFormat) || !preg_match('/^[djmnYy][\.\-][djmnYy][\.\-][djmnYy]\.?$/', $dateFormat)) {
			throw new Exception('Logging Exception: Invalid date format. Only \'.\' and \'-\' are allowed as date separators.');
		}
		elseif (!is_string($timeFormat)) {
			throw new Exception('Logging Exception: Invalid time format.');
		}
		$this->logFile = $this->logFilePath."/"."Log_".date($dateFormat).".txt";
		$this->dateFormat = $dateFormat;
		$this->timeFormat = $timeFormat;
	}

	/**
	 * Main function which process user request by getting log
	 * logRecord and priority, and forwarding those data to
	 * preparation and formating. After that, generated text will
	 * be written in the log file.
	 *
	 * @param string logRecord that'll be logged.
	 * @param int Priority level (emergency, alert, error, warning, info).
	 * @return void
	 */
	public function log($logInFile,$logInLine, $logRecord, $logLevel){
		if (!($this->logLevelText($logLevel))) {
			throw new Exception('Logging Exception: That log logLevel doesn\'t exists.');
		} else{
			$logTestl=$this->logLevelText($logLevel);
			if($logTestl!="no"){
				$logText = $this->prepareText($logInFile,$logInLine, $logRecord, $logTestl);
				$this->writeLog($logText);
			}
		}
	}

	/**
	 * Test the log level and deside weather print the log or not
	 *
	 */
	protected function logLevelText($logLevel){
		if ($logLevel <= $this->logMaxLevel && $logLevel >= $this->logMinLevel){
			$logTextLevel = array($this->logEmerg,$this->logAlert, $this->logErr, $this->logWarning, $this->logInfo);
			if($logLevel <= $this->logLevel){
				return $logTextLevel[$logLevel];
			} else{ return "no"; }
		} else{
			return false;
		}
	}

	/**
	 * Function that does the preparation and formating of the text
	 * that will be written in the log file.
	 *
	 * @param string logRecord that'll be logged.
	 * @param int logLevel level (emergency, alert, error, warning, info).
	 * @return string
	 */

	protected function prepareText($logInFile,$logInLine, $logRecord, $logLevel){
		$text = ''; //Text that will be written in log file.
		//date_default_timezone_set('Asia/Calcutta');
		date_default_timezone_set('America/New_York');
		$logDate = date($this->dateFormat); //Generating current date.
		$logTime = date($this->timeFormat); //Generating current time.
		$dateTime=$logDate.":".$logTime;
		$logRecord = sprintf ("%s|%-20s|%-4s|%s|%s", $dateTime, 'In File->: '.$logInFile, 'In Line-> '.$logInLine, 'Log Type->'. $logLevel, $logRecord);

		return $logRecord;
	}

	/**
	 * Function for doing the actual writing of contents to the
	 * log file.
	 *
	 * @param string Text that will be appended.
	 * @return void
	 * @access protected
	 */
	protected function writeLog($logText)	{
		if(!error_log ("$logText\n",  3, $this->logFile)){
			throw new Exception("Logging Exception: Unable to write to log file.");
		}

	}
}
?>