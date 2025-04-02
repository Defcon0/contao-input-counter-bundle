<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\InputCounterBundle\EventListener\Contao;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\RequestStack;

class LoadDataContainerListener
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ScopeMatcher
     */
    protected $scopeMatcher;

    public function __construct(RequestStack $requestStack, ScopeMatcher $scopeMatcher)
    {
        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
    }

    public function __invoke($table)
    {
        if ($this->requestStack->getCurrentRequest() !== null && $this->scopeMatcher->isBackendRequest($this->requestStack->getCurrentRequest())) {
            $GLOBALS['TL_JAVASCRIPT']['contao-input-counter-bundle'] = 'bundles/heimrichhannotinputcounter/input-counter-bundle.js|static';
        }
    }
}
