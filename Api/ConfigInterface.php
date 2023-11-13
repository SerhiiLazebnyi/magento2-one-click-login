<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Serj\OneClickLogin\Api;

interface ConfigInterface
{
    public function isEnabled(): bool;

    public function getCustomerId(): int;
}
