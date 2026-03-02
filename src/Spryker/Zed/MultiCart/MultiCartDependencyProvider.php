<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MultiCart;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToMessengerFacadeBridge;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToPersistentCartFacadeBridge;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToQuoteFacadeBridge;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToStoreFacadeBridge;

/**
 * @method \Spryker\Zed\MultiCart\MultiCartConfig getConfig()
 */
class MultiCartDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_QUOTE = 'QUERY_QUOTE';

    /**
     * @var string
     */
    public const FACADE_MESSENGER = 'CLIENT_MESSENGER';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const FACADE_QUOTE = 'FACADE_QUOTE';

    /**
     * @var string
     */
    public const FACADE_PERSISTENT_CART = 'FACADE_PERSISTENT_CART';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addQuoteFacade($container);
        $container = $this->addMessengerFacade($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addPersistentCartFacade($container);

        return $container;
    }

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addMessengerFacade($container);
        $container = $this->addQuoteFacade($container);

        return $container;
    }

    protected function addQuoteFacade(Container $container): Container
    {
        $container->set(static::FACADE_QUOTE, function (Container $container) {
            return new MultiCartToQuoteFacadeBridge($container->getLocator()->quote()->facade());
        });

        return $container;
    }

    protected function addMessengerFacade(Container $container): Container
    {
        $container->set(static::FACADE_MESSENGER, function (Container $container) {
            return new MultiCartToMessengerFacadeBridge($container->getLocator()->messenger()->facade());
        });

        return $container;
    }

    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new MultiCartToStoreFacadeBridge($container->getLocator()->store()->facade());
        });

        return $container;
    }

    protected function addPersistentCartFacade(Container $container): Container
    {
        $container->set(static::FACADE_PERSISTENT_CART, function (Container $container) {
            return new MultiCartToPersistentCartFacadeBridge($container->getLocator()->persistentCart()->facade());
        });

        return $container;
    }
}
