<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['HUH_INPUT_COUNT'] = [];

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseBackendTemplate']['contao-input-counter-bundle'] = [
    \HeimrichHannot\InputCounterBundle\EventListener\Contao\ParseBackendTemplateListener::class,
    '__invoke',
];

$GLOBALS['TL_HOOKS']['loadDataContainer']['contao-input-counter-bundle'] = [
    \HeimrichHannot\InputCounterBundle\EventListener\Contao\LoadDataContainerListener::class,
    '__invoke',
];
