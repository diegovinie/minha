<?php
/* components/invoices/models/saveinvoicesbatch.php
 *
 * Modelo
 *
 */

defined('_EXE') or die('Acceso restringido');

include_once ROOTDIR.'/models/db.php';
include_once ROOTDIR.'/models/modelresponse.php';
include_once ROOTDIR.'/models/errors.php';

/**
 * Busca el archivo json del lote y actualiza
 * la base de datos.
 *
 * @return jsonResponse()
 */
function saveInvoicesBatch(/*int*/ $buiid, /*int*/ $number){
    $db = connectDb();
    $prx = $db->getPrx();
    $simid = $db->getSimId();
    $status = false;
    $error = false;


    $stmt = $db->query(
        "SELECT bui_edf
        FROM glo_buildings
        WHERE bui_id = $buiid"
    );

    $bui = $stmt->fetchColumn();

    // Recupera el archivo json con la información del lote.
    $fileInvoices = ROOTDIR."/files/{$prx}invoices/$bui/LOT-$number.json";

    if(!is_file($fileInvoices)){
        echo $fileInvoices;
        $msg = "No se encontró el lote $number.";
    }
    else{
        // Decodifica el lote como un array de objetos.
        $batch = json_decode(file_get_contents($fileInvoices));

        $lapse = $batch->{'head'}->{'Periodo'};
        $baTotal = $batch->{'head'}->{'Monto Total'};
        $email = $batch->{'head'}->{'Correo-e'};

        $stmt1 = $db->prepare(
            "SELECT lap_id AS 'id'
            FROM glo_lapses
            WHERE lap_name = :lapse"
        );
        $stmt1->bindValue('lapse', $lapse);
        $res1 = $stmt1->execute();

        if(!$res1){
            $msg = "Error al recuperar datos del periodo $lapse";
        }
        else{
            // Agrega a los gastos en cuestión el periodo.
            $lapid = (int)$stmt1->fetchColumn();

            $exe2 = $db->exec(
                "UPDATE {$prx}bills
                SET bil_lapse = $lapid
                WHERE bil_lapse IS NULL"
            );

            if(!$exe2){
                $msg = "No se pudo fijar el periodo a los gastos.";
            }
            else{
                // Actualizar la tabla funds.
                $stmt3 = $db->prepare(
                    "UPDATE {$prx}funds
                    SET fun_balance = fun_balance + CAST(:amount AS DECIMAL(10,2))
                    WHERE fun_name = :name
                        AND fun_bui_fk = :buiid
                        AND fun_sim_fk = :simid"
                );

                $stmt3->bindParam('amount', $funVal);
                $stmt3->bindParam('name', $funName);
                $stmt3->bindParam('buiid', $buiid, PDO::PARAM_INT);
                $stmt3->bindValue('simid', $simid, PDO::PARAM_INT);

                foreach ($batch->{'summary'} as $cat => $fund) {
                    // Descarta los gastos comunes.
                    if($cat == 'Fondos'){

                        foreach ($fund as $funName => $funVal) {

                            $exe3 = $stmt3->execute();

                            if(!$exe3){
                                $error = true;
                                echo "exe3: ".$stmt3->errorInfo()[2];
                                $msg = "Error al actualizar el $funName.";
                                break;
                            }
                        }
                    }
                }

                // Se actualiza el balance de cada apartamento
                // restandole el total.
                $charges = array();

                foreach ($batch->{'charges'} as $apt => $val) {
                    $charges[$apt] = $val->{'actual'};
                }

                $stmt4 = $db->prepare(
                    "UPDATE {$prx}apartments
                    SET apt_balance = apt_balance - CAST(:total AS DECIMAL(10,2))
                    WHERE apt_name = :apt
                        AND apt_bui_fk = :buiid
                        AND apt_sim_fk = :simid"
                );
                $stmt4->bindParam('total', $chAmount);
                $stmt4->bindParam('apt', $chApt);
                $stmt4->bindValue('buiid', $buiid, PDO::PARAM_INT);
                $stmt4->bindValue('simid', $simid, PDO::PARAM_INT);

                $stmt5 = $db->prepare(
                    "SELECT apt_id
                    FROM {$prx}apartments
                        INNER JOIN glo_buildings ON apt_bui_fk = bui_id
                        INNER JOIN glo_simulator ON apt_sim_fk = sim_id
                    WHERE apt_name = :apt"
                );
                $stmt5->bindParam('apt', $chApt);

                $stmt6 = $db->prepare(
                    "INSERT INTO {$prx}charges
                    (cha_apt_fk,      cha_lap_fk,
                     cha_amount,
                     cha_total,
                     cha_email,       cha_print,
                     cha_user)
                     VALUES
                    (:aptid,          :lapid,
                     CAST(:amount AS DECIMAL(10,2)),
                     CAST(:total AS DECIMAL(10,2)),
                     0,               0,
                     :userid)"
                );
                $stmt6->bindParam('aptid', $aptid, PDO::PARAM_INT);
                $stmt6->bindValue('lapid', $lapid, PDO::PARAM_INT);
                $stmt6->bindParam('amount', $chAmount);
                $stmt6->bindValue('total', $baTotal);
                $stmt6->bindValue('userid', $email);

                foreach ($charges as $chApt => $chAmount) {
                    $res4 = $stmt4->execute();

                    if(!$res4){
                        echo "res4: ".$stmt4->errorInfo()[2];
                        return false;
                    }

                    $res5 = $stmt5->execute();

                    if(!$res5){
                        echo "res5: ".$stmt5->errorInfo()[2];
                        return false;
                    }

                    $aptid = (int)$stmt5->fetchColumn();

                    $res6 = $stmt6->execute();

                    if(!$res6){
                        echo "res6: ".$stmt6->errorInfo()[2];
                        return false;
                    }
                }

                if(!$error){
                    // Si no hay ningún problema.
                    $status = true;
                    $msg = "Guardado con éxito.";
                }
            }
        }
    }

    return jsonResponse($status, $msg);
}
