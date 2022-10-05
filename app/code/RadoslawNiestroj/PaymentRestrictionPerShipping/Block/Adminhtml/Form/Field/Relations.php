<?php

declare(strict_types=1);

namespace RadoslawNiestroj\PaymentRestrictionPerShipping\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Relations extends AbstractFieldArray
{
    public const COLUMN_DELIVERY_METHOD = 'delivery_method';
    public const COLUMN_PAYMENT_METHOD = 'payment_method';

    private const INDEX_DATA = 'data';
    private const INDEX_IS_RENDER_TO_JS_TEMPLATE = 'is_render_to_js_template';
    private const INDEX_LABEL = 'label';
    private const INDEX_RENDERER = 'renderer';

    private const LABEL_ADD_RELATION = 'Add relation';
    private const LABEL_DELIVERY_METHOD = 'Delivery method';
    private const LABEL_PAYMENT_METHOD = 'Excluded payment methods';

    private const OPTION_EXTRA_ATTRS = 'option_extra_attrs';
    private const OPTION_STR = 'option_';
    private const SELECTED_STR = 'selected="selected"';

    private ?DeliveryMethod $deliveryMethod = null;

    private ?PaymentMethod $paymentMethod = null;

    /**
     * @return void
     * @throws LocalizedException
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn(self::COLUMN_DELIVERY_METHOD, [
            self::INDEX_LABEL => __(self::LABEL_DELIVERY_METHOD),
            self::INDEX_RENDERER => $this->getDeliveryMethod()
        ]);

        $this->addColumn(self::COLUMN_PAYMENT_METHOD, [
            self::INDEX_LABEL => __(self::LABEL_PAYMENT_METHOD),
            self::INDEX_RENDERER => $this->getPaymentMethod(),
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __(self::LABEL_ADD_RELATION);
    }

    /**
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $paymentMethod = $row->getPaymentMethod();
        $deliveryMethod = $row->getDeliveryMethod();

        if ((null !== $paymentMethod) && (0 < count($paymentMethod))) {
            foreach ($paymentMethod as $method) {
                $options[self::OPTION_STR . $this->getPaymentMethod()->calcOptionHash($method)] =
                    self::SELECTED_STR;
            }
        }

        $options[self::OPTION_STR . $this->getDeliveryMethod()->calcOptionHash($deliveryMethod)] = self::SELECTED_STR;

        $row->setData(self::OPTION_EXTRA_ATTRS, $options);
    }

    /**
     * @return DeliveryMethod
     * @throws LocalizedException
     */
    private function getDeliveryMethod(): DeliveryMethod
    {
        if (!$this->deliveryMethod) {
            $this->deliveryMethod = $this->getLayout()->createBlock(
                DeliveryMethod::class,
                '',
                [
                    self::INDEX_DATA => [
                        self::INDEX_IS_RENDER_TO_JS_TEMPLATE => true,
                    ],
                ]
            );
        }

        return $this->deliveryMethod;
    }

    /**
     * @return PaymentMethod|null
     * @throws LocalizedException
     */
    private function getPaymentMethod(): ?PaymentMethod
    {
        if (!$this->paymentMethod) {
            $this->paymentMethod = $this->getLayout()->createBlock(
                PaymentMethod::class,
                '',
                [
                    self::INDEX_DATA => [
                        self::INDEX_IS_RENDER_TO_JS_TEMPLATE => true,
                    ],
                ]
            );
        }

        return $this->paymentMethod;
    }
}
