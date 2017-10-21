<?php

require_once('AbstractRequest.php');

/**
 * Tax request class to fetch the request parameter for tax class.
 *
 * @author Faris Rayhan
 * @date 21/10/2017
 */
class TaxRequest extends AbstractRequest
{
    /**
     * Request parameter.
     *
     * @var array $param
     * @static
     */
    private static $param;

    /**
     * Constructor that will be loaded when there is newly object created
     *
     * @param array $param
     */
    public function __construct($param)
    {
        self::$param = $param;
    }

    /**
     * Get parameter.
     *
     */
    public function getParam()
    {
        return self::$param;
    }
}