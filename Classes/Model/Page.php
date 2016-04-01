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
 * Class Page
 *
 * @package TYPO3\CMS\Wpimport\Model
 */
class Page extends AbstractModel
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
            'xpath' => 'link'
        ],
        'crdate' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'wp:post_date'
        ],
        'tstamp' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'pubDate'
        ],
        'creator' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'dc:creator'
        ],
        'content' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'content:encoded'
        ],
        'status' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'wp:status'
        ],
        'parent' => [
            'type' => self::TYPE_STRING,
            'xpath' => 'wp:post_parent'
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
    protected $crdate;

    /**
     * @var string
     */
    protected $tstamp;

    /**
     * @var string
     */
    protected $creator;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $parent;

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
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param string $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return string
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * @param string $tstamp
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return string
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param string $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}
