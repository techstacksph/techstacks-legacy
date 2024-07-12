<?php

namespace Techstacks\Legacy\Block\Adminhtml\ListingFee;

use Magento\Config\Block\System\Config\Form\Field;

class ListingFee extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Techstacks_Legacy::listing-fee.phtml';

    /**
     * @return string
     */
    public function getSellersCollection(): string
    {
        return 'test';
    }
}
