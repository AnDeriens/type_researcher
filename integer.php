<?php

function to_int($v)
{
    return (int)$v;
}

var_dump(to_int(NULL));
var_dump(to_int(0));
var_dump(to_int(1));
var_dump(to_int(''));
var_dump(to_int('0'));
var_dump(to_int('1'));
var_dump(to_int('a'));
var_dump(to_int(true));
var_dump(to_int(false));
var_dump(to_int(0.1));
var_dump(to_int([]));
var_dump(to_int(['a']));
var_dump(to_int(['a', 'b']));
var_dump(to_int([1, 2]));
var_dump(to_int(new stdClass()));
var_dump(to_int(new stdClass(['a' => 'a'])));
var_dump(to_int(function () {return true;}));
