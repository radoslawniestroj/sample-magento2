<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service;

interface RelationsInterface
{
    /**
     * @param string $paymentMethod
     * @param string $shippingMethod
     * @param int $storeId
     * @return bool
     */
    public function isPaymentMethodAvailable(
        string $paymentMethod,
        string $shippingMethod,
        int $storeId
    ): bool;
}
