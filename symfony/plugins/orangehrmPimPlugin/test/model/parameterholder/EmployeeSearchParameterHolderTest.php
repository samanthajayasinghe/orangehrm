<?php
/*
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
 
class EmployeeSearchParameterHolderTest extends PHPUnit\Framework\TestCase {
    
    private $parameterHolder;
    
    public function setup(): void {
        $this->parameterHolder = new EmployeeSearchParameterHolder();
    }

    public function testOrderBy() {
        
        $result = $this->parameterHolder->getOrderBy();
        $this->assertEquals('ASC', $result);
        
        $this->parameterHolder->setOrderBy('DESC');
        $result = $this->parameterHolder->getOrderBy();
        $this->assertEquals('DESC', $result);
        
    }
    
    
    
} 