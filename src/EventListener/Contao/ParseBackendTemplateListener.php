<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\InputCounterBundle\EventListener\Contao;

use Contao\Controller;
use Contao\Input;
use Contao\System;
use HeimrichHannot\RequestBundle\Component\HttpFoundation\Request;

class ParseBackendTemplateListener
{
    public function __invoke($buffer, $template)
    {
        $table = Input::get('table');
        $id = Input::get('id');

        if (!isset($GLOBALS['HUH_INPUT_COUNT']) || !\is_array($GLOBALS['HUH_INPUT_COUNT']) || !$table || !$id) {
            return $buffer;
        }

        System::loadLanguageFile('default');

        $this->addDefaultsToConfig();

        foreach ($GLOBALS['HUH_INPUT_COUNT'] as $configData) {
            if ($configData['table'] === $table) {
                $buffer = str_replace('<body', '<body data-input-counter="'.htmlspecialchars(json_encode($configData['fields']), ENT_QUOTES, 'UTF-8').'"', $buffer);

                break;
            }
        }

        return $buffer;
    }

    protected function addDefaultsToConfig()
    {
        foreach ($GLOBALS['HUH_INPUT_COUNT'] as &$configData) {
            $table = $configData['table'];
            Controller::loadDataContainer($table);
            $dca = $GLOBALS['TL_DCA'][$table];

            foreach ($configData['fields'] as &$fieldData) {
                $name = $fieldData['name'];

                // inputType
                $fieldData['type'] = $dca['fields'][$name]['inputType'];

                // message
                if (!isset($fieldData['message'])) {
                    $fieldData['message'] = $GLOBALS['TL_LANG']['MSC']['huhInputCounterBundle']['charactersMessage'];
                }

                // max count
                if (!isset($fieldData['max'])) {
                    if (isset($dca['fields'][$name]['eval']['maxlength']) &&
                        ($maxLength = $dca['fields'][$name]['eval']['maxlength'])) {
                        $fieldData['max'] = $maxLength;
                    } else {
                        throw new \Exception('No max value for the field "'.$table.'.'.$name.'" found.');
                    }
                }
            }
        }
    }
}
