<?php
ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);
ini_set('error_reporting', E_ALL);
define("E_FATAL", 16384 * 2);
set_error_handler(function($errno, $errstr, $errfile, $errline){
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('./research_supporter.php');
require_once('./reporter.php');
require_once('./executer.php');

class FatalErrorException extends \Exception
{
    public function __construct(string $message = "" , int $code = 0 , Throwable $previous = null)
    {
        if ($message === "") {
            $message = "fatal error exception";
        }
        if ($code === 0) {
            $code = 1024;
        }
        
        parent::__construct($message, $code, $previous);
    }
}

class Cast
{
    public static function int($v)
    {
        return (int)$v;    
    }

    public static function string($v)
    {
        if ($v instanceof stdClass) {
//            throw new FatalErrorException("Object of class stdClass could not be converted to string"); 
            return "[Fatal Error]Object of class stdClass could not be converted to string"; 
        }

        if (is_object($v)) {
            return "[Fatal Error]Object of class Closure could not be converted to string ";
        }
        return (string)$v; 
    }

    public static function boolean($v)
    {
        return (boolean)$v;
    }

    public static function float($v)
    {
        return (float)$v;
    }

    public static function array($v)
    {
        return (array)$v; 
    }

    public static function object($v)
    {
        return (object)$v; 
    }
}

// $casts = array_intersect(get_class_methods(Cast::class), ['object']);
$casts = get_class_methods(Cast::class);


function execute_test($cast)
{
    $reporter = new Reporter();
    $reporter->setTitle($cast);

    $reporter->addCase("Cast::$cast", NULL);
    $reporter->addCase("Cast::$cast", 0);
    $reporter->addCase("Cast::$cast", 1);
    $reporter->addCase("Cast::$cast", '');
    $reporter->addCase("Cast::$cast", '0');
    $reporter->addCase("Cast::$cast", '1');
    $reporter->addCase("Cast::$cast", 'a');
    $reporter->addCase("Cast::$cast", true);
    $reporter->addCase("Cast::$cast", false);
    $reporter->addCase("Cast::$cast", 0.1);
    $reporter->addCase("Cast::$cast", []);
    $reporter->addCase("Cast::$cast", ['a']);
    $reporter->addCase("Cast::$cast", ['a', 'b']);
    $reporter->addCase("Cast::$cast", [1, 2]);
    $reporter->addCase("Cast::$cast", new stdClass());
    $object = new stdClass();
    $object->a = "a";
    $reporter->addCase("Cast::$cast", $object);
    $reporter->addCase("Cast::$cast", function () {return true;});
    $reporter->report();
}

foreach ($casts as $cast) {
    execute_test($cast);    
}

