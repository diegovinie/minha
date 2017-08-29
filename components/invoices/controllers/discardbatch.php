<?php

include $basedir.'models/invoices.php';

$j = discardInvoicesBatch('A17', 201707);

?><script type="text/javascript">
    res = <?php echo $j ?>;
</script>
