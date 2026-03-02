<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart\Zed;

use Generated\Shared\Transfer\QuoteActivationRequestTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientInterface;

class MultiCartZedStub implements MultiCartZedStubInterface
{
    /**
     * @var \Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientInterface
     */
    protected $zedRequestClient;

    public function __construct(MultiCartToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    public function setDefaultQuote(QuoteActivationRequestTransfer $quoteActivationRequestTransfer): QuoteResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteResponseTransfer $quoteResponseTransfer */
        $quoteResponseTransfer = $this->zedRequestClient->call('/multi-cart/gateway/set-default-quote', $quoteActivationRequestTransfer);

        return $quoteResponseTransfer;
    }

    public function duplicateQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteResponseTransfer $quoteResponseTransfer */
        $quoteResponseTransfer = $this->zedRequestClient->call('/multi-cart/gateway/duplicate-quote', $quoteTransfer);

        return $quoteResponseTransfer;
    }

    public function getQuoteCollectionByCriteria(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteCollectionTransfer $quoteResponseTransfer */
        $quoteResponseTransfer = $this->zedRequestClient->call(
            '/multi-cart/gateway/get-quote-collection-by-criteria',
            $quoteCriteriaFilterTransfer,
        );

        return $quoteResponseTransfer;
    }
}
