<?php

echo "\n";
include __DIR__."/delete/deletesim.php";

echo "Borrando la simulación $param1\n\n";

deleteSim($param1.'_');
