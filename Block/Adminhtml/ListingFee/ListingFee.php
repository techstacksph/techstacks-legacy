<?php

namespace Techstacks\Legacy\Block\Adminhtml\ListingFee;

use Magento\Framework\View\Element\Template;

class ListingFee extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Techstacks_Legacy::listing-fee.phtml';

    /**
     * @return array
     */
    public function getSellersCollection(): array
    {
        return ['name' => 'Juan', 'age' => 32];
    }
}
