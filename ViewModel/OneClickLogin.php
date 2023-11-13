<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Serj\OneClickLogin\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class OneClickLogin implements ArgumentInterface
{
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly UrlInterface $urlBuilder
    ) {}

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('customer/startup/enable_one_click_login');
    }

    public function getUrl(): string
    {
        return $this->urlBuilder->getUrl('customer/account/oneClickLogin');
    }
}
