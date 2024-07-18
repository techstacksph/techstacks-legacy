<?php

namespace Techstacks\Legacy\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\FilterBuilder;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Escaper;

class ProductList extends Template
{
    protected $_productCollectionFactory;
    protected $searchCriteria;
    protected $filterGroup;
    protected $filterBuilder;
    protected $productStatus;
    protected $productVisibility;
    protected $escaper;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        SearchCriteriaInterface $criteria,
        FilterGroup $filterGroup,
        FilterBuilder $filterBuilder,
        Status $productStatus,
        Visibility $productVisibility,
        Escaper $escaper,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->searchCriteria = $criteria;
        $this->filterGroup = $filterGroup;
        $this->filterBuilder = $filterBuilder;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->escaper = $escaper;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addFieldToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
                   ->addFieldToFilter('visibility', ['in' => $this->productVisibility->getVisibleInSiteIds()]);
        return $collection;
    }

    public function getEscaper()
    {
        return $this->escaper;
    }
}
