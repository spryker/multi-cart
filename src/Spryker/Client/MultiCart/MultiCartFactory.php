<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\MultiCart\CartOperation\CartCreator;
use Spryker\Client\MultiCart\CartOperation\CartCreatorInterface;
use Spryker\Client\MultiCart\CartOperation\CartDeleteChecker;
use Spryker\Client\MultiCart\CartOperation\CartDeleteCheckerInterface;
use Spryker\Client\MultiCart\CartOperation\CartReader;
use Spryker\Client\MultiCart\CartOperation\CartReaderInterface;
use Spryker\Client\MultiCart\CartOperation\CartUpdater;
use Spryker\Client\MultiCart\CartOperation\CartUpdaterInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToCustomerClientInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToMessengerClientInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToPersistentCartClientInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToQuoteClientInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToSessionClientInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToStoreClientInterface;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientInterface;
use Spryker\Client\MultiCart\Dependency\Service\MultiCartToUtilDateTimeServiceInterface;
use Spryker\Client\MultiCart\QuoteStorageSynchronizer\CustomerLoginQuoteSync;
use Spryker\Client\MultiCart\QuoteStorageSynchronizer\CustomerLoginQuoteSyncInterface;
use Spryker\Client\MultiCart\Storage\MultiCartStorage;
use Spryker\Client\MultiCart\Storage\MultiCartStorageInterface;
use Spryker\Client\MultiCart\Zed\MultiCartZedStub;
use Spryker\Client\MultiCart\Zed\MultiCartZedStubInterface;

/**
 * @method \Spryker\Client\MultiCart\MultiCartConfig getConfig()
 */
class MultiCartFactory extends AbstractFactory
{
    public function createMultiCartZedStub(): MultiCartZedStubInterface
    {
        return new MultiCartZedStub($this->getZedRequestClient());
    }

    public function getMultiCartConfig(): MultiCartConfig
    {
        return $this->getConfig();
    }

    public function createMultiCartStorage(): MultiCartStorageInterface
    {
        return new MultiCartStorage(
            $this->getSessionClient(),
            $this->getStoreClient(),
            $this->getConfig(),
        );
    }

    public function createCustomerLoginQuoteSave(): CustomerLoginQuoteSyncInterface
    {
        return new CustomerLoginQuoteSync(
            $this->getPersistentCartClient(),
            $this->getQuoteClient(),
        );
    }

    public function createCartUpdater(): CartUpdaterInterface
    {
        return new CartUpdater(
            $this->createMultiCartZedStub(),
            $this->getPersistentCartClient(),
            $this->getQuoteClient(),
            $this->getCustomerClient(),
            $this->getZedRequestClient(),
        );
    }

    public function createCartCreator(): CartCreatorInterface
    {
        return new CartCreator(
            $this->getPersistentCartClient(),
            $this->getQuoteClient(),
            $this->getCustomerClient(),
            $this->getDateTimeService(),
            $this->getConfig(),
        );
    }

    public function createCartReader(): CartReaderInterface
    {
        return new CartReader(
            $this->createMultiCartZedStub(),
        );
    }

    public function getQuoteClient(): MultiCartToQuoteClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_QUOTE);
    }

    public function getCustomerClient(): MultiCartToCustomerClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_CUSTOMER);
    }

    public function getMessengerClient(): MultiCartToMessengerClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_MESSENGER);
    }

    public function getSessionClient(): MultiCartToSessionClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_SESSION);
    }

    public function getZedRequestClient(): MultiCartToZedRequestClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_ZED_REQUEST);
    }

    public function getPersistentCartClient(): MultiCartToPersistentCartClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_PERSISTENT_CART);
    }

    public function getDateTimeService(): MultiCartToUtilDateTimeServiceInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::SERVICE_DATETIME);
    }

    public function createCartDeleteChecker(): CartDeleteCheckerInterface
    {
        return new CartDeleteChecker(
            $this->createMultiCartStorage(),
        );
    }

    public function getStoreClient(): MultiCartToStoreClientInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::CLIENT_STORE);
    }
}
