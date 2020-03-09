<?php
declare(strict_types=1);
namespace Core\Driver;
use \Core\Driver\Interfaces\LogInterface;
use \Core\Framework\Tpl;
class Log implements LogInterface
{
    private static ?Log $instance = null;
    private static string $logLevel;
    private function __construct()
    {
        self::$logLevel = strtolower(config('log_level'));
        try {
            self::createLogFile();
        } catch(\Exception $e) {
            Tpl::showErrorTpl($e->getMessage());
        }
        
    }

    public static function getInstance()
    {
        if(!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function info(string $message, array $context = [])
    {
        if(self::$logLevel == 'info') self::writeLogIntoFile(self::createLogData($message, 'info'));
    }

    public function notice(string $message, array $context = [])
    {
        if(self::$logLevel == 'notice' || self::$logLevel == 'info') self::writeLogIntoFile(self::createLogData($message, 'notice'));
    }

    public function warning(string $message, array $context = [])
    {
        if(self::$logLevel == 'warning' || self::$logLevel == 'notice' || self::$logLevel == 'info') self::writeLogIntoFile(self::createLogData($message, 'warning'));
    }

    public function error(string $message, array $context = [])
    {
        self::writeLogIntoFile(self::createLogData($message, 'error'));
    }

    public function debug(string $message, array $context = [])
    {
        
    }

    private static function logFileName(): string
    {
        return APP_ROOT.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.date("Ymd",time()).'.log';
    }

    private static function logFileExist(string $fileName = ''): bool
    {
        $fileName = empty($fileName) ? date("Ymd",time()).'.log' : $fileName;
        if(file_exists(APP_ROOT.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.$fileName)) {
            return true;
        } else {
            return false;
        }
    }

    private static function createLogData(string $message, string $level) : string
    {
        $lineData = "\r\n[".date("Y-m-d H:i:s",time()).'] ['.$level.']'."\r\n";
        $lineData .= "[timeCost: ".round((microtime(true)-APP_STARTTIME),6).'s]'."\r\n";
        $lineData .= '[message]: '.$message."\r\n";
        return $lineData;
    }

    private static function writeLogIntoFile(string $message)
    {
        if(self::logFileExist()) {
            file_put_contents(self::logFileName(),$message, FILE_APPEND);
        } else {
            throw new \Exception('log file: '.self::logFileName().' not exist!');
        }
    }

    private static function createLogFile()
    {
        if(!is_dir(APP_ROOT.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'logs')) {
           @mkdir(APP_ROOT.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'logs');
        }
        if(!self::logFileExist()) {
            @fopen(self::logFileName(), "w") or Tpl::showWarningTpl('permission deny to write logFile: '.self::logFileName().'; please check permission of the directory: '.APP_ROOT.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'logs');
        } else {
            return true;
        }
    }

    private function __clone() {}
}