<?php

namespace Model;

use Model\DVD;
use Model\Book;
use Model\Furniture;


class ProductFactory
{
    private static $productTypes = [
        'dvd' => DVD::class,
        'book' => Book::class,
        'furniture' => Furniture::class,
    ];

    public static function productSave($body)
    {
        $className = self::$productTypes[$body['product_type']];
        $product = new $className($body);
        return $product->post($product);
    }
}