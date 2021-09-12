<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class CustomerCategoryService
{
    public function getUsageCategory(Customer $customer)
    {
        return 'new-user';
    }
}
