<?php
ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);
ini_set('error_reporting', E_ALL);
set_error_handler(function($errno, $errstr, $errfile, $errline){
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('./research_supporter.php');

class Cast
{
    public static function int($v)
    {
        return (int)$v;    
    }
}

class Executer
{
    protected $exception_handler;

    public function __construct()
    {
        $this->exception_handler = new ExceptionHandler(); 
    }

    public function execute($func, $value): string
    {
        return $this->handle_function_error($func, $value);
    }

    protected function handle_function_error(string $func, $value): string
    {
        ob_start();
        try {
            $r = call_user_func($func, $value);
            var_dump($r);
        } catch (\Exception $e) {
            echo $this->exception_handler->handle($e);
        }
        return ob_get_clean();
    }
}

class Reporter
{
    const NUM_START = 0;

    protected $executer;
    protected $values;
    protected $results;
    protected $num;

    public function __construct()
    {
        $this->executer = new Executer; 
        $this->num = self::NUM_START;
    }

    protected function increment()
    {
        $this->num++; 
    }

    public function addCase($method, $value)
    {
        $this->values[$this->num] = var_export($value, true);
        $this->results[$this->num] = $this->executer->execute($method, $value);
        $this->increment();
    }

    public function report()
    {
        echo "| value | result |\n";
        echo "| --- | --- |\n";
        for ($i = self::NUM_START; $i < $this->num; $i++) {
            echo '| ' .  str_replace("\n", "", $this->values[$i]) . ' | ' . trim($this->results[$i]) . " |\n";
        }
    }
}

$reporter = new Reporter();

$reporter->addCase("Cast::int", NULL);
$reporter->addCase("Cast::int", 0);
$reporter->addCase("Cast::int", 1);
$reporter->addCase("Cast::int", '');
$reporter->addCase("Cast::int", '0');
$reporter->addCase("Cast::int", '1');
$reporter->addCase("Cast::int", 'a');
$reporter->addCase("Cast::int", true);
$reporter->addCase("Cast::int", false);
$reporter->addCase("Cast::int", 0.1);
$reporter->addCase("Cast::int", []);
$reporter->addCase("Cast::int", ['a']);
$reporter->addCase("Cast::int", ['a', 'b']);
$reporter->addCase("Cast::int", [1, 2]);
$reporter->addCase("Cast::int", new stdClass());
$reporter->addCase("Cast::int", new stdClass(['a' => 'a']));
$reporter->addCase("Cast::int", function () {return true;});

$reporter->report();

