<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MultiCart\Persistence;

interface MultiCartEntityManagerInterface
{
    public function resetQuoteDefaultFlagByCustomer(string $customerReference): void;

    public function setDefaultQuote(int $idQuote): void;
}
