<?php

echo "\n";
include __DIR__."/set/set{$param1}data.php";

echo "Cargando datos para $param2:\n\n";

call_user_func("setdata{$param2}table",
                isset($param3)? $param3 : null);
