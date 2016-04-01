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
 * Class Attachment
 *
 * @package TYPO3\CMS\Wpimport\Model
 */
class Attachment extends AbstractModel
{
    /**
     * @var array
     */
    protected static $propertyMapping = [
        'id' => [
            'type' => self::TYPE_INT,
            'xpath' => 'wp:post_id',
        ],
        'title' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'title'
        ],
        'link' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'wp:attachment_url'
        ],
        'alt' => [
            'type' => self::TYPE_STRING,
            'xpath' => "wp:postmeta[wp:meta_key='_wp_attachment_image_alt']/wp:meta_value"
        ],
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
    protected $link;

    /**
     * @var string
     */
    protected $alt;

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }
}
