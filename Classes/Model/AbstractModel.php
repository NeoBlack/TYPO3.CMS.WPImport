<?php
namespace TYPO3\CMS\Wpimport\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class AbstractModel
 *
 * @package TYPO3\CMS\Wpimport\Model
 */
abstract class AbstractModel
{
    const TYPE_INT = 'int';
    const TYPE_STRING = 'string';
    const TYPE_ARRAY = 'array';

    /**
     * @var array
     */
    protected static $propertyMapping = [];

    /**
     * AbstractModel constructor.
     *
     * @param \SimpleXMLElement $xmlData
     */
    public function __construct(\SimpleXMLElement $xmlData)
    {
        foreach (static::$propertyMapping as $propertyName => $propertyConfig) {
            $value = null;
            switch ($propertyConfig['type']) {
                case 'int':
                    $value = (int) $xmlData->xpath($propertyConfig['xpath'])[0];
                    break;
                case 'string':
                    $value = (string) $xmlData->xpath($propertyConfig['xpath'])[0];
                    break;
                case 'array':
                    $value = [];
                    foreach ($xmlData->xpath($propertyConfig['xpath']) as $item) {
                        $value[] = $item;
                    }
                    break;
            }

            $this->{$propertyName} = $value;
        }
    }
}
