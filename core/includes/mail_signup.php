<?php

// Para llamar con include

if(isset($email) && isset($name) && isset($surname)){
    if(PRUEBA == true){
        $att = "En este periodo de prueba tu cuenta ha sido activada automaticamente. Recuerda que tienes privilegios de administrador por lo que podrás ver en el panel lateral las herramientas respectivas. Siéntete con libertad de hacer todas las pruebas que consideres necesarias, la base de datos retornará a su estado inicial cada cierto tiempo.";
    }else{
        $att = "En breve tu cuenta será activada por algún administrador.";
    }
    $subject = NAME." - Gracias por Registrarse";
    $adminname = NAME;
    $adminemail = EMAIL;
    $host = PROJECT_HOST;

    $headers =<<<END
From: $adminname <$adminemail>
Reply-To: $adminemail
MIME-Version: 1.0
Content-Type: text/plain; charset='utf-8'

END;

    $body =<<<END
Hola {$name} {$surname},

Gracias por registrarse en $adminname.

$att

Recuerda que para acceder debes ir a http:{$host}login.php y acceder con tu dirección de correo electrónico y tu clave registrada.

Atentamente,
$adminname
http:$host
END;

    mail( $email, $subject, $body, $headers );
    //echo $email ."\n" .$subject ."\n" .$body ."\n" .$headers;
}else{
    echo 'No se han fijado los parámetros';
}
