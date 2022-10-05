<?php

declare(strict_types=1);

namespace RadoslawNiestroj\SampleModule\Plugin\Magento\Checkout\Controller\Cart;

use Magento\Checkout\Controller\Cart\Add;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class AddPlugin
{
    /**
     * @param Add $subject
     * @return void
     */
    public function beforeExecute(Add $subject): void
    {
        // before plugin
    }

    /**
     * @param Add $subject
     * @param ResponseInterface|ResultInterface $result
     * @return ResponseInterface|ResultInterface
     */
    public function afterExecute(Add $subject, ResponseInterface|ResultInterface $result): ResponseInterface|ResultInterface
    {
        // after plugin

        return $result;
    }

    /**
     * @param Add $subject
     * @param callable $proceed
     * @return mixed
     */
    public function aroundExecute(Add $subject, callable $proceed): ResponseInterface|ResultInterface
    {
        // around plugin

        return $proceed();
    }
}
