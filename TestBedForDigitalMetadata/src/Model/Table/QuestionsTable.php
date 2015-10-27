<?php
namespace App\Model\Table;

use App\Model\Entity\Question;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class QuestionsTable extends Table
{

    
    public function initialize(array $config)
    {
        $this->table('questions');
        $this->displayField('name');
        $this->primaryKey('id');
        
        $this->hasMany("options");
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        return $validator;
    }
}

