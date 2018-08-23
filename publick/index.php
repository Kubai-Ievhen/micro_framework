<?php

function my_autoload ($pClassName) {
    $pClassName = str_replace("\\","/", $pClassName);
    $dir = str_replace("publick","", __DIR__);

    include ($dir . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

\vendor\StarterClass::init();