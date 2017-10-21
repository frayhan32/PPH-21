<?php

require_once('TaxException.php');
require_once('TaxRequest.php');

/**
 * Tax class to count the tax based income anually.
 *
 * @author Faris Rayhan
 * @date 21/10/2017
 */
class Tax
{

    /**
     * Valid period tax.
     *
     * @var array $validPeriodTax
     * @static
     */
    private static $validPeriodTax = [
        12
    ];

    /**
     * A set of rules for tax.
     *
     * @var array $rules
     * @static
     */
    private static $rules = [];

    /**
     * Variable to hold request object.
     *
     * @var array $rules
     */
    private $request = [];

    /**
     * Constructor that will be loaded when there is newly object created
     *
     * @param array $taxRequest
     * @throws TaxException
     */
    public function __construct($taxRequest)
    {

        # Assign request to local property.
        $this->request = $taxRequest;
        # End the execution if period not valid.
        if (in_array($this->request['period'], self::$validPeriodTax) === false) {
            throw new TaxException('Period not valid', 6);
        }
        # Hard code the rules.
        self::$rules = [
            '0-50000000'                              => '5',
            '50000000-250000000'                      => '15',
            '250000000-500000000'                     => '25',
            '500000000-' . ($this->request['income']) => '30'
        ];
    }

    /**
     * Count the tax
     *
     * @return int
     */
    public function count()
    {
        # Get all range of tax percent
        $tax = [];
        # Final tax amount.
        $finalTaxAmount = 0;
        # Loop through tax rule.
        foreach (self::$rules as $key => $value) {
            # Make an array of the rules string to get the base and top range.
            $rangeArray = explode('-', $key);
            # Base range such 0
            $baseRange = $rangeArray[0];
            # Top range such 50000000
            $topRange = $rangeArray[1];
            # Range difference
            $rangeDifference = $topRange - $baseRange;
            if ($this->request['income'] >= $baseRange) {
                $tax[] = [$value => $rangeDifference];
            }
        }
        # Modify the last value from associative array.
        $taxCounter = count($tax) - 1;
        $valueExcludeIncome = 0;
        for ($i = 0; $i < $taxCounter; $i++) {
            foreach ($tax[$i] as $key => $value) {
                $valueExcludeIncome += $value;
            }
        }
        # Count real tax.
        for ($i = 0; $i < $taxCounter; $i++) {
            foreach ($tax[$i] as $key => $value) {
                if (($i + 1) === $taxCounter) {
                    $tax[$i] = [$value => $this->request['income'] - $valueExcludeIncome];
                }
                $finalTaxAmount += ($key * $value) / 100;
            }
        }
        return number_format($finalTaxAmount);
    }
}

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
countPHP21(75000000);