<?php
namespace Includes\Db;

class Item extends Query
{
    public function mergeItemWithProducts($items)
    {
        if (empty($items)) {
            return array();
        }
        $productIds =array();

        foreach ($items as $item) {
            $productIds = [...$productIds, $item['product_id']];
        }
        sort($productIds);
        $productIds = implode(',', $productIds);
        $sql = "SELECT `id`,`name`,`image`,`amount`, `stock` FROM `products` WHERE `id` IN($productIds)";
        $result = $this->rawQuery($sql);
        while ($row = $result->fetch_assoc()) {
            foreach ($items as $key => $value) {
                if ($row['id'] == $value['product_id']) {
                    $items[$key]['product_data'] = $row;
                    break;
                }
            }
        }
        return $items;
    }
}
