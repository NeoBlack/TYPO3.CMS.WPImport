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
use TYPO3\CMS\Wpimport\Model\Category;

/**
 * Class CategoryRepository
 *
 * @package TYPO3\CMS\Wpimport\Repository
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $xpath = '//channel/wp:category';

    /**
     * @var string
     */
    protected $modelClass = Category::class;

    /**
     * @param $nicename
     *
     * @return mixed
     */
    public function findByNicename($nicename)
    {
        /** @var Category $category */
        foreach ($this->objectStorage as $category) {
            if ($nicename === $category->getNicename()) {
                return $category;
            }
        }
        return false;
    }
}
