<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\InputCounterBundle\EventListener\Contao;

use HeimrichHannot\UtilsBundle\Container\ContainerUtil;

class LoadDataContainerListener
{
    /**
     * @var ContainerUtil
     */
    protected $containerUtil;

    public function __construct(ContainerUtil $containerUtil)
    {
        $this->containerUtil = $containerUtil;
    }

    public function __invoke($table)
    {
        if ($this->containerUtil->isBackend()) {
            $GLOBALS['TL_JAVASCRIPT']['contao-input-counter-bundle'] = 'bundles/heimrichhannotinputcounter/input-counter-bundle.js|static';
        }
    }
}
