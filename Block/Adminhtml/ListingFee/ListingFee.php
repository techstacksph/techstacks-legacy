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
use Magetop\Marketplace\Model\ResourceModel\Products\Collection as ProductCollection;
use Magetop\Marketplace\Model\ResourceModel\Products\CollectionFactory as ProductsCollectionFactory;

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
     * @var ProductsCollectionFactory
     */
    protected $productsCollectionFactory;

    /**
     * @param Context $context
     * @param SellerCollectionFactory $sellersCollectionFactory
     * @param ProductsCollectionFactory $productsCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        SellerCollectionFactory $sellersCollectionFactory,
        ProductsCollectionFactory $productsCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellersCollectionFactory = $sellersCollectionFactory;
        $this->productsCollectionFactory = $productsCollectionFactory;
    }

    /**
     * @return Collection
     */
    public function getSellersCollection()
    {
        return $this->sellersCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('userstatus','1');
    }

    /**
     * @return int
     */
    public function getProductsCollection($sellerId = '') {
      return $this->productsCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status','1')
            ->addFieldToFilter('user_id', $sellerId)
            ->count();
    }
}
