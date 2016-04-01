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
 * Class Tag
 *
 * @package TYPO3\CMS\Wpimport\Model
 */
class Tag extends AbstractModel
{
    /**
     * @var array
     */
    protected static $propertyMapping = [
        'id' => [
            'type' => self::TYPE_INT,
            'xpath' => 'wp:term_id',
        ],
        'title' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'wp:tag_name'
        ],
        'slug' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'wp:tag_slug'
        ]
    ];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}
