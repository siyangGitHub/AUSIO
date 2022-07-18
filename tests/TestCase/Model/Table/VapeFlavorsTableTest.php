<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VapeFlavorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VapeFlavorsTable Test Case
 */
class VapeFlavorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VapeFlavorsTable
     */
    public $VapeFlavors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VapeFlavors',
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
        $config = TableRegistry::getTableLocator()->exists('VapeFlavors') ? [] : ['className' => VapeFlavorsTable::class];
        $this->VapeFlavors = TableRegistry::getTableLocator()->get('VapeFlavors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VapeFlavors);

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
