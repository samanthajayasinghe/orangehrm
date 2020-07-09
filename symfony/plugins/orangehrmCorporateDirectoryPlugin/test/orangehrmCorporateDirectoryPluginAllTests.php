<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class orangehrmCorporateDirectoryPluginAllTests {

    protected function setUp() :void {
        
    }

    public static function suite() {

        $suite = new PHPUnit\Framework\TestSuite('orangehrmCorporateDirectoryPlugin');

        /* Dao Test Cases */
        $suite->addTestFile(dirname(__FILE__) . '/model/dao/EmployeeDirectoryDaoTest.php');
        $suite->addTestFile(dirname(__FILE__) . '/model/service/EmployeeDirectoryServiceTest.php');
        
        /* Helper Test */
        $suite->addTestFile(dirname(__FILE__) . '/model/wrapper/CorporateDirectoryWebServiceHelperTest.php');

        /* Wrapper Test */
        $suite->addTestFile(dirname(__FILE__) . '/model/wrapper/CorporateDirectoryWebServiceWrapperTest.php');
        return $suite;
    }

    public static function main() {
        PHPUnit\TextUI\TestRunner::run(self::suite());
    }
    
}

