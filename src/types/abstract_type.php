<?php
/**
 * File containing the ezcReflectionAbstractType class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Reflection
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Abstract class provides default implementation for types.
 * Methods do return null or false values as default.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
abstract class ezcReflectionAbstractType implements ezcReflectionType
{

    /**
     * @var string
     */
    protected $typeName = null;

    /**
     * @param string $typeName
     */
    public function __construct($typeName)
    {
        $this->typeName = ezcReflectionTypeMapper::getInstance()->getTypeName( $typeName );
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * @return boolean
     */
    public function isArray()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isObject()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isPrimitive()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isMap()
    {
        return false;
    }

    /**
     * Returns whether this type is one of integer, float, string, or boolean.
     *
     * Types array, object, resource, NULL, mixed, number, and callback are not
     * scalar.
     *
     * @return boolean
     */
    public function isScalarType()
    {
        return false;
    }

    /**
     * Returns name of the correspondent XML Schema datatype
     *
     * The prefix `xsd' is comonly used to refer to the
     * XML Schema namespace.
     *
     * @param  boolean $usePrefix augments common prefix `xsd:' to the name
     * @return string
     */
    public function getXmlName($usePrefix = true)
    {
        if ($usePrefix) {
            $prefix = 'xsd:';
        } else {
            $prefix = '';
        }

        return $prefix . ezcReflectionTypeMapper::getInstance()->getXmlType( $this->getTypeName() );
    }

    /**
     * @param  DOMDocument $dom
     * @return DOMElement
     */
    public function getXmlSchema(DOMDocument $dom)
    {
        return null;
    }

    /**
     * Returns a string representation.
     *
     * @return String Type name
     */
    public function __toString()
    {
        return $this->getTypeName();
    }

}
