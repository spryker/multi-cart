<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MultiCart\Persistence;

use Generated\Shared\Transfer\QuoteTransfer;

interface MultiCartRepositoryInterface
{
    public function findSimilarCustomerQuoteNames(QuoteTransfer $quoteTransfer): array;

    public function checkQuoteNameAvailability(QuoteTransfer $quoteTransfer): bool;

    public function findCustomerQuoteData(string $customerReference): array;

    public function isQuoteDefault(int $idQuote, string $customerReference): bool;
}
