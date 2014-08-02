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
class ezcReflectionMethodStaticTest extends ezcReflectionMethodTest
{
    protected function setUpFixtures()
    {
        $session = new pdepend\reflection\ReflectionSession();
        $array = array(
            'TestMethods' => dirname( __FILE__ ) . '/test_classes/methods.php',
            'TestMethods2' => dirname( __FILE__ ) . '/test_classes/methods2.php',
        );
        $resolver = new pdepend\reflection\resolvers\AutoloadArrayResolver( $array );
        //$resolver = new pdepend\reflection\resolvers\AutoloadArrayResolver( include( '../src/reflection_autoload.php' ) );
        $session->addClassFactory(
            new pdepend\reflection\factories\StaticReflectionClassFactory(
                new pdepend\reflection\ReflectionClassProxyContext( $session ), $resolver
            )
        );
        $session->addClassFactory(
            new pdepend\reflection\factories\InternalReflectionClassFactory()
        );

        // ezcReflectionMethods obtained from staticReflectionClass
        $classTestMethods = new ezcReflectionClass( $session->getClass( 'TestMethods' ) );
        $this->fctM1 = $classTestMethods->getMethod( 'm1' );
        $this->fctM2 = $classTestMethods->getMethod( 'm2' );
        $this->fctM3 = $classTestMethods->getMethod( 'm3' );
        $this->fctM4 = $classTestMethods->getMethod( 'm4' );
        $classTestMethods2 = new ezcReflectionClass( $session->getClass( 'TestMethods2' ) );
        $classTestMethods2DYNAMIC = new ezcReflectionClass( 'TestMethods2' );
        $this->ezc_TestMethods2_m1 = $classTestMethods2DYNAMIC->getMethod( 'm1' );
        $this->ezc_TestMethods2_m2 = $classTestMethods2->getMethod( 'm2' );
        $this->ezc_TestMethods2_m3 = $classTestMethods2DYNAMIC->getMethod( 'm3' );
        $this->ezc_TestMethods2_m4 = $classTestMethods2DYNAMIC->getMethod( 'm4' );
        $this->ezc_TestMethods2_newMethod = $classTestMethods2->getMethod( 'newMethod' );
        $classReflectionClass = new ezcReflectionClass( $session->getClass( 'ReflectionClass' ) );
        $this->fct_method_exists = $classReflectionClass->getMethod( 'hasMethod' );
        $classReflectionMethod = new ezcReflectionClass( $session->getClass( 'ReflectionMethod' ) );
        $this->ezc_ReflectionMethod_isInternal = $classReflectionMethod->getMethod( 'isInternal' );
        $classEzcReflectionMethod = new ezcReflectionClass( $session->getClass( 'ezcReflectionMethod' ) );
        $this->ezc_ezcReflectionMethod_isInternal = $classEzcReflectionMethod->getMethod( 'isInternal' );
        $this->ezc_ezcReflectionMethod_isInherited = $classEzcReflectionMethod->getMethod( 'isInherited' );
        $this->ezc_ezcReflectionMethod_getAnnotations = $classEzcReflectionMethod->getMethod( 'getAnnotations' );
    }

    /**
     * @dataProvider getWrapperMethods
     */
    public function testWrapperMethods($method, $arguments)
    {
        if ($method != 'getPrototype') { // getPrototype is not yet implemented in staticReflection
            parent::testWrapperMethods( $method, $arguments );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
