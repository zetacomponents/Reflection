<?php
/**
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionPropertyFromClassTest extends ezcReflectionPropertyTest
{

    public function setUpFixtures()
    {
        $class = new ezcReflectionClass( 'SomeClass' );
        $this->refProp = $class->getProperty( $this->refPropName );
        $this->publicProperty = $class->getProperty( $this->publicPropertyName );
        $this->actual['SomeClass']['undocumentedProperty'] = $class->getProperty( $this->undocumentedPropertyName );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionPropertyFromClassTest" );
    }
}
