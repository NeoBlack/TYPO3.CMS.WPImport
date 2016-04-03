<?php
namespace TYPO3\CMS\Wpimport\Controller;

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
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Wpimport\Model\Attachment;
use TYPO3\CMS\Wpimport\Model\Category;
use TYPO3\CMS\Wpimport\Model\Page;
use TYPO3\CMS\Wpimport\Repository\AttachmentRepository;
use TYPO3\CMS\Wpimport\Repository\CategoryRepository;
use TYPO3\CMS\Wpimport\Repository\PageRepository;
use TYPO3\CMS\Wpimport\Repository\PostRepository;
use TYPO3\CMS\Wpimport\Repository\TagRepository;

/**
 * Backend module user administration controller
 */
class ImportController extends ActionController
{
    /**
     * @var
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * @var PageRepository
     */
    protected $pageRepository;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     *
     */
    public function indexAction()
    {
        $this->init();
        $dbConnection = $this->getDatabaseConnection();

        // Check Categories
        $categories = $this->categoryRepository->findAll();
        $importedCategories = 0;
        /** @var Category $category */
        foreach ($categories as $category) {
            $rows = $dbConnection->exec_SELECTgetRows(
                '*',
                'sys_category',
                'tx_wpimport_importid = ' . (int)$category->getId()
            );
            if (count($rows)) {
                $importedCategories++;
            }
        }
        $importCategories = false;
        if ($importedCategories < count($categories)) {
            $importCategories = true;
        }
        $this->view->assign('categories', $categories);
        $this->view->assign('importedCategories', $importedCategories);
        $this->view->assign('importCategories', $importCategories);

        // Check Attachments
        $attachments = $this->attachmentRepository->findAll();
        $importedAttachments = 0;
        /** @var Attachment $attachment */
        foreach ($attachments as $attachment) {
            $rows = $dbConnection->exec_SELECTgetRows(
                '*',
                'sys_file',
                'tx_wpimport_importid = ' . (int)$attachment->getId()
            );
            if (count($rows)) {
                $importedAttachments++;
            }
        }
        $importAttachments = false;
        if ($importedAttachments < count($attachments)) {
            $importAttachments = true;
        }
        $this->view->assign('attachments', $attachments);
        $this->view->assign('importedAttachments', $importedAttachments);
        $this->view->assign('importAttachments', $importAttachments);

        // Check Pages
        $pages = $this->pageRepository->findAll();
        $importedPages = 0;
        /** @var Page $page */
        foreach ($pages as $page) {
            $rows = $dbConnection->exec_SELECTgetRows(
                '*',
                'pages',
                'tx_wpimport_importid = ' . (int)$page->getId()
            );
            if (count($rows)) {
                $importedPages++;
            }
        }
        $importPages = false;
        if ($importedPages < count($pages)) {
            $importPages = true;
        }
        $this->view->assign('pages', $pages);
        $this->view->assign('importedPages', $importedPages);
        $this->view->assign('importPages', $importPages);

        //$tags = $this->tagRepository->findAll();
        //$posts = $this->postRepository->findAll();
        //$this->view->assign('tags', $this->tagRepository->findAll());
        //$this->view->assign('posts', $this->postRepository->findAll());
    }

    /**
     * @param string $type
     */
    public function importAction($type)
    {
        $this->init();
        switch ($type) {
            case 'categories':
                $categories = $this->categoryRepository->findAll();
                /** @var Category $category */
                foreach ($categories as $category) {
                    $this->importCategory($category);
                }
                $this->addFlashMessage('Categories imported', 'Successfully imported');
                break;
        }
        $this->forward('index');
    }

    /**
     * @param Category $category
     *
     * @return array|NULL
     */
    protected function importCategory(Category $category)
    {
        $dbConnection = $this->getDatabaseConnection();
        $rows = $dbConnection->exec_SELECTgetRows(
            '*',
            'sys_category',
            'tx_wpimport_importid = ' . (int)$category->getId()
        );
        if (count($rows) === 0) {
            $parentId = 0;
            if ($category->getParent() !== '') {
                $parentCategory = $this->categoryRepository->findByNicename($category->getParent());
                if ($parentCategory instanceof Category) {
                    $parentDbCategory = $dbConnection->exec_SELECTgetRows(
                        '*',
                        'sys_category',
                        'tx_wpimport_importid = ' . (int)$parentCategory->getId()
                    );
                    if (count($parentDbCategory)) {
                        $parentId = $parentDbCategory[0]['uid'];
                    } else {
                        $parentRecord = $this->importCategory($parentCategory);
                        $parentId = $parentRecord['uid'];
                    }
                }
            }
            $dbConnection->exec_INSERTquery(
                'sys_category',
                [
                    'tx_wpimport_importid' => $category->getId(),
                    'tstamp' => time(),
                    'crdate' => time(),
                    'cruser_id' => $GLOBALS['BE_USER']->user['uid'],
                    'title' => $category->getTitle(),
                    'parent' => $parentId,
                    'description' => $category->getDescription()
                ]
            );
            $record = $dbConnection->exec_SELECTgetRows(
                '*',
                'sys_category',
                'tx_wpimport_importid = ' . (int)$category->getId()
            );
        } else {
            $record = $rows[0];
        }
        return $record;
    }

    /**
     *
     */
    protected function init()
    {
        $importFile = GeneralUtility::getFileAbsFileName(
            GeneralUtility::getFileAbsFileName('EXT:wpimport/Resources/Private/Xml/wp_export.xml')
        );
        $this->view->assign('importFile', $importFile);

        $xmlContent = file_get_contents($importFile);
        $previousValueOfEntityLoader = libxml_disable_entity_loader(true);
        $rootXmlNode = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOWARNING);
        libxml_disable_entity_loader($previousValueOfEntityLoader);

        // Extract categories
        $this->categoryRepository = GeneralUtility::makeInstance(CategoryRepository::class, $rootXmlNode);

        // Extract tags
        $this->tagRepository = GeneralUtility::makeInstance(TagRepository::class, $rootXmlNode);

        // Extract pages
        $this->pageRepository = GeneralUtility::makeInstance(PageRepository::class, $rootXmlNode);

        // Extract posts
        $this->postRepository = GeneralUtility::makeInstance(PostRepository::class, $rootXmlNode);

        // Extract attachments
        $this->attachmentRepository = GeneralUtility::makeInstance(AttachmentRepository::class, $rootXmlNode);
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
