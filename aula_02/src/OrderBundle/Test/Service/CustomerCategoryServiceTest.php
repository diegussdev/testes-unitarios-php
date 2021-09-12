<?php

namespace OrderBundle\Test\Service;

use OrderBundle\Entity\Customer;
use OrderBundle\Service\CustomerCategoryService;
use PHPUnit\Framework\TestCase;

class CustomerCategoryServiceTest extends TestCase
{
    /**
     * @test
     */
    public function customerShouldBeNewUser()
    {
        $customerCategoryService = new CustomerCategoryService();

        $customer = new Customer();
        $usageCategory = $customerCategoryService->getUsageCategory($customer);

        $this->assertEquals('new-user', $usageCategory);
    }
}
