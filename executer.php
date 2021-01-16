<?php

require_once('./research_supporter.php');

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


