<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Serj\OneClickLogin\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Serj\OneClickLogin\Api\ConfigInterface;

class Config implements ConfigInterface
{
    private const XPATH_ENABLE_ONE_CLICK_LOGIN = 'customer/startup/enable_one_click_login';
    private const XPATH_ONE_CLICK_LOGIN_CUSTOMER = 'customer/startup/one_click_login_customer';

    public function __construct(private readonly ScopeConfigInterface $scopeConfig) {}

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XPATH_ENABLE_ONE_CLICK_LOGIN);
    }

    public function getCustomerId(): int
    {
        return (int) $this->scopeConfig->getValue(self::XPATH_ONE_CLICK_LOGIN_CUSTOMER);
    }
}
