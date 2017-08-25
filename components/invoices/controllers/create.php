<?php

include ROOTDIR.'/models/locale.php';
//include ROOTDIR.'/models/validations.php';

$userid = (int)$_SESSION['user_id'];
$bui = $_SESSION['bui'];
$lapse = (int)$_POST['lapse'];
$bills = array();
$funds = array();

foreach ($_POST as $key => $value) {
    if(preg_match("/^chk/", $key) && $value == 1){
        list($prep, $id) = split('_', $key);
        $bills[] = (int)$id;
    }

    if(preg_match("/^fundt/", $key)){
        list($prep, $id) = split('_', $key);
        $funds[$id]['type'] = (int)$value;
    }

    if(preg_match("/^fundv/", $key)){
        list($prep, $id) = split('_', $key);
        $funds[$id]['val'] = numToEng($value);
    }
}

include $basedir.'models/invoices.php';

//var_dump(getBillsInfo($bills)) ;
//var_dump(getLapseInfo($lapse));
//var_dump(json_decode(setBillsQueue($bills)));
//var_dump(getAssignedApts($bui));
//var_dump(json_decode(getNumberApts($bui)));
//var_dump(json_decode(getBalanceFromBuildings($bui)));
//var_dump(getFractionBuilding('Country_Park'));
//var_dump(getFundsInfo($funds));

$jsInvoice = generateInvoicesBatch( $userid, $bui, $lapse, $bills, $funds);

?><script type="text/javascript">
    invoice = <?php echo $jsInvoice ?>;
</script>
