<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockRecord Entity
 *
 * @property int $stock_record_id
 * @property int $vape_flavors_id
 * @property int $stock_record_price
 * @property int $stock_record_quantity
 * @property string $stock_record_time
 * @property string $stock_record_comment
 *
 * @property \App\Model\Entity\VapeFlavor $vape_flavor
 */
class StockRecord extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'vape_flavors_id' => true,
        'stock_record_price' => true,
        'stock_record_quantity' => true,
        'stock_record_stock_current' => true,
        'stock_record_time' => true,
        'stock_record_comment' => true,
        'vape_flavor' => true,
    ];
}
