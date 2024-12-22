<?php

namespace Know\Module\Api;

interface CustomApiInterface
{

    /**
     * Get all products.
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getAllProducts();

    /**
     * Get product by id.
     * @param int $id
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProduct(int $id);

    /**
     * Get all categories
     *
     * @return array
     */
    public function getAllCategories();

    /**
     * Get all products of a category by category ID
     *
     * @param int $id
     * @return array
     */
    public function getProductsByCategory(int $id);
}
