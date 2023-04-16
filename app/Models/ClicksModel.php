<?php

namespace App\Models;

use CodeIgniter\Model;

class ClicksModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clicks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function addClick($link_id) 
    {
        $builder = $this->db->table('clicks');
        $builder->set('link_id', $link_id);
        $builder->set('date', date('Y-m-d H:i:s'));
        $builder->set('ip', $_SERVER['REMOTE_ADDR']);
        $builder->set('user_agent', $_SERVER['HTTP_USER_AGENT']);
        $builder->insert();
    }

    public function getClicksById($link_id)
    {
        $builder = $this->db->table('clicks');
        $builder->select('COUNT(*) as clicks, DATE(date) as date');
        $builder->where('link_id', $link_id);
        $builder->groupBy('DATE(date)');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
