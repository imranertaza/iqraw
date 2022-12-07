<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class Vocabulary_readModel extends Model {
    
	protected $table = 'vocabulary_read';
	protected $primaryKey = 'voc_read_id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['voc_read_id','std_id', 'count','last_seen_date','createdDtm', 'createdBy', 'updateDtm', 'updatedBy', 'deleted', 'deletedRole'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}