<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart\Dependency\Client;

interface MultiCartToMessengerClientInterface
{
    public function addInfoMessage(string $message): void;

    public function addErrorMessage(string $message): void;

    public function addSuccessMessage(string $message): void;
}
