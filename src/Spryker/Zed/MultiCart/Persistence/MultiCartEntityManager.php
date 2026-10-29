<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MultiCart\Persistence;

use Generated\Shared\Transfer\SpyQuoteEntityTransfer;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\MultiCart\Persistence\MultiCartPersistenceFactory getFactory()
 */
class MultiCartEntityManager extends AbstractEntityManager implements MultiCartEntityManagerInterface
{
    public function resetQuoteDefaultFlagByCustomer(string $customerReference): void
    {
        $idsQuote = $this->getFactory()
            ->createQuoteQuery()
            ->filterByCustomerReference($customerReference)
            ->filterByIsDefault(true)
            ->select(SpyQuoteTableMap::COL_ID_QUOTE)
            ->find()
            ->toArray();

        if (!$idsQuote) {
            return;
        }

        $this->getFactory()
            ->createQuoteQuery()
            ->filterByIdQuote($idsQuote, Criteria::IN)
            ->update([ucfirst(SpyQuoteEntityTransfer::IS_DEFAULT) => false]);
    }

    public function setDefaultQuote(int $idQuote): void
    {
        $this->getFactory()
            ->createQuoteQuery()
            ->filterByIdQuote($idQuote)
            ->update([ucfirst(SpyQuoteEntityTransfer::IS_DEFAULT) => true]);
    }
}
