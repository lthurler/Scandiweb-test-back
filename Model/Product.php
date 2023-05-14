<?php

namespace Model;

use Service\DAO;
use PDOException;
use Exception;
use JsonException;



abstract class Product
{

    protected $product_id;
    protected $sku;
    protected $name;
    protected $price;
    protected $product_type;
    protected $active = true;


    public function add($product)
    {
    }

    public static function getAll()
    {

        try {

            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "SELECT 
                        product_id,
                        sku, 
                        name, 
                        price, 
                        product_type,
                        size AS Size,
                        weight AS Weight,
                        CONCAT(height, 'x', width, 'x', length) AS Dimension                       
                    FROM product p
                    WHERE p.active = true;";

            $stman = $conn->prepare($sql);
            $stman->execute();
            $return = $stman->fetchAll();

            return $return;

        } catch (PDOException $pdoe) {
            throw new Exception("Error executing command on database!" . $pdoe->getMessage());

        } catch (JsonException $jsone) {
            throw new Exception("Error while assembling the json" . $jsone->getMessage());

        } catch (Exception $e) {
            throw new Exception("Error listing all users" . $e->getMessage());
        }
    }

    public static function delete($body)
    {

        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $ids = implode(',', array_fill(0, count($body['product_id']), '?'));
            $sql = "UPDATE product SET active = false WHERE product_id IN ($ids)";
            $stman = $conn->prepare($sql);
            $stman->execute($body['product_id']);

            return $stman->rowCount();

        } catch (PDOException $pdoe) {
            throw new Exception("Error executing command on database!" . $pdoe->getMessage());

        } catch (JsonException $jsone) {
            throw new Exception("Error while decoding JSON" . $jsone->getMessage());

        } catch (Exception $e) {
            throw new Exception("Error deleting products" . $e->getMessage());
        }
    }
}