<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class CustomerCategoryService
{
    const CATEGORY_NEW_USER = 'new-user';

    public function getUsageCategory(Customer $customer)
    {
        return self::CATEGORY_NEW_USER;
    }
}
