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

class ezcReflectionParameterStaticTest extends ezcReflectionParameterTest
{
    public function setUpFixtures()
    {
        $session = new pdepend\reflection\ReflectionSession();
        $array = array(
            'TestMethods' => dirname( __FILE__ ) . '/test_classes/methods.php',
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

        // function with undocumented parameter $t that has default value 'foo'
        // Functions are not yet supported in staticReflection, thus using ezcReflection again
        foreach ($this->expected['mmm'] as $key => $param) {
            $this->actual['mmm'][$key] = new ezcReflectionParameter( null, $param );
        }

        // function with three parameters that have type annotations but no type hints
        $paramTypes = array( 'string', 'ezcReflection', 'ReflectionClass' );
        foreach ($this->expected['m1'] as $key => $param) {
            $this->actualParamsOfM1[] =
                new ezcReflectionParameter( null, $param, $paramTypes[$key] );
        }

        // method with one undocumented parameter
        $classTestMethods = $session->getClass( 'TestMethods' );
        $m3 = $classTestMethods->getMethod( 'm3' );
        foreach ( $m3->getParameters() as $param ) {
            $this->actualParamsOf_TestMethods_m3[] = new ezcReflectionParameter( null, $param );
        }

        // method with parameter that has type hint
        $ezcReflection = $session->getClass( 'ezcReflection' );
        $setReflectionTypeFactory = $ezcReflection->getMethod( 'setReflectionTypeFactory' );
        foreach ( $setReflectionTypeFactory->getParameters() as $param ) {
            $this->actualParamsOf_ezcReflection_setReflectionTypeFactory[] = new ezcReflectionParameter( null, $param, 'ezcReflectionTypeFactory' );
        }

        // function with parameter that has type hint only
        // Functions are not yet supported in staticReflection, thus using ezcReflection again
        $this->actualParamsOf_functionWithTypeHint[] = new ezcReflectionParameter( 'ReflectionClass', $this->expected['functionWithTypeHint'][0] );
    }

    public function testExport($functionName = null, $paramKey = null)
    {
        // no need to test this again
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

}
