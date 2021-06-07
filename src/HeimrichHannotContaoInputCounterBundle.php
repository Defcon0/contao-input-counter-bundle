<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\InputCounterBundle;

use HeimrichHannot\InputCounterBundle\DependencyInjection\InputCounterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotContaoInputCounterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new InputCounterExtension();
    }
}
