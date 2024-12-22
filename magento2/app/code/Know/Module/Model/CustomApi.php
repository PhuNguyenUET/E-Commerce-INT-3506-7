<?php

namespace Know\Module\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaBuilder;
//use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
//use Magento\Framework\Api\FilterBuilder;

class CustomApi implements \Know\Module\Api\CustomApiInterface
{
    protected $productRepository;
    protected $collectionFactory;
    protected $productCollectionFactory;
    protected $searchCriteriaBuilder;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory,
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    /**
     * @inerhitDoc
     */
    public function getAllProducts()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $productList = $this->productRepository->getList($searchCriteria);

        return $productList->getItems();
    }

    /**
     * @inheritDoc
     */
    public function getProduct(int $id)
    {
        try {
            return $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Product with ID "%1" does not exist.', $id));
        }
    }

    /**
     * @inheirtDoc
     */
    public function getAllCategories()
    {
        $collection = $this->collectionFactory->create();

        $collection->addAttributeToSelect(['entity_id', 'name', 'is_active', 'parent_id', 'level']);

        $categories = [];
        foreach ($collection as $category) {
            $categories[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'is_active' => $category->getIsActive(),
                'parent_id' => $category->getParentId(),
                'level' => $category->getLevel(),
            ];
        }

        return $categories;
    }

    /**
     * @inerhitDoc
     */
    public function getProductsByCategory(int $id)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addCategoriesFilter(['in' => $id]);

        return $collection->toArray();
    }
}
