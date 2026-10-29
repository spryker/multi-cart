<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MultiCart\Business\MultiCartFacade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Propel\Runtime\Propel;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group MultiCart
 * @group Business
 * @group MultiCartFacade
 * @group ResetQuoteDefaultFlagByCustomerTest
 * Add your own group annotations below this line
 */
class ResetQuoteDefaultFlagByCustomerTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\MultiCart\MultiCartBusinessTester
     */
    protected $tester;

    public function testClearsTheDefaultFlagOnTheCustomersDefaultQuote(): void
    {
        // Arrange
        $customerReference = $this->createCustomerReference();
        $idQuote = $this->haveQuote($customerReference, true);

        // Act
        $this->tester->getFacade()->resetQuoteDefaultFlagByCustomer($customerReference);

        // Assert
        $this->assertFalse($this->tester->isQuoteDefault($idQuote));
    }

    public function testLeavesTheCustomersAlreadyNonDefaultQuoteAlone(): void
    {
        // Arrange
        $customerReference = $this->createCustomerReference();
        $idDefaultQuote = $this->haveQuote($customerReference, true);
        $idOtherQuote = $this->haveQuote($customerReference, false);

        // Act
        $this->tester->getFacade()->resetQuoteDefaultFlagByCustomer($customerReference);

        // Assert
        $this->assertFalse($this->tester->isQuoteDefault($idDefaultQuote));
        $this->assertFalse($this->tester->isQuoteDefault($idOtherQuote));
    }

    public function testDoesNotTouchAnotherCustomersDefaultQuote(): void
    {
        // Arrange
        $customerReference = $this->createCustomerReference();
        $otherCustomerReference = $this->createCustomerReference();
        $idOtherCustomerQuote = $this->haveQuote($otherCustomerReference, true);

        // Act
        $this->tester->getFacade()->resetQuoteDefaultFlagByCustomer($customerReference);

        // Assert
        $this->assertTrue($this->tester->isQuoteDefault($idOtherCustomerQuote));
    }

    /**
     * Covers the early return a customer with no cart yet takes. The observable outcome is
     * unchanged by that guard — its purpose is to leave the customer_reference index unlocked,
     * which only a concurrency run can show — so this asserts the no-op, not the locking.
     */
    public function testIsANoOpForACustomerWithoutQuotes(): void
    {
        // Arrange
        $customerReference = $this->createCustomerReference();
        $idUnrelatedQuote = $this->haveQuote($this->createCustomerReference(), true);

        // Act
        $this->tester->getFacade()->resetQuoteDefaultFlagByCustomer($customerReference);

        // Assert
        $this->assertTrue($this->tester->isQuoteDefault($idUnrelatedQuote));
    }

    /**
     * The guard exists so that nothing writes through the customer_reference index when there is
     * nothing to reset — that is what leaves the gap unlocked for the INSERT following in the same
     * quote-create transaction, and it is the difference between this code and the version that
     * deadlocks. Asserting the emitted statement is the only way to pin that in-process; revert the
     * guard and this test fails, where the behavioural tests above stay green.
     */
    public function testEmitsNoWriteThroughTheCustomerReferenceIndexWhenThereIsNothingToReset(): void
    {
        // Arrange
        $customerReference = $this->createCustomerReference();
        /** @var \Propel\Runtime\Connection\ConnectionWrapper $connection */
        $connection = Propel::getConnection();
        $connection->useDebug(true);

        // Act
        $this->tester->getFacade()->resetQuoteDefaultFlagByCustomer($customerReference);
        $lastExecutedQuery = $connection->getLastExecutedQuery();
        $connection->useDebug(false);

        // Assert
        $this->assertStringStartsWith('SELECT', $lastExecutedQuery);
        $this->assertStringNotContainsString('UPDATE', $lastExecutedQuery);
    }

    protected function createCustomerReference(): string
    {
        return sprintf('multi-cart-reset-%s', uniqid());
    }

    protected function haveQuote(string $customerReference, bool $isDefault): int
    {
        $quoteTransfer = $this->tester->havePersistentQuote([
            QuoteTransfer::CUSTOMER_REFERENCE => $customerReference,
            QuoteTransfer::CUSTOMER => (new CustomerTransfer())->setCustomerReference($customerReference),
        ]);

        $idQuote = $quoteTransfer->getIdQuoteOrFail();
        $this->tester->setQuoteDefaultFlag($idQuote, $isDefault);

        return $idQuote;
    }
}
