<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Serj\OneClickLogin\Model\Config\Source;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;

class Customers implements OptionSourceInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly LoggerInterface $logger,
        private readonly ManagerInterface $messageManager,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder
    ) {}

    public function toOptionArray(): array
    {
        try {
            $customers = $this->customerRepository->getList($this->searchCriteriaBuilder->create());
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->logger->error($e->getMessage(), $e->getTrace());

            return [];
        }

        $options = [];
        foreach ($customers->getItems() as $customer) {
            $options[] = [
                'label' => $customer->getEmail(),
                'value' => $customer->getId(),
            ];
        }

        return $options;
    }
}
