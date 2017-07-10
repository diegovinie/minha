<?php
// Para llamar con include

if(isset($data)){
    extract($data);
}
if(isset($att) && isset($to) && isset($invoice) && isset($_SESSION)){
    $subject = NAME." - Recibo de cobro $invoice";
    $att = base64_encode( $att );
    $att = chunk_split( $att );
    $name = NAME;
    $email = EMAIL;
    $BOUNDARY=md5(microtime());

    $headers =<<<END
From: $name <$email>
Reply-To: $email
Content-Type: multipart/mixed; boundary=$BOUNDARY
END;

    $body =<<<END
--$BOUNDARY
Content-Type: text/plain

Hola {$_SESSION['name']} {$_SESSION['surname']},

se anexa el recibo de cobro $invoice .

--$BOUNDARY
Content-Type: application/pdf
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="recibo-{$invoice}.pdf"

$att
--$BOUNDARY--
END;

    mail( $to, $subject, $body, $headers );
    //echo $to ."\n" .$subject ."\n" .$headers;
}else{
    echo 'No se han fijado los parámetros';
}
