<?php
/* components/invoices/models/sendinvoices.php
 *
 * Modelo
 *
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';
include_once $basedir.'models/datainvoice.php';

function getAptsByBui(/*int*/ $buiid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT apt_id AS 'id',
            apt_name AS 'name'
        FROM {$prx}apartments
        WHERE apt_sim_fk = :simid
            AND apt_bui_fk = :buiid
            AND apt_assigned = 1"
    );

    $stmt->bindValue('simid', $simid, PDO::PARAM_INT);
    $stmt->bindValue('buiid', $buiid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        echo "getAptsByBui: ".$stmt->errorInfo()[2];
        return false;
    }

    $apts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $apts;
}

function getHabitantsDataByApt(/*int*/ $aptid){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();

    $stmt = $db->prepare(
        "SELECT hab_id AS 'id',
            hab_name AS 'name',
            hab_surname AS 'surname',
            hab_email AS 'email'
        FROM {$prx}habitants
        WHERE hab_apt_fk = :aptid"
    );
    $stmt->bindValue('aptid', $aptid, PDO::PARAM_INT);

    $res = $stmt->execute();

    if(!$res){
        echo "getHabitantsDataByApt: " .$stmt->errorInfo()[2];
        return false;
    }

    $habs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $habs;
}

function sendEmailsToHabitants(/*int*/ $number, /*int*/ $buiid){

    $res = array();
    $status = false;

    $apts = getAptsByBui($buiid);

    if(!$apts) return false;

    foreach ($apts as $apt) {

        $invoice = createInvoice($apt['id'], $number);

        $habs = getHabitantsDataByApt($apt['id']);

        foreach ($habs as $hab) {

            if(!$hab) continue;

            $res[] = sendEmail($hab, $number, $invoice);
            //$res[] = print("{$apt['name']}, {$hab['email']}, $number, hola"); echo "\n";
        }
    }

    $err = count($res) - array_sum($res);

    if($err){

        $msg = "Se encontraros $err errores.";
    }
    else{
        $msg = "Todos los correos enviados con éxito.";
        $status = true;
    }

    return jsonResponse($status, $msg);
}

function sendEmail(/*array*/ $hab, /*int*/ $number, /*base64*/ $invoice){

    $subject = NAME." - Recibo de cobro $number";
    $invoice = base64_encode($invoice);
    $invoice = chunk_split($invoice);
    $invoice = '';
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

Hola {$hab['name']} {$hab['surname']},

se anexa el recibo de cobro $number .

--$BOUNDARY
Content-Type: application/pdf
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="recibo-{$number}.pdf"

$invoice
--$BOUNDARY--
END;

    //return mail($hab['mail'], $subject, $body, $headers);
    //print("{$hab['email']}, $subject, $body, $headers"); echo "\n\n";
    return true;
}
