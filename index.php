<?php

require_once('TaxException.php');
require_once('TaxRequest.php');
require_once('Tax.php');


/**
 * Count PPH21
 *
 * @param int $income
 *
 * @return void
 */
function countPHP21($income)
{
    $taxRequestObject = new TaxRequest([
        'period' => 12,
        'income' => $income
    ]);
    $taxRequest = $taxRequestObject->getParam();
    $taxObject = new Tax($taxRequest);
    echo 'Your anual task is <strong>' . $taxObject->count() . '</strong> for income' . number_format($income);
}

# Just modify through this line
countPHP21(750000000);