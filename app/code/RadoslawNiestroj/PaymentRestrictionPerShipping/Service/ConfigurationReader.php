<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\ConfigurationReaderInterface;

class ConfigurationReader implements ConfigurationReaderInterface
{
    public const CONFIG_PATH_ENABLED = 'config_payment_restriction_per_shipping/general/enabled';

    public const CONFIG_PATH_RELATIONS = 'config_payment_restriction_per_shipping/relations_configuration/relations';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @param int $storeId
     * @return bool
     */
    public function isEnabled(int $storeId): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param int $storeId
     * @return string|null
     */
    public function getRelations(int $storeId): ?string
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_RELATIONS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
