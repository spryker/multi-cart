<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart\Storage;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface MultiCartStorageInterface
{
    public function setQuoteCollection(QuoteCollectionTransfer $quoteCollectionTransfer): void;

    public function getQuoteCollection(): QuoteCollectionTransfer;

    public function findQuoteById(int $idQuote): ?QuoteTransfer;
}
