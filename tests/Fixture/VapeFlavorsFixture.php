<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VapeFlavorsFixture
 */
class VapeFlavorsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'vape_flavors_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'disposable_vape_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vape_flavors_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'vape_stock' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vape_image' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'vape_status' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vape_image_color' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '#000000', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'vape_sold' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'vape_flavors_disposable_vapes_disposable_vape_id_fk' => ['type' => 'index', 'columns' => ['disposable_vape_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['vape_flavors_id'], 'length' => []],
            'vape_flavors_vape_flavors_id_uindex' => ['type' => 'unique', 'columns' => ['vape_flavors_id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'vape_flavors_id' => 1,
                'disposable_vape_id' => 1,
                'vape_flavors_name' => 'Lorem ipsum dolor sit amet',
                'vape_stock' => 1,
                'vape_image' => 'Lorem ipsum dolor sit amet',
                'vape_status' => 1,
                'vape_image_color' => 'Lorem ipsum dolor sit amet',
                'vape_sold' => 1,
            ],
        ];
        parent::init();
    }
}
