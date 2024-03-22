<?php

namespace Model;

use Exception;
use ReflectionClass;

class ProductFactory
{
    public function productSave($body)
    {
        $productType = $body['product_type'];        
        $className = 'Model\\' . ucfirst($productType);

        if (!class_exists($className)) {
            throw new Exception("Product type " . $productType . " not found.");
        }

        $reflectionClass = new ReflectionClass($className);
        $product = $reflectionClass->newInstance($body);
        
        return $product->post($product);
    }
}