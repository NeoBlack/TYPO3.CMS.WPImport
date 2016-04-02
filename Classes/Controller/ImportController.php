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
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
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
     *
     */
    public function indexAction()
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Wpimport/ImportWizard');

        $importFile = GeneralUtility::getFileAbsFileName(
            GeneralUtility::getFileAbsFileName('EXT:wpimport/Resources/Private/Xml/wp_export.xml')
        );
        $this->view->assign('importFile', $importFile);

        $xmlContent = file_get_contents($importFile);
        $previousValueOfEntityLoader = libxml_disable_entity_loader(true);
        $rootXmlNode = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOWARNING);
        libxml_disable_entity_loader($previousValueOfEntityLoader);

        // Extract categories
        $categoryRepository = GeneralUtility::makeInstance(CategoryRepository::class, $rootXmlNode);
        $this->view->assign('categories', $categoryRepository->findAll());

        // Extract tags
        $tagRepository = GeneralUtility::makeInstance(TagRepository::class, $rootXmlNode);
        $this->view->assign('tags', $tagRepository->findAll());

        // Extract pages
        $pageRepository = GeneralUtility::makeInstance(PageRepository::class, $rootXmlNode);
        $this->view->assign('pages', $pageRepository->findAll());

        // Extract posts
        $postRepository = GeneralUtility::makeInstance(PostRepository::class, $rootXmlNode);
        $this->view->assign('posts', $postRepository->findAll());

        // Extract attachments
        $attachmentRepository = GeneralUtility::makeInstance(AttachmentRepository::class, $rootXmlNode);
        $this->view->assign('attachments', $attachmentRepository->findAll());
    }
}
