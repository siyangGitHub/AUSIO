<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StockRecordTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StockRecordTable Test Case
 */
class StockRecordTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StockRecordTable
     */
    public $StockRecord;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StockRecord',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StockRecord') ? [] : ['className' => StockRecordTable::class];
        $this->StockRecord = TableRegistry::getTableLocator()->get('StockRecord', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StockRecord);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
