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

class ezcReflectionTypeFactoryTest extends ezcTestCase
{
    /**
	 * @var ezcReflectionTypeFactoryImpl
     */
    protected $factory;

    public function setUp()
    {
        $this->factory = new ezcReflectionTypeFactoryImpl();
    }

    public function tearDown()
    {
        unset( $this->factory );
    }

    /**
     * Test with primitive types
     */
    public function testGetTypePrimitive()
    {
        $ezcReflectionPrimitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean', 'void', 'object');
        foreach ($ezcReflectionPrimitiveTypes as $prim) {
            $type = $this->factory->getType($prim);
            self::assertInstanceOf('ezcReflectionType', $type);
            self::assertInstanceOf('ezcReflectionPrimitiveType', $type);
        }
    }

    /**
     * Test with object types
	 * @expectedException ReflectionException
     */
    public function testGetTypeObject()
    {
        $classes = array('ReflectionClass', 'ezcTestClass');
        foreach ($classes as $class) {
            $type = $this->factory->getType($class);
            self::assertInstanceOf('ezcReflectionType', $type);
            self::assertInstanceOf('ezcReflectionObjectType', $type);
            self::assertInstanceOf( 'ReflectionClass', $type->getClass() );
        }

        $type = $this->factory->getType('NoneExistingClass');
        self::assertInstanceOf( 'ReflectionClass', $type->getClass() );
    }

    public function testGetTypeReturnsNullOnEmptyArgument()
    {
        self::assertNull( $this->factory->getType( null ) );
    }

    public function testGetTypeReturnsObjectOnReflectionClass()
    {
        $class = new ReflectionClass( 'stdClass' );
        $type = $this->factory->getType( $class );
        self::assertInstanceOf('ezcReflectionType', $type);
        self::assertInstanceOf('ezcReflectionObjectType', $type);
        $actualClass = $type->getClass();
        self::assertInstanceOf( 'ReflectionClass', $actualClass );
        self::assertSame( $class, $actualClass );
    }

    public function getArrayTypeNames()
    {
        $typeNames = array(
           array( 'array', 'mixed', 'mixed', 'array(mixed=>mixed)'),
           array( 'string[]', 'integer', 'string' ),
           array( 'array(integer=>string)', 'integer', 'string' ),
           array( 'array(string=>ReflectionClass)', 'string', 'ReflectionClass' ),
           array( 'array(ReflectionClass=>float)', 'ReflectionClass', 'float' ),
           array( 'array(integer=>string[])', 'integer', 'string[]' ),
           array( 'array(integer=>array(integer=>string))', 'integer', 'array(integer=>string)' ),
           array( 'array(float=>array(integer[]=>boolean))', 'float', 'array(integer[]=>boolean)' ),
           array( 'array(float=>array(integer[]=>boolean))', 'float', 'array(integer[]=>boolean)' ),
           array( 'array(double=>array(int[]=>bool))', 'float', 'array(integer[]=>boolean)', 'array(float=>array(integer[]=>boolean))' ),
           // TODO  Support maps as keys of map in ezcReflectionArrayType
           //array( 'array(array(integer[]=>boolean)=>float)', 'array(integer[]=>boolean)', 'float' ),
        );
        $result = $typeNames;

        // generate type names with white space at the beginning and end
        foreach ($typeNames as $typeName) {
            $typeNameWithWhiteSpace = $typeName;
            $typeNameWithWhiteSpace[0] = ' ' .$typeName[0] . "\t";
            if ( !isset( $typeName[3] ) ) {
                $typeNameWithWhiteSpace[3] = $typeName[0];
            }
            $result[] = $typeNameWithWhiteSpace;
        }

        return $result;
    }

    /**
     * Test with array types
     *
     * @dataProvider getArrayTypeNames
     */
    public function testGetTypeArray($arrayTypeName, $indexTypeName, $valueTypeName, $canonicalName = null)
    {
        if ($canonicalName == null) {
            $canonicalName = $arrayTypeName;
        }
        $type = $this->factory->getType($arrayTypeName);
        self::assertInstanceOf('ezcReflectionType', $type);
        self::assertInstanceOf('ezcReflectionArrayType', $type);
        self::assertInstanceOf('ezcReflectionType', $type->getKeyType());
        self::assertInstanceOf('ezcReflectionType', $type->getValueType());
        self::assertEquals($canonicalName, $type->getTypeName());
        self::assertEquals($indexTypeName, $type->getKeyType()->getTypeName());
        self::assertEquals($valueTypeName, $type->getValueType()->getTypeName());
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionTypeFactoryTest" );
    }
}
