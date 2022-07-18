<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $order_id
 * @property string $order_customer
 * @property string $order_time
 * @property string $order_detail
 * @property string $order_comment
 * @property int $order_is_complete
 */
class Order extends Entity
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
        'order_customer' => true,
        'order_time' => true,
        'order_detail' => true,
        'order_comment' => true,
        'order_is_complete' => true,
    ];
}
