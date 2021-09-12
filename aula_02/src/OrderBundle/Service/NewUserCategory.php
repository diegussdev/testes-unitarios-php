<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class NewUserCategory implements CustomerCategoryInterface
{
    public function isEligible(Customer $customer)
    {
        return true;
    }

    public function getCustomerCategoryName()
    {
        return CustomerCategoryService::CATEGORY_NEW_USER;
    }
}
