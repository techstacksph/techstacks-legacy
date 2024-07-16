<?php
namespace Techstacks\Legacy\Block\Adminhtml\ListingFee;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magetop\Marketplace\Model\ResourceModel\Sellers\CollectionFactory as SellerCollectionFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class ListingFee extends Template
{
    protected $_template = 'Techstacks_Legacy::listing-fee.phtml';
    protected $sellersCollectionFactory;
    protected $productRepository;
    protected $productFactory;
    protected $searchCriteriaBuilder;
    protected $productCollectionFactory;

    public function __construct(
        Context $context,
        SellerCollectionFactory $sellersCollectionFactory,
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductCollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellersCollectionFactory = $sellersCollectionFactory;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function getSellersCollection()
    {
        return $this->sellersCollectionFactory->create();
    }

    public function getProductNamesBySeller($sellerId)
    {
        try {
            $productCollection = $this->productCollectionFactory->create();
            $productCollection->addAttributeToFilter('seller_id', $sellerId);
            $productNames = [];
            foreach ($productCollection as $product) {
                $productNames[] = $product->getName();
            }
            return implode(', ', $productNames);
        } catch (\Exception $e) {
            return 'Error fetching products'; // Handle error if necessary
        }
    }
}
