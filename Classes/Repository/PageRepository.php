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
use TYPO3\CMS\Wpimport\Model\Page;

/**
 * Class PageRepository
 *
 * @package TYPO3\CMS\Wpimport\Repository
 */
class PageRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $xpath = "//channel/item[wp:post_type='page']";

    /**
     * @var string
     */
    protected $modelClass = Page::class;
}
