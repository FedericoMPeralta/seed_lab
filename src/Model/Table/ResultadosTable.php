<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ResultadosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('resultados');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'fecha_recepcion' => 'new',
                    'fecha_modificacion' => 'always'
                ]
            ]
        ]);

        $this->belongsTo('Muestras', [
            'foreignKey' => 'muestra_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('muestra_id')
            ->notEmptyString('muestra_id');

        $validator
            ->decimal('poder_germinativo')
            ->greaterThanOrEqual('poder_germinativo', 0)
            ->lessThanOrEqual('poder_germinativo', 100)
            ->allowEmptyString('poder_germinativo');

        $validator
            ->decimal('pureza')
            ->greaterThanOrEqual('pureza', 0)
            ->lessThanOrEqual('pureza', 100)
            ->allowEmptyString('pureza');

        $validator
            ->scalar('materiales_inertes')
            ->allowEmptyString('materiales_inertes');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['muestra_id'], 'Muestras'), ['errorField' => 'muestra_id']);

        return $rules;
    }
}