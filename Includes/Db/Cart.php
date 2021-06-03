<?php
namespace Includes\Db;

use Includes\Helpers\User;

class Cart extends Query
{
    protected $userId;
    protected $items = [];

    public function __construct()
    {
        parent::__construct();
        $this->userId = User::getCurrentUserId();
        $this->setItems();
        $this->setCookie();
    }
    
    public function getItems()
    {
        return $this->items;
    }

    public function setItems()
    {
        if (isset($_COOKIE['cart_items']) && !empty($_COOKIE['cart_items'])) {
            $this->items = unserialize($_COOKIE['cart_items']);
        } else {
            $this->items = $this->getUseritems();
        }
    }

    protected function getUseritems()
    {
        $items = $_SESSION['user_data']['cart_items'];
        if (!empty($items)) {
            return unserialize($items);
        }
        return array();
    }
    
    public function addItem($newItem)
    {
        $items = $this->getItems();
        $flag = true;   
        foreach ($items as $key => $item) {
            if ($item['product_id'] === $newItem['product_id']) {
                $items[$key]['qty'] = $item['qty'] + intval($newItem['qty']);
                $flag = false;
                break;
            }
        }
        if ($flag) {
            array_push($items, $newItem);
        }
        $this->items = $items;
        $this->setCookie();
    }

    public function removeItem($productId)
    {
        $items = $this->getItems();
        $items = array_filter(
            $items,
            function ($value) use ($productId) {
                return $value['product_id'] != $productId;
            }
        );
        $this->items = $items;
        $this->setCookie();
    }

    public function updateItem($productDatas)
    {
        $this->items = $productDatas;
        $this->setCookie();
    }

    protected function setCookie()
    {
        $value = serialize($this->items);
        setcookie('cart_items', $value, time() + (86400 * 30), "/");
    }

    public function clearitems()
    {
        $this->items = [];
        $this->setCookie();
    }
}
