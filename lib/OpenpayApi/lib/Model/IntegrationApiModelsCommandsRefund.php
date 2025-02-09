<?php
/**
 * IntegrationApiModelsCommandsRefund
 *
 * PHP version 5
 *
 * @category Class
 * @package  Openpay\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Integration API
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: v1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.22
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Openpay\Client\Model;

use \ArrayAccess;
use \Openpay\Client\ObjectSerializer;

/**
 * IntegrationApiModelsCommandsRefund Class Doc Comment
 *
 * @category Class
 * @package  Openpay\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class IntegrationApiModelsCommandsRefund implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'IntegrationApi.Models.Commands.Refund';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'new_purchase_price' => 'int',
'reduce_price_by' => 'int',
'full_refund' => 'bool'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'new_purchase_price' => 'int32',
'reduce_price_by' => 'int32',
'full_refund' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'new_purchase_price' => 'newPurchasePrice',
'reduce_price_by' => 'reducePriceBy',
'full_refund' => 'fullRefund'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'new_purchase_price' => 'setNewPurchasePrice',
'reduce_price_by' => 'setReducePriceBy',
'full_refund' => 'setFullRefund'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'new_purchase_price' => 'getNewPurchasePrice',
'reduce_price_by' => 'getReducePriceBy',
'full_refund' => 'getFullRefund'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['new_purchase_price'] = isset($data['new_purchase_price']) ? $data['new_purchase_price'] : null;
        $this->container['reduce_price_by'] = isset($data['reduce_price_by']) ? $data['reduce_price_by'] : null;
        $this->container['full_refund'] = isset($data['full_refund']) ? $data['full_refund'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets new_purchase_price
     *
     * @return int
     */
    public function getNewPurchasePrice()
    {
        return $this->container['new_purchase_price'];
    }

    /**
     * Sets new_purchase_price
     *
     * @param int $new_purchase_price An integer number in the lowest denomination in the currency being used (e.g. supply 1034 to indicate $10.34)  Must be zero, or greater than zero and less than the current purchase price for the order ID concerned.  Either NewPurchasePrice OR ReducePriceBy must be supplied.    In the event that both are greater than zero, they both must be accurate (i.e. New Purchase Price and Reduction are correct).
     *
     * @return $this
     */
    public function setNewPurchasePrice($new_purchase_price)
    {
        $this->container['new_purchase_price'] = $new_purchase_price;

        return $this;
    }

    /**
     * Gets reduce_price_by
     *
     * @return int
     */
    public function getReducePriceBy()
    {
        return $this->container['reduce_price_by'];
    }

    /**
     * Sets reduce_price_by
     *
     * @param int $reduce_price_by An integer number in the lowest denomination in the currency being used (e.g. supply 1034 to indicate $10.34)  Must be zero, or greater than zero and less than the current purchase price for the order ID concerned.  This will reduce the current value of a Plan by the nominated amount and helps cater for Split Order situations where the original value of the order is no longer known.
     *
     * @return $this
     */
    public function setReducePriceBy($reduce_price_by)
    {
        $this->container['reduce_price_by'] = $reduce_price_by;

        return $this;
    }

    /**
     * Gets full_refund
     *
     * @return bool
     */
    public function getFullRefund()
    {
        return $this->container['full_refund'];
    }

    /**
     * Sets full_refund
     *
     * @param bool $full_refund If True then the entire order will be refunded instead of reduced.  A setting of True here will completely override the NewPurchasePrice and ReducePriceBy field values.  If Null then assumed to be False.
     *
     * @return $this
     */
    public function setFullRefund($full_refund)
    {
        $this->container['full_refund'] = $full_refund;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
