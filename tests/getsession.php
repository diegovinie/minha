<?php

if(isset($_SESSION)){

    $name = $_SESSION['name'];
    $name = split(' ', $name)[0];
    $name = strtolower($name);

    $d = new DateTime();
    $date = $d->format('Y/m/d-H:i:s');
    $file = ROOTDIR."/tests/sessions/$name.php";

    if(!is_file($file)){
        $handler = fopen($file, 'a');
        fwrite($handler, '<?php'."\n");
        fwrite($handler, '// Session recorded '.$date."\n");

        foreach ($_SESSION as $key => $value) {
            $t = gettype($value);
            $stmt = '$_SESSION'."['$key'] = ($t)'$value';\n";
            fwrite($handler, $stmt);
        }
        fclose($handler);
    }

}
