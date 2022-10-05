<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\Config\Source;

interface SalesMethodsInterface
{
    /**
     * @return array
     */
    public function getAllShippingMethods(): array;

    /**
     * @return array
     */
    public function getAllPaymentMethods(): array;
}
