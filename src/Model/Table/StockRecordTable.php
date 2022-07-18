<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StockRecord Model
 *
 * @property \App\Model\Table\VapeFlavorsTable&\Cake\ORM\Association\BelongsTo $VapeFlavors
 *
 * @method \App\Model\Entity\StockRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\StockRecord newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StockRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StockRecord|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StockRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StockRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StockRecord[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StockRecord findOrCreate($search, callable $callback = null, $options = [])
 */
class StockRecordTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('stock_record');
        $this->setDisplayField('stock_record_id');
        $this->setPrimaryKey('stock_record_id');

        $this->belongsTo('VapeFlavors', [
            'foreignKey' => 'vape_flavors_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('stock_record_id')
            ->allowEmptyString('stock_record_id', null, 'create')
            ->add('stock_record_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->numeric('stock_record_price')
            ->requirePresence('stock_record_price', 'create')
            ->notEmptyString('stock_record_price');

        $validator
            ->integer('stock_record_quantity')
            ->requirePresence('stock_record_quantity', 'create')
            ->notEmptyString('stock_record_quantity');

        $validator
            ->integer('stock_record_stock_current')
            ->requirePresence('stock_record_stock_current', 'create')
            ->notEmptyString('stock_record_stock_current');

        $validator
            ->scalar('stock_record_time')
            ->maxLength('stock_record_time', 255)
            ->requirePresence('stock_record_time', 'create')
            ->notEmptyString('stock_record_time');

        $validator
            ->scalar('stock_record_comment')
            ->maxLength('stock_record_comment', 5555)
            ->requirePresence('stock_record_comment', 'create')
            ->notEmptyString('stock_record_comment');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['stock_record_id']));
        $rules->add($rules->existsIn(['vape_flavors_id'], 'VapeFlavors'));

        return $rules;
    }
}
