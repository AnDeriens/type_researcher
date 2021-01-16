<?php

require_once('./executer.php');

class Reporter
{
    const NUM_START = 0;

    protected $executer;
    protected $values;
    protected $results;
    protected $num;
    protected $title;

    public function __construct()
    {
        $this->executer = new Executer; 
        $this->num = self::NUM_START;
    }

    protected function increment()
    {
        $this->num++; 
    }

    public function setTitle($v)
    {
        $this->title = $v;
    }

    public function addCase($method, $value)
    {
        $this->values[$this->num] = var_export($value, true);
        $this->results[$this->num] = $this->executer->execute($method, $value);
        $this->increment();
    }

    public function report()
    {
        echo "## $this->title\n";
        echo "| value | result |\n";
        echo "| --- | --- |\n";
        for ($i = self::NUM_START; $i < $this->num; $i++) {
            echo '| ' .  str_replace("\n", "", $this->values[$i]) . ' | ' . str_replace("\n", "", trim($this->results[$i])) . " |\n";
        }
        echo "\n\n";
    }
}

