<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Service;

use Magento\Framework\Serialize\Serializer\Json;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\ConfigurationReaderInterface;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\RelationsInterface;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Block\Adminhtml\Form\Field\Relations as FieldRelations;

class Relations implements RelationsInterface
{
    private array $paymentRestriction;

    public function __construct(
        private readonly Json $json,
        private readonly ConfigurationReaderInterface $configurationReader
    ) {
    }

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
    ): bool {
        $paymentMethodToRestrict = $this->getPaymentRestriction($shippingMethod, $storeId);

        if ($paymentMethodToRestrict === null) {
            return true;
        }

        if (in_array($paymentMethod, $paymentMethodToRestrict)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $shippingMethod
     * @param int $storeId
     * @return array|null
     */
    private function getPaymentRestriction(string $shippingMethod, int $storeId): ?array
    {
        if (isset($this->paymentRestriction[$shippingMethod][$storeId])) {
            return $this->paymentRestriction[$shippingMethod][$storeId];
        }

        $relationsJson =  $this->configurationReader->getRelations($storeId);
        if (empty($relationsJson)) {
            return null;
        }

        $relations = $this->json->unserialize($relationsJson);

        foreach ($relations as $relation) {
            if ($this->isRestrictionExistForShippingMethod($relation, $shippingMethod)) {
                return $this->paymentRestriction[$shippingMethod][$storeId] =
                    $relation[FieldRelations::COLUMN_PAYMENT_METHOD];
            }
        }

        return $this->paymentRestriction[$shippingMethod][$storeId] = null;
    }

    /**
     * @param array $relation
     * @param string $shippingMethod
     * @return bool
     */
    private function isRestrictionExistForShippingMethod(array $relation, string $shippingMethod): bool
    {
        return isset(
                $relation[FieldRelations::COLUMN_DELIVERY_METHOD],
                $relation[FieldRelations::COLUMN_PAYMENT_METHOD]
            ) && $shippingMethod === $relation[FieldRelations::COLUMN_DELIVERY_METHOD];
    }
}
