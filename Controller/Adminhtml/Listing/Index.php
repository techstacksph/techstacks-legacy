<?php
/**
 * Copyright © 2024. Techstacks Ph All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Techstacks\Legacy\Controller\Adminhtml\Listing;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'Techstacks_Legacy::legacy';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Load the page defined in view/adminhtml/layout/legacy_listing_index.xml
     *
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create()
            ->setActiveMenu(static::MENU_ID)
            ->getConfig()->getTitle()->prepend(__('Techstacks'));
    }
}
