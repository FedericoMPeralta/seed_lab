<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MuestrasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('muestras');
        $this->setDisplayField('codigo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'fecha_recepcion' => 'new',
                    'fecha_modificacion' => 'always'
                ]
            ]
        ]);
        
        $this->addBehavior('CodigoGenerator');

        $this->hasMany('Resultados', [
            'foreignKey' => 'muestra_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('numero_precinto')
            ->maxLength('numero_precinto', 255)
            ->requirePresence('numero_precinto', 'create')
            ->notEmptyString('numero_precinto')
            ->add('numero_precinto', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('empresa')
            ->maxLength('empresa', 255)
            ->allowEmptyString('empresa');

        $validator
            ->scalar('especie')
            ->maxLength('especie', 255)
            ->allowEmptyString('especie');

        $validator
            ->nonNegativeInteger('cantidad_semillas')
            ->allowEmptyString('cantidad_semillas');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['codigo']), ['errorField' => 'codigo']);
        $rules->add($rules->isUnique(['numero_precinto']), ['errorField' => 'numero_precinto']);

        return $rules;
    }
}