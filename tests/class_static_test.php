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

/**
 * This is an optional test case for the integration of the staticReflection.
 *
 * It is only activated when the code of staticReflection is provided in
 * Reflection/tests/staticReflection
 */
class ezcReflectionClassStaticTest extends ezcReflectionClassTest
{

    public function setUpFixtures()
    {
        $session = new pdepend\reflection\ReflectionSession();
        $array = array(
            'SomeClass' => dirname( __FILE__ ) . '/test_classes/SomeClass.php',
            'IInterface' => dirname( __FILE__ ) . '/test_classes/interface.php',
            'BaseClass' => dirname( __FILE__ ) . '/test_classes/BaseClass.php',
            'TestWebservice' => dirname( __FILE__ ) . '/test_classes/webservice.php',
        );
        $resolver = new pdepend\reflection\resolvers\AutoloadArrayResolver( $array );
        $session->addClassFactory(
            new pdepend\reflection\factories\StaticReflectionClassFactory(
                new pdepend\reflection\ReflectionClassProxyContext( $session ), $resolver
            )
        );
        $session->addClassFactory(
            new pdepend\reflection\factories\InternalReflectionClassFactory()
        );

        //$session = pdepend\reflection\ReflectionSession::createInternalSession();
        //$this->reflectionSession = $session;
        //pdepend\reflection\ReflectionSessionInstance::set( $session );
        /*
        $query = $session->createDirectoryQuery();
        $query->find( dirname( __FILE__ ) . '/test_classes' );
        foreach ( $query->find( dirname( __FILE__ ) . '/test_classes' ) as $class ) {
            if ( $class->getName() == 'SomeClass' )
                $this->class                   = new ezcReflectionClass( $class );
            if ( $class->getName() == 'TestWebservice' )
                $this->classTestWebservice     = new ezcReflectionClass( $class );
        }
        */
        $this->class                   = new ezcReflectionClass( $session->getClass( 'SomeClass' ) );
        $this->classTestWebservice     = new ezcReflectionClass( $session->getClass( 'TestWebservice' ) );
        $this->classReflectionFunction = new ezcReflectionClass( $session->getClass( 'ReflectionFunction' ) );
        //$this->classReflectionFunction = new ezcReflectionClass( 'ReflectionFunction' );

        /*/
        $query = $session->createFileQuery();
        $this->interface = $query->find( dirname( __FILE__ ) . '/test_classes/interface.php' )->current();
        $this->class                   = new ezcReflectionClass( $query->find( dirname( __FILE__ ) . '/test_classes/SomeClass.php' )->current() );
        $this->classTestWebservice     = new ezcReflectionClass( $query->find( dirname( __FILE__ ) . '/test_classes/webservice.php' )->current() );
        //$this->classReflectionFunction = new ezcReflectionClass( $session->getClass( 'ReflectionFunction' ) );
        $this->classReflectionFunction = new ezcReflectionClass( 'ReflectionFunction' );
        //*/
    }

    public function testSetStaticPropertyValue()
    {
        try {
            parent::testSetStaticPropertyValue();
        } catch ( ReflectionException $e ) {
            self::assertEquals( 'Method setStaticPropertyValue() is not supported', $e->getMessage() );
            $this->expected['SomeClass']->setStaticPropertyValue( 'staticProperty', 'StaticValue' );
        }
    }

    /**
     * @dataProvider getWrapperMethodsWithParameters
     */
    public function testWrapperMethodsWithParameters($fixtureName, $method, $arguments)
    {
        try {
            if ($method != 'setStaticPropertyValue') {
                parent::testWrapperMethodsWithParameters( $fixtureName, $method, $arguments );
            }
        } catch ( ReflectionException $e ) {
            self::assertEquals( 'Method ' . $method . '() is not supported', $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
