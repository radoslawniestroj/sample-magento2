<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Service\Config\Source;

use Magento\Payment\Helper\Data as PaymentMethods;
use Magento\Shipping\Model\Config\Source\Allmethods as ShippingMethods;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\Config\Source\SalesMethodsInterface;

class SalesMethods implements SalesMethodsInterface
{
    public function __construct(
        private readonly ShippingMethods $shippingMethods,
        private readonly PaymentMethods $paymentMethods
    ) {
    }

    /**
     * @return array
     */
    public function getAllShippingMethods(): array
    {
        return $this->shippingMethods->toOptionArray();
    }

    /**
     * @return array
     */
    public function getAllPaymentMethods(): array
    {
        return $this->paymentMethods->getPaymentMethodList(true,  false, true);
    }
}
