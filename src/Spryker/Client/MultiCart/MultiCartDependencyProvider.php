<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToCustomerClientBridge;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToMessengerClientBridge;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToPersistentCartClientBridge;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToQuoteClientBridge;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToSessionClientBridge;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToStoreClientBridge;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientBridge;
use Spryker\Client\MultiCart\Dependency\Service\MultiCartToUtilDateTimeServiceBridge;

/**
 * @method \Spryker\Client\MultiCart\MultiCartConfig getConfig()
 */
class MultiCartDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_MESSENGER = 'CLIENT_MESSENGER';

    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @var string
     */
    public const CLIENT_PERSISTENT_CART = 'CLIENT_PERSISTENT_CART';

    /**
     * @var string
     */
    public const CLIENT_QUOTE = 'CLIENT_QUOTE';

    /**
     * @var string
     */
    public const CLIENT_SESSION = 'CLIENT_SESSION';

    /**
     * @var string
     */
    public const CLIENT_ZED_REQUEST = 'CLIENT_ZED_REQUEST';

    /**
     * @var string
     */
    public const SERVICE_DATETIME = 'SERVICE_DATETIME';

    /**
     * @var string
     */
    public const CLIENT_STORE = 'CLIENT_STORE';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addCustomerClient($container);
        $container = $this->addMessengerClient($container);
        $container = $this->addPersistentCartClient($container);
        $container = $this->addQuoteClient($container);
        $container = $this->addSessionClient($container);
        $container = $this->addZedRequestClient($container);
        $container = $this->addDateTimeService($container);
        $container = $this->addStoreClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSessionClient(Container $container): Container
    {
        $container->set(static::CLIENT_SESSION, function (Container $container) {
            return new MultiCartToSessionClientBridge($container->getLocator()->session()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container->set(static::CLIENT_CUSTOMER, function (Container $container) {
            return new MultiCartToCustomerClientBridge($container->getLocator()->customer()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addQuoteClient(Container $container): Container
    {
        $container->set(static::CLIENT_QUOTE, function (Container $container) {
            return new MultiCartToQuoteClientBridge($container->getLocator()->quote()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addZedRequestClient(Container $container): Container
    {
        $container->set(static::CLIENT_ZED_REQUEST, function (Container $container) {
            return new MultiCartToZedRequestClientBridge($container->getLocator()->zedRequest()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPersistentCartClient(Container $container): Container
    {
        $container->set(static::CLIENT_PERSISTENT_CART, function (Container $container) {
            return new MultiCartToPersistentCartClientBridge($container->getLocator()->persistentCart()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addMessengerClient(Container $container): Container
    {
        $container->set(static::CLIENT_MESSENGER, function (Container $container) {
            return new MultiCartToMessengerClientBridge($container->getLocator()->messenger()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addDateTimeService(Container $container): Container
    {
        $container->set(static::SERVICE_DATETIME, function (Container $container) {
            return new MultiCartToUtilDateTimeServiceBridge(
                $container->getLocator()->utilDateTime()->service(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addStoreClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORE, function (Container $container) {
            return new MultiCartToStoreClientBridge($container->getLocator()->store()->client());
        });

        return $container;
    }
}
