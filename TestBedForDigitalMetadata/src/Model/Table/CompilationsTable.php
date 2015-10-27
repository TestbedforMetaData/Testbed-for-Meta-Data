<?php
namespace App\Model\Table;

use App\Model\Entity\Compilation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CompilationsTable extends Table
{

    
    public function initialize(array $config)
    {
        $this->table('compilations');
        $this->displayField('text');
        $this->primaryKey('id');
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        return $validator;
    }
}

