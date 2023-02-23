<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface MultiCartToZedRequestClientInterface
{
    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|null $requestOptions
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call(string $url, TransferInterface $object, ?array $requestOptions = null): TransferInterface;

    /**
     * @return void
     */
    public function addFlashMessagesFromLastZedRequest(): void;

    /**
     * @return void
     */
    public function addResponseMessagesToMessenger(): void;
}
