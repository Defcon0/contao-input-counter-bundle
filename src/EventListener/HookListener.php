<?php

namespace HeimrichHannot\InputCounterBundle\EventListener;

use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\System;
use HeimrichHannot\RequestBundle\Component\HttpFoundation\Request;

class HookListener
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * @var Request
     */
    private $request;

    /**
     * HookListener constructor.
     */
    public function __construct(ContaoFrameworkInterface $framework, Request $request)
    {
        $this->framework = $framework;
        $this->request = $request;
    }

    public function addInputCount($buffer, $template)
    {
        $table = $this->request->getGet('table');
        $id = $this->request->getGet('id');

        if (!isset($GLOBALS['HUH_INPUT_COUNT']) || !is_array($GLOBALS['HUH_INPUT_COUNT']) || !$table || !$id)
        {
            return $buffer;
        }

        System::loadLanguageFile('default');

        $this->addDefaultsToConfig();

        foreach ($GLOBALS['HUH_INPUT_COUNT'] as $configData)
        {
            if ($configData['table'] === $table)
            {
                $buffer = str_replace('<body', '<body data-input-counter="' . htmlspecialchars(\json_encode($configData['fields']), ENT_QUOTES, 'UTF-8') . '"', $buffer);

                break;
            }
        }

        return $buffer;
    }

    protected function addDefaultsToConfig()
    {
        foreach ($GLOBALS['HUH_INPUT_COUNT'] as &$configData)
        {
            $table = $configData['table'];
            Controller::loadDataContainer($table);
            $dca = $GLOBALS['TL_DCA'][$table];

            foreach ($configData['fields'] as &$fieldData)
            {
                $name = $fieldData['name'];

                // inputType
                $fieldData['type'] = $dca['fields'][$name]['inputType'];

                // message
                if (!isset($fieldData['message']))
                {
                    $fieldData['message'] = $GLOBALS['TL_LANG']['MSC']['huhInputCounterBundle']['charactersMessage'];
                }

                // max count
                if (!isset($fieldData['max']))
                {
                    if (isset($dca['fields'][$name]['eval']['maxlength']) &&
                        ($maxLength = $dca['fields'][$name]['eval']['maxlength']))
                    {
                        $fieldData['max'] = $maxLength;
                    }
                    else
                    {
                        throw new \Exception('No max value for the field "' . $table . '.' . $name . '" found.');
                    }
                }
            }
        }
    }
}