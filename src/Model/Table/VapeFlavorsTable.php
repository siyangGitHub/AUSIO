<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VapeFlavors Model
 *
 * @property \App\Model\Table\DisposableVapesTable&\Cake\ORM\Association\BelongsTo $DisposableVapes
 *
 * @method \App\Model\Entity\VapeFlavor get($primaryKey, $options = [])
 * @method \App\Model\Entity\VapeFlavor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VapeFlavor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VapeFlavor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VapeFlavor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VapeFlavor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VapeFlavor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VapeFlavor findOrCreate($search, callable $callback = null, $options = [])
 */
class VapeFlavorsTable extends Table
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

        $this->setTable('vape_flavors');
        $this->setDisplayField('vape_flavors_id');
        $this->setPrimaryKey('vape_flavors_id');

        $this->belongsTo('DisposableVapes', [
            'foreignKey' => 'disposable_vape_id',
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
            ->integer('vape_flavors_id')
            ->allowEmptyString('vape_flavors_id', null, 'create')
            ->add('vape_flavors_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('vape_flavors_name')
            ->maxLength('vape_flavors_name', 255)
            ->requirePresence('vape_flavors_name', 'create')
            ->notEmptyString('vape_flavors_name');

        $validator
            ->integer('vape_stock')
            ->notEmptyString('vape_stock');

        $validator
            ->scalar('vape_image')
            ->maxLength('vape_image', 255)
            ->allowEmptyFile('vape_image');

        $validator
            ->integer('vape_status')
            ->notEmptyString('vape_status');

        $validator
            ->scalar('vape_image_color')
            ->maxLength('vape_image_color', 255)
            ->allowEmptyFile('vape_image_color');

        $validator
            ->integer('vape_sold')
            ->notEmptyString('vape_sold');

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
        $rules->add($rules->isUnique(['vape_flavors_id']));
        $rules->add($rules->existsIn(['disposable_vape_id'], 'DisposableVapes'));

        return $rules;
    }
}
