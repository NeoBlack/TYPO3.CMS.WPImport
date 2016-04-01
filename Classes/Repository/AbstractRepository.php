<?php
namespace TYPO3\CMS\Wpimport\Repository;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AbstractRepository
 *
 * @package TYPO3\CMS\Wpimport\Repository
 */
abstract class AbstractRepository
{
    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * @var string
     */
    protected $modelClass;

    /**
     * @var string
     */
    protected $xpath;

    /**
     * @var array
     */
    protected $objectStorage = [];

    /**
     * AbstractRepository constructor.
     *
     * @param \SimpleXMLElement $xmlData
     */
    public function __construct(\SimpleXMLElement $xmlData)
    {
        $this->namespaces = $xmlData->getNamespaces(true);
        foreach ($this->namespaces as $k => $uri) {
            $xmlData->registerXPathNamespace($k, $uri);
        }

        foreach ($xmlData->xpath($this->xpath) as $objectXML) {
            $this->objectStorage[] = GeneralUtility::makeInstance($this->modelClass, $objectXML);
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->objectStorage;
    }
}
