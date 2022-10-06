<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Plugin\Magento\Payment\Model\Checks;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Payment\Model\Checks\Composite as MagentoChecksComposite;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Model\Quote;
use Magento\Store\Model\StoreManagerInterface;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\ConfigurationReaderInterface;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\RelationsInterface;

class Composite
{
    public function __construct(
        private readonly ConfigurationReaderInterface $configurationReader,
        private readonly RelationsInterface $relations,
        private readonly StoreManagerInterface $storeManager
    ) {
    }

    /**
     * @param MagentoChecksComposite $subject
     * @param bool $result
     * @param MethodInterface $paymentMethod
     * @param Quote $quote
     * @return bool
     * @throws NoSuchEntityException
     */
    public function afterIsApplicable(
        MagentoChecksComposite $subject,
        bool $result,
        MethodInterface $paymentMethod,
        Quote $quote
    ): bool {
        $storeId = (int)$this->storeManager->getStore()->getId();

        if (!$result || !$this->isModuleEnabled($storeId)) {
            return $result;
        }

        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();

        return $this->relations->isPaymentMethodAvailable(
            (string)$paymentMethod->getCode(),
            (string)$shippingMethod,
            $storeId
        );
    }

    /**
     * @param int $storeId
     * @return bool
     */
    private function isModuleEnabled(int $storeId): bool
    {
        return $this->configurationReader->isEnabled($storeId);
    }
}
