<?php

if(isset($_POST)){

    $d = new DateTime();
    $date = $d->format('Ymd-Hi');
    $name = "post-$date";
    $file = ROOTDIR."/tests/posts/$name.php";

    if(!is_file($file)){
        $handler = fopen($file, 'a');
        fwrite($handler, '<?php'."\n");
        fwrite($handler, '// POST Array captured '.$date."\n");

        foreach ($_POST as $key => $value) {
            $t = gettype($value);
            $stmt = '$_POST'."['$key'] = ($t)'$value';\n";
            fwrite($handler, $stmt);
        }
        fclose($handler);
    }
}
