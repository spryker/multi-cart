<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MultiCart\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MultiCart\Business\Activator\QuoteActivator;
use Spryker\Zed\MultiCart\Business\Activator\QuoteActivatorInterface;
use Spryker\Zed\MultiCart\Business\Messenger\MultiCartMessenger;
use Spryker\Zed\MultiCart\Business\Messenger\MultiCartMessengerInterface;
use Spryker\Zed\MultiCart\Business\Model\QuoteNameResolver;
use Spryker\Zed\MultiCart\Business\Model\QuoteNameResolverInterface;
use Spryker\Zed\MultiCart\Business\Provider\CartReorderProvider;
use Spryker\Zed\MultiCart\Business\Provider\CartReorderProviderInterface;
use Spryker\Zed\MultiCart\Business\Quote\QuoteWriter;
use Spryker\Zed\MultiCart\Business\Quote\QuoteWriterInterface;
use Spryker\Zed\MultiCart\Business\Reader\QuoteCollectionReader;
use Spryker\Zed\MultiCart\Business\Reader\QuoteCollectionReaderInterface;
use Spryker\Zed\MultiCart\Business\ResponseExpander\QuoteResponseExpander;
use Spryker\Zed\MultiCart\Business\ResponseExpander\QuoteResponseExpanderInterface;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToMessengerFacadeInterface;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToPersistentCartFacadeInterface;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToQuoteFacadeInterface;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToStoreFacadeInterface;
use Spryker\Zed\MultiCart\MultiCartDependencyProvider;

/**
 * @method \Spryker\Zed\MultiCart\MultiCartConfig getConfig()
 * @method \Spryker\Zed\MultiCart\Persistence\MultiCartEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MultiCart\Persistence\MultiCartRepositoryInterface getRepository()
 */
class MultiCartBusinessFactory extends AbstractBusinessFactory
{
    public function createQuoteActivator(): QuoteActivatorInterface
    {
        return new QuoteActivator(
            $this->getQuoteFacade(),
            $this->getMessengerFacade(),
        );
    }

    public function createQuoteNameResolver(): QuoteNameResolverInterface
    {
        return new QuoteNameResolver(
            $this->getRepository(),
        );
    }

    public function createQuoteResponseExpander(): QuoteResponseExpanderInterface
    {
        return new QuoteResponseExpander(
            $this->getQuoteFacade(),
            $this->getStoreFacade(),
        );
    }

    public function createQuoteCollectionReader(): QuoteCollectionReaderInterface
    {
        return new QuoteCollectionReader($this->getQuoteFacade());
    }

    public function createQuoteWriter(): QuoteWriterInterface
    {
        return new QuoteWriter(
            $this->getRepository(),
            $this->getEntityManager(),
            $this->getMessengerFacade(),
        );
    }

    public function createMultiCartMessenger(): MultiCartMessengerInterface
    {
        return new MultiCartMessenger(
            $this->getRepository(),
            $this->getMessengerFacade(),
        );
    }

    public function createCartReorderProvider(): CartReorderProviderInterface
    {
        return new CartReorderProvider($this->getPersistentCartFacade());
    }

    protected function getQuoteFacade(): MultiCartToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::FACADE_QUOTE);
    }

    protected function getMessengerFacade(): MultiCartToMessengerFacadeInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::FACADE_MESSENGER);
    }

    public function getStoreFacade(): MultiCartToStoreFacadeInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::FACADE_STORE);
    }

    public function getPersistentCartFacade(): MultiCartToPersistentCartFacadeInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::FACADE_PERSISTENT_CART);
    }
}
