<?php

class ExceptionHandler
{
    public function handle(\Exception $e)
    {
        if ($e instanceof ErrorException) {
            switch ($e->getSeverity()) {
                case  E_ERROR:
                    $result = "E_ERROR";
                    break;
                case  E_WARNING:
                    $result = "E_WARNING";
                    break;
                case  E_PARSE:
                    $result = "E_PARSE";
                    break;
                case  E_NOTICE:
                    $result = "E_NOTICE";
                    break;
                case  E_CORE_ERROR:
                    $result = "E_CORE_ERROR";
                    break;
                case  E_CORE_WARNING:
                    $result = "E_CORE_WARNING";
                    break;
                case  E_COMPILE_ERROR:
                    $result = "E_COMPILE_ERROR";
                    break;
                case  E_COMPILE_WARNING:
                    $result = "E_COMPILE_WARNING";
                    break;
                case  E_USER_ERROR:
                    $result = "E_USER_ERROR";
                    break;
                case  E_USER_WARNING:
                    $result = "E_USER_WARNING";
                    break;
                case  E_USER_NOTICE:
                    $result = "E_USER_NOTICE";
                    break;
                case  E_STRICT:
                    $result = "E_STRICT";
                    break;
                case  E_RECOVERABLE_ERROR:
                    $result = "E_RECOVERABLE_ERROR";
                    break;
                case  E_DEPRECATED:
                    $result = "E_DEPRECATED";
                    break;
                case  E_USER_DEPRECATED:
                    $result = "E_USER_DEPRECATED";
                    break;
                default:
                    $result = "E_UNKNOWN";
                    break;
            }
        } else {
            exit('Uncaught Error. ' . $e->getMessage());
        }

        return $result;
    }
}


