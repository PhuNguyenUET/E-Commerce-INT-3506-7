<?php

namespace AndPhone\YourApi\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class ApiIndex extends Template
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
