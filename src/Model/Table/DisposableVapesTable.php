<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DisposableVapes Model
 *
 * @method \App\Model\Entity\DisposableVape get($primaryKey, $options = [])
 * @method \App\Model\Entity\DisposableVape newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DisposableVape[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DisposableVape|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DisposableVape saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DisposableVape patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DisposableVape[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DisposableVape findOrCreate($search, callable $callback = null, $options = [])
 */
class DisposableVapesTable extends Table
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

        $this->setTable('disposable_vapes');
        $this->setDisplayField('disposable_vape_id');
        $this->setPrimaryKey('disposable_vape_id');

        $this->hasMany('VapeFlavors')
            ->setForeignKey('disposable_vape_id')
            ->setDependent(true);
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
            ->integer('disposable_vape_id')
            ->allowEmptyString('disposable_vape_id', null, 'create')
            ->add('disposable_vape_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('disposable_vape_brand')
            ->maxLength('disposable_vape_brand', 255)
            ->requirePresence('disposable_vape_brand', 'create')
            ->notEmptyString('disposable_vape_brand');

        $validator
            ->scalar('disposable_vape_variant')
            ->maxLength('disposable_vape_variant', 255)
            ->requirePresence('disposable_vape_variant', 'create')
            ->notEmptyString('disposable_vape_variant');

        $validator
            ->integer('disposable_vape_box_size')
            ->notEmptyString('disposable_vape_box_size');

        $validator
            ->numeric('disposable_vape_price')
            ->notEmptyString('disposable_vape_price');

        $validator
            ->numeric('disposable_vape_price_for_3')
            ->notEmptyString('disposable_vape_price_for_3');

        $validator
            ->numeric('disposable_vape_wholesale_price')
            ->notEmptyString('disposable_vape_wholesale_price');

        $validator
            ->scalar('disposable_vape_description')
            ->maxLength('disposable_vape_description', 5555)
            ->allowEmptyString('disposable_vape_description');

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
        $rules->add($rules->isUnique(['disposable_vape_id']));

        return $rules;
    }
}
