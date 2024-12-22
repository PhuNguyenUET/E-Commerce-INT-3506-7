<?php


namespace AndPhone\CurrencyExchange\Observer;
    use Magento\Framework\Event\Observer as EventObserver;
    use Magento\Framework\Data\Tree\Node;
    use Magento\Framework\Event\ObserverInterface;

    class Topmenu implements ObserverInterface
    {
        public function __construct()
        {
        }

        public function execute(EventObserver $observer)
        {
            $menu = $observer->getMenu();
            $tree = $menu->getTree();
            $data = ['name' => __('Currency Exchange'),
                'id' => 'currency_exchange',
                'url' => 'http://andphone.xyz/currencyexchange/index/index',
                'is_active' => false];
            $node = new Node($data, 'id', $tree, $menu);
            $menu->addChild($node);
            return $this;
        }
    }
