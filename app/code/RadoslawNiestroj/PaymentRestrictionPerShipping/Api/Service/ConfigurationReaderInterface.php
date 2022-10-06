<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service;

interface ConfigurationReaderInterface
{
    /**
     * @param int $storeId
     * @return bool
     */
    public function isEnabled(int $storeId): bool;

    /**
     * @param int $storeId
     * @return string|null
     */
    public function getRelations(int $storeId): ?string;
}
