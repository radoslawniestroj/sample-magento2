<?php

declare(strict_types=1);

namespace RadoslawNiestroj\SampleModule\Observer\Checkout;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class AddToCartObserver implements ObserverInterface
{
    public function __construct(
        private readonly Session $customerSession,
        private readonly CustomerRepositoryInterface $customerRepositoryInterface,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer): void
    {
        // get customer object by observer
        $customer = $observer->getEvent()->getCustomer();


        // get customer object by session id
        $customerId = $this->customerSession->getId();

        try {
            $customer = $this->customerRepositoryInterface->getById($customerId);
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->logger->error('There is no customer with given id');
            throw new NoSuchEntityException(__('There is no customer with given id'));
        }
    }
}
