<?php

/**
 * Tax class.
 *
 * @author Faris Rayhan
 * @date 21/10/2017
 */

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

        $topRangeFilter = [];
        foreach (self::$rules as $key => $value) {
            # Make an array of the rules string to get the base and top range.
            $rangeArray = explode('-', $key);
            # Base range such 0
            $baseRange = $rangeArray[0];
            # Top range such 50000000
            $topRange = $rangeArray[1];
            if ($this->request['income'] >= $baseRange) {
                $topRangeFilter[$key] = $topRange;
            }
        }

        # Modify the last top range from an array to be actual income we receive.
        end($topRangeFilter);
        $key = key($topRangeFilter);
        $topRangeFilter[$key] = (string)$this->request['income'];
        reset($topRangeFilter);

        # Loop through tax rule.
        foreach (self::$rules as $key => $value) {
            # Make an array of the rules string to get the base and top range.
            $rangeArray = explode('-', $key);
            # Base range such 0
            $baseRange = $rangeArray[0];
            # Range difference
            $rangeDifference = 0;
            if (array_key_exists($key, $topRangeFilter) === true) {
                $rangeDifference = $topRangeFilter[$key] - $baseRange;
            }
            if ($this->request['income'] >= $baseRange) {
                $tax[] = [$value => $rangeDifference];
            }
        }

        $taxCounter = count($tax);
        # Count real tax.
        for ($i = 0; $i < $taxCounter; $i++) {
            foreach ($tax[$i] as $key => $value) {
                $finalTaxAmount += ($key * $value) / 100;
            }
        }
        return number_format($finalTaxAmount);
    }
}