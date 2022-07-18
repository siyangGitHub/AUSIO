<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VapeFlavor Entity
 *
 * @property int $vape_flavors_id
 * @property int $disposable_vape_id
 * @property string $vape_flavors_name
 * @property int $vape_stock
 * @property string|null $vape_image
 * @property int $vape_status
 * @property string|null $vape_image_color
 * @property int $vape_sold
 *
 * @property \App\Model\Entity\DisposableVape $disposable_vape
 */
class VapeFlavor extends Entity
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
        'disposable_vape_id' => true,
        'vape_flavors_name' => true,
        'vape_stock' => true,
        'vape_image' => true,
        'vape_status' => true,
        'vape_image_color' => true,
        'vape_sold' => true,
        'disposable_vape' => true,
    ];
}
