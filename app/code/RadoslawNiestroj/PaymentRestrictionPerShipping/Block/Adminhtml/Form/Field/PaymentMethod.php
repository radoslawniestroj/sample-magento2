<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use RadoslawNiestroj\PaymentRestrictionPerShipping\Api\Service\Config\Source\SalesMethodsInterface;

class PaymentMethod extends Select
{
    private const ARRAY_SYMBOL = '[]';

    private const MULTISELECT_CLASS = 'payment-method-select payment-multiselect';

    private const MULTISELECT_PARAMS = 'multiple="multiple"';

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
    public function setInputId(string $value): PaymentMethod
    {
        return $this->setId($value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputName(string $value): PaymentMethod
    {
        return $this->setName($value . self::ARRAY_SYMBOL);
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if (empty($this->getOptions())) {
            $this->setOptions($this->getPaymentMethods());
        }

        $this->setClass(self::MULTISELECT_CLASS);
        $this->setExtraParams(self::MULTISELECT_PARAMS);

        return parent::_toHtml();
    }

    /**
     * @return array
     */
    private function getPaymentMethods(): array
    {
        return $this->salesMethods->getAllPaymentMethods();
    }
}
