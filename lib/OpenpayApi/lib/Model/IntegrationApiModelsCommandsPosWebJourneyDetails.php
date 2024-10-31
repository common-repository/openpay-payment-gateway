<?php
/**
 * IntegrationApiModelsCommandsPosWebJourneyDetails
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
 * IntegrationApiModelsCommandsPosWebJourneyDetails Class Doc Comment
 *
 * @category Class
 * @description Details of a POS Web journey. Required if the Origin is set to \&quot;PosWeb\&quot;
 * @package  Openpay\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class IntegrationApiModelsCommandsPosWebJourneyDetails implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'IntegrationApi.Models.Commands.PosWebJourneyDetails';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'plan_creation_type' => 'string',
'employee_code' => 'string',
'callback_url' => 'string',
'cancel_url' => 'string',
'fail_url' => 'string'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'plan_creation_type' => null,
'employee_code' => null,
'callback_url' => null,
'cancel_url' => null,
'fail_url' => null    ];

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
        'plan_creation_type' => 'planCreationType',
'employee_code' => 'employeeCode',
'callback_url' => 'callbackUrl',
'cancel_url' => 'cancelUrl',
'fail_url' => 'failUrl'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'plan_creation_type' => 'setPlanCreationType',
'employee_code' => 'setEmployeeCode',
'callback_url' => 'setCallbackUrl',
'cancel_url' => 'setCancelUrl',
'fail_url' => 'setFailUrl'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'plan_creation_type' => 'getPlanCreationType',
'employee_code' => 'getEmployeeCode',
'callback_url' => 'getCallbackUrl',
'cancel_url' => 'getCancelUrl',
'fail_url' => 'getFailUrl'    ];

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
        $this->container['plan_creation_type'] = isset($data['plan_creation_type']) ? $data['plan_creation_type'] : null;
        $this->container['employee_code'] = isset($data['employee_code']) ? $data['employee_code'] : null;
        $this->container['callback_url'] = isset($data['callback_url']) ? $data['callback_url'] : null;
        $this->container['cancel_url'] = isset($data['cancel_url']) ? $data['cancel_url'] : null;
        $this->container['fail_url'] = isset($data['fail_url']) ? $data['fail_url'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['plan_creation_type'] === null) {
            $invalidProperties[] = "'plan_creation_type' can't be null";
        }
        if ($this->container['callback_url'] === null) {
            $invalidProperties[] = "'callback_url' can't be null";
        }
        if ($this->container['cancel_url'] === null) {
            $invalidProperties[] = "'cancel_url' can't be null";
        }
        if ($this->container['fail_url'] === null) {
            $invalidProperties[] = "'fail_url' can't be null";
        }
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
     * Gets plan_creation_type
     *
     * @return string
     */
    public function getPlanCreationType()
    {
        return $this->container['plan_creation_type'];
    }

    /**
     * Sets plan_creation_type
     *
     * @param string $plan_creation_type Based on this flag, plan will be created as pending capture
     *
     * @return $this
     */
    public function setPlanCreationType($plan_creation_type)
    {
        $this->container['plan_creation_type'] = $plan_creation_type;

        return $this;
    }

    /**
     * Gets employee_code
     *
     * @return string
     */
    public function getEmployeeCode()
    {
        return $this->container['employee_code'];
    }

    /**
     * Sets employee_code
     *
     * @param string $employee_code The name, number or code representing the individual who created the order
     *
     * @return $this
     */
    public function setEmployeeCode($employee_code)
    {
        $this->container['employee_code'] = $employee_code;

        return $this;
    }

    /**
     * Gets callback_url
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->container['callback_url'];
    }

    /**
     * Sets callback_url
     *
     * @param string $callback_url URL to redirect to upon successful plan creation or lodgement (may also serve as the only one, as it has parameter ‘status’: SUCCESS, LODGED, CANCELLED, FAILED)
     *
     * @return $this
     */
    public function setCallbackUrl($callback_url)
    {
        $this->container['callback_url'] = $callback_url;

        return $this;
    }

    /**
     * Gets cancel_url
     *
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->container['cancel_url'];
    }

    /**
     * Sets cancel_url
     *
     * @param string $cancel_url URL to redirect to when user cancels the plan creation or lodgement
     *
     * @return $this
     */
    public function setCancelUrl($cancel_url)
    {
        $this->container['cancel_url'] = $cancel_url;

        return $this;
    }

    /**
     * Gets fail_url
     *
     * @return string
     */
    public function getFailUrl()
    {
        return $this->container['fail_url'];
    }

    /**
     * Sets fail_url
     *
     * @param string $fail_url URL to redirect to when a system error occurs
     *
     * @return $this
     */
    public function setFailUrl($fail_url)
    {
        $this->container['fail_url'] = $fail_url;

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
