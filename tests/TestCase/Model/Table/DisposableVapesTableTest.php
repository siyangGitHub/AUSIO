<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DisposableVapesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DisposableVapesTable Test Case
 */
class DisposableVapesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DisposableVapesTable
     */
    public $DisposableVapes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DisposableVapes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DisposableVapes') ? [] : ['className' => DisposableVapesTable::class];
        $this->DisposableVapes = TableRegistry::getTableLocator()->get('DisposableVapes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DisposableVapes);

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
