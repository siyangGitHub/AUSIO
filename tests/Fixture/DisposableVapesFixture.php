<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DisposableVapesFixture
 */
class DisposableVapesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'disposable_vape_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'disposable_vape_brand' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'disposable_vape_variant' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'disposable_vape_box_size' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'disposable_vape_price' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'disposable_vape_price_for_3' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'disposable_vape_wholesale_price' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'disposable_vape_description' => ['type' => 'string', 'length' => 5555, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['disposable_vape_id'], 'length' => []],
            'disposable_vape_disposable_vape_id_uindex' => ['type' => 'unique', 'columns' => ['disposable_vape_id'], 'length' => []],
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
                'disposable_vape_id' => 1,
                'disposable_vape_brand' => 'Lorem ipsum dolor sit amet',
                'disposable_vape_variant' => 'Lorem ipsum dolor sit amet',
                'disposable_vape_box_size' => 1,
                'disposable_vape_price' => 1,
                'disposable_vape_price_for_3' => 1,
                'disposable_vape_wholesale_price' => 1,
                'disposable_vape_description' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
