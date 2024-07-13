<?php
/**
 * Copyright © 2024. Techstacks Ph All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Techstacks\Legacy\Block\Adminhtml\ListingFee;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\BlockInterface;
use Magetop\Marketplace\Model\ResourceModel\Sellers\Collection;
use Magetop\Marketplace\Model\ResourceModel\Sellers\CollectionFactory as SellerCollectionFactory;

class ListingFee extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'Techstacks_Legacy::listing-fee.phtml';

    /**
     * @var SellerCollectionFactory
     */
    protected $sellersCollectionFactory;

    /**
     * @param Context $context
     * @param SellerCollectionFactory $sellersCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        SellerCollectionFactory $sellersCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellersCollectionFactory = $sellersCollectionFactory;
    }

    /**
     * @return Collection
     */
    public function getSellersCollection()
    {
        return $this->sellersCollectionFactory->create();
    }
}
