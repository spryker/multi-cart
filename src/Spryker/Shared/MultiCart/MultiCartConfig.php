<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\MultiCart;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class MultiCartConfig extends AbstractSharedConfig
{
    /**
     * @var string
     */
    public const QUOTE_NAME_DEFAULT_GUEST = 'Guest shopping cart';

    /**
     * @var string
     */
    public const QUOTE_NAME_DEFAULT_CUSTOMER = 'Shopping cart';

    /**
     * @var string
     */
    public const QUOTE_NAME_DUPLICATE = '%s Copied At %s';

    /**
     * @var string
     */
    public const QUOTE_NAME_REORDER = 'Cart from order %s';

    /**
     * @var string
     */
    public const QUOTE_NAME_QUICK_ORDER = 'Quick order %s';

    /**
     * @api
     *
     * @return string
     */
    public function getGuestQuoteDefaultName(): string
    {
        return static::QUOTE_NAME_DEFAULT_GUEST;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCustomerQuoteDefaultName(): string
    {
        return static::QUOTE_NAME_DEFAULT_CUSTOMER;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getDuplicatedQuoteName(): string
    {
        return static::QUOTE_NAME_DUPLICATE;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getReorderQuoteName(): string
    {
        return static::QUOTE_NAME_REORDER;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getQuickOrderQuoteName(): string
    {
        return static::QUOTE_NAME_QUICK_ORDER;
    }
}
