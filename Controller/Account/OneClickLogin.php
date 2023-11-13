<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Serj\OneClickLogin\Controller\Account;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Serj\OneClickLogin\Api\OneClickLoginInterface;

class OneClickLogin implements ActionInterface
{
    public function __construct(
        private readonly OneClickLoginInterface $oneClickLogin,
        private readonly RedirectFactory $redirectFactory
    ) {}

    public function execute(): ResultInterface
    {
        $this->oneClickLogin->processLogin();

        return $this->redirectFactory->create()->setPath('customer/account');
    }
}
