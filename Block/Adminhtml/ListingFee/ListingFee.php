<?php
/**
 * Copyright © 2024. Techstacks Ph All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Techstacks\Legacy\Block\Adminhtml\ListingFee;

use DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\BlockInterface;
use Magetop\Marketplace\Model\ResourceModel\Sellers\Collection;
use Magetop\Marketplace\Model\ResourceModel\Sellers\CollectionFactory as SellerCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as MageProductCollectionFactory;
use Magetop\Marketplace\Model\ResourceModel\Products\CollectionFactory as ProductsCollectionFactory;
use Psr\Log\LoggerInterface;

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
     * @var MageProductCollectionFactory
     */
    protected $mageProductCollectionFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param SellerCollectionFactory $sellersCollectionFactory
     * @param ProductsCollectionFactory $productsCollectionFactory
     * @param MageProductCollectionFactory $mageProductCollectionFactory
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context $context,
        SellerCollectionFactory $sellersCollectionFactory,
        ProductsCollectionFactory $productsCollectionFactory,
        MageProductCollectionFactory $mageProductCollectionFactory,
        LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellersCollectionFactory = $sellersCollectionFactory;
        $this->productsCollectionFactory = $productsCollectionFactory;
        $this->mageProductCollectionFactory = $mageProductCollectionFactory;
        $this->logger = $logger;
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
    public function getTotalActiveProductsBySellerId($sellerId = '') {
      return $this->productsCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status','1')
            ->addFieldToFilter('user_id', $sellerId)
            ->count();
    }

    /**
     * @param $id
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getPriceById($id)
    {
        $price = $this->mageProductCollectionFactory->create()
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('update_at')
            ->addAttributeToFilter('entity_id', $id);

        return $price->getFirstItem()->getData('price');
    }

    protected function isTwoMonthsAhead(DateTime $date): bool {
        $currentDate = new DateTime();

        $twoMonthsAhead = clone $currentDate;
        $twoMonthsAhead->modify('+2 months');

        return $date->format('Y-m') === $twoMonthsAhead->format('Y-m');
    }

    /**
     * @param $sellerId
     * @return float|int
     */
    public function getTotalListingFeeBySellerId($sellerId = '') {
        try {
            $productCollection = $this->productsCollectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter('status','1')
                ->addFieldToFilter('user_id', $sellerId);

            $priceArray = [];
            foreach ($productCollection as $product) {
                if($product->getData('created')) {
                    $created = new \DateTime($product->getData('created'));
                    if($this->isTwoMonthsAhead($created)) {
                        $priceArray[] = (float)$this->getPriceById($product->getData('product_id')) * 0.03;
                    } else {
                        $priceArray[] = (float)$this->getPriceById($product->getData('product_id')) * 0.05;
                    }
                }
            }
            return array_sum($priceArray);
        } catch (\Exception $e) {
            $this->logger->warning($e->getMessage());
            return 0;
        }
    }
}
