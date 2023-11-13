<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Serj\OneClickLogin\Api;

interface OneClickLoginInterface
{
    public function processLogin(): void;
}
