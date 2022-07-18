<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DisposableVape Entity
 *
 * @property int $disposable_vape_id
 * @property string $disposable_vape_brand
 * @property string $disposable_vape_variant
 * @property int $disposable_vape_box_size
 * @property float $disposable_vape_price
 * @property float $disposable_vape_price_for_3
 * @property float $disposable_vape_wholesale_price
 * @property string|null $disposable_vape_description
 */
class DisposableVape extends Entity
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
        'disposable_vape_brand' => true,
        'disposable_vape_variant' => true,
        'disposable_vape_box_size' => true,
        'disposable_vape_price' => true,
        'disposable_vape_price_for_3' => true,
        'disposable_vape_wholesale_price' => true,
        'disposable_vape_description' => true,
    ];
}
