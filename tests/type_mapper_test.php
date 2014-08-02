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

class ezcReflectionTypeMapperTest extends ezcTestCase
{

    /**
	 * @var ezcReflectionTypeMapper
     */
    public $fixture;

    public function setUp()
    {
        $this->fixture = ezcReflectionTypeMapper::getInstance();
    }

    public function testIsScalarType()
    {
        $ezcReflectionPrimitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean');
        foreach ($ezcReflectionPrimitiveTypes as $type) {
            self::assertTrue(ezcReflectionTypeMapper::getInstance()->isScalarType($type));
        }

        $noneezcReflectionPrimitiveTypes = array('ReflectionClass', 'array', 'int[]',
                                    'string[]', 'NonExistingClassFooBar');
        foreach ($noneezcReflectionPrimitiveTypes as $type) {
            self::assertFalse(ezcReflectionTypeMapper::getInstance()->isScalarType($type));
        }
    }

    public function testIsArray()
    {
        $arrayDefs = array('array', 'string[]', 'bool[]', 'ReflectionClass[]',
                           'NonExistingTypeFooBar[]');
        foreach ($arrayDefs as $type) {
            self::assertTrue(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }

        $arrayDefs = array('array(int=>string)', 'array(string=>ReflectionClass)',
                           'array(ReflectionClass=>float)');
        foreach ($arrayDefs as $type) {
            self::assertTrue(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }

        $noneezcReflectionArrayTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean', 'NonExistingClassFooBar',
                                'ReflectionClass');
        foreach ($noneezcReflectionArrayTypes as $type) {
            self::assertFalse(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }

    }

    /**
     * Test ez Style arrays
     */
    public function testIsArray2()
    {
        $arrayDefs = array('array(string=>float)', 'array(int=>ReflectionClass)',
                           'array(string=>array(int=>ReflectionClass))');
        foreach ($arrayDefs as $type) {
            self::assertTrue(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }
    }

    public function testGetXmlTypeWithNonStandardTypeName()
    {
        self::assertEquals( 'int', ezcReflectionTypeMapper::getInstance()->getXmlType( 'int' ) );
    }

    public function testGetXmlTypeWithNonExistingType()
    {
        self::assertNull( ezcReflectionTypeMapper::getInstance()->getXmlType( 'NonExistingType' ) );
    }

    /**
     * @return array
     */
    public function getTypeNames()
    {
        return array(
            array( 'integer', 'scalar' ),
            array( 'int', 'scalar' ),
            array( 'INT', 'scalar' ),
            array( 'float', 'scalar' ),
            array( 'double', 'scalar' ),
            array( 'string', 'scalar' ),
            array( 'bool', 'scalar' ),
            array( 'boolean', 'scalar' ),
            array( 'ReflectionClass', 'class' ),
            array( 'NonExistingClassFooBar', 'class' ),
            array( 'array', 'array' ),
            array( 'int[]', 'array' ),
            array( 'string[]', 'array' ),
            array( 'ReflectionClass[]', 'array' ),
            array( 'array(int=>string)', 'array' ),
            array( 'array(string=>ReflectionClass)', 'array' ),
            array( 'array(ReflectionClass=>float)', 'array' ),
            array( 'array(integer=>array(integer=>string))', 'array' ),
            array( 'array(int=>string[])', 'array' ),
            array( 'mixed', 'mixed' ),
            array( 'number', 'mixed' ),
            array( 'callback', 'mixed' ),
        );
    }

    /**
     * @dataProvider getTypeNames()
     *
     * @param  string $typeName
     * @param  string $category
     * @return void
     */
    public function testTypeCategorization($typeName, $category)
    {
        switch ($category) {
            case 'scalar':
                self::assertTrue( $this->fixture->isScalarType( $typeName ) );
                self::assertFalse( $this->fixture->isArray( $typeName ) );
                self::assertFalse( $this->fixture->isMixed( $typeName ) );
                break;
            case 'class':
                self::assertfalse( $this->fixture->isScalarType( $typeName ) );
                self::assertFalse( $this->fixture->isArray( $typeName ) );
                self::assertFalse( $this->fixture->isMixed( $typeName ) );
                break;
            case 'array':
                self::assertFalse( $this->fixture->isScalarType( $typeName ) );
                self::assertTrue( $this->fixture->isArray( $typeName ) );
                self::assertFalse( $this->fixture->isMixed( $typeName ) );
                break;
            case 'mixed':
                self::assertFalse( $this->fixture->isScalarType( $typeName ) );
                self::assertFalse( $this->fixture->isArray( $typeName ) );
                self::assertTrue( $this->fixture->isMixed( $typeName ) );
                break;
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionTypeMapperTest" );
    }
}
