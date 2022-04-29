<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart\Plugin;

use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\QuoteUpdateRequestAttributesTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\PersistentCartExtension\Dependency\Plugin\PersistentCartChangeExpanderPluginInterface;

/**
 * @method \Spryker\Client\MultiCart\MultiCartFactory getFactory()
 */
class QuickOrderQuoteNameExpanderPlugin extends AbstractPlugin implements PersistentCartChangeExpanderPluginInterface
{
    /**
     * @var string
     */
    public const PARAM_SUBMIT_BUTTON_CREATE_ORDER = 'createOrder';

    /**
     * Specification:
     * - Takes quote id from params and replace it in quote change request.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PersistentCartChangeTransfer $persistentCartChangeTransfer
     * @param array<string, mixed> $params
     *
     * @return \Generated\Shared\Transfer\PersistentCartChangeTransfer
     */
    public function extend(PersistentCartChangeTransfer $persistentCartChangeTransfer, array $params = []): PersistentCartChangeTransfer
    {
        if (!isset($params[static::PARAM_SUBMIT_BUTTON_CREATE_ORDER])) {
            return $persistentCartChangeTransfer;
        }

        $quoteUpdateRequestAttributes = new QuoteUpdateRequestAttributesTransfer();
        if ($persistentCartChangeTransfer->getQuoteUpdateRequestAttributes()) {
            $quoteUpdateRequestAttributes = $persistentCartChangeTransfer->getQuoteUpdateRequestAttributes();
        }
        $quoteUpdateRequestAttributes->setName(
            sprintf(
                $this->getFactory()->getMultiCartConfig()->getQuickOrderQuoteName(),
                $this->getFactory()->getDateTimeService()->formatDateTime(date('Y-m-d H:i:s')),
            ),
        );
        $persistentCartChangeTransfer->setIdQuote(0)
            ->setQuoteUpdateRequestAttributes($quoteUpdateRequestAttributes);

        return $persistentCartChangeTransfer;
    }
}
