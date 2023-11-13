<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Serj\OneClickLogin\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use Serj\OneClickLogin\Api\ConfigInterface;
use Serj\OneClickLogin\Api\OneClickLoginInterface;
use Serj\OneClickLogin\Model\Config\Source\Customers;

class OneClickLogin implements OneClickLoginInterface
{
    public function __construct(
        private readonly ConfigInterface $config,
        private readonly CustomerFactory $customerFactory,
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly Customers $customersSource,
        private readonly LoggerInterface $logger,
        private readonly ManagerInterface $messageManager,
        private readonly Session $customerSession
    ) {}

    public function processLogin(): void
    {
        $customerId = $this->config->getCustomerId();

        if (!$customerId) {
            $customerId = $this->getFirstCustomerIdFromSource();
        }

        if (!$customerId) {
            $message = \__('One click login customer is not set');

            $this->logger->warning($message);
            $this->messageManager->addErrorMessage($message);

            return;
        }

        try {
            $customer = $this->customerRepository->getById($customerId);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            $this->messageManager->addErrorMessage('Can\'t load customer');

            return;
        }

        $customer = $this->customerFactory->create()->updateData($customer);

        $this->customerSession->setCustomerAsLoggedIn($customer);
    }

    private function getFirstCustomerIdFromSource(): int
    {
        $sourceData = $this->customersSource->toOptionArray();
        $firstCustomer = \current($sourceData);

        return (int) $firstCustomer['id'] ?? 0;
    }
}
