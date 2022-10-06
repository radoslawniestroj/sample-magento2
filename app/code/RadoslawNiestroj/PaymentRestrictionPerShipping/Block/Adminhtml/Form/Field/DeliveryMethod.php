<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\Config\Source\SalesMethodsInterface;

class DeliveryMethod extends Select
{
    public function __construct(
        Context $context,
        private readonly SalesMethodsInterface $salesMethods,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputId(string $value): DeliveryMethod
    {
        return $this->setId($value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputName(string $value): DeliveryMethod
    {
        return $this->setName($value);
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if (empty($this->getOptions())) {
            $this->setOptions($this->getSourceOptions());
        }

        return parent::_toHtml();
    }

    /**
     * @return array
     */
    private function getSourceOptions(): array
    {
        return $this->salesMethods->getAllShippingMethods();
    }
}
