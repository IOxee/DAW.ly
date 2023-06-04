<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'role_id'];

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

    public function getRolesByUserId($id)
    {
        $builder = $this->db->table('groups');
        $builder->select('groups.user_id, groups.role_id, roles.name, roles.level');
        $builder->join('roles', 'roles.id = groups.role_id');
        $builder->where('groups.user_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    public function getMaxRole($id)
    {
        // SELECT MAX(r.level) AS max_level FROM groups g JOIN roles r ON g.role_id = r.id WHERE g.user_id = 1 AND g.deleted_at IS NULL AND r.deleted_at IS NULL;
        $builder = $this->db->table('groups');
        $builder->select('MAX(r.level) AS max_level');
        $builder->join('roles r', 'groups.role_id = r.id');
        $builder->where('groups.user_id', $id);
        $builder->where('groups.deleted_at', null);
        $builder->where('r.deleted_at', null);
        $query = $builder->get();
        return $query->getRowArray()['max_level'];
    }

    public function getAllRoles()
    {
        $builder = $this->db->table('roles');
        $builder->select('roles.id, roles.name, roles.level');
        $builder->orderBy('roles.level', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function isInGroup($id, $role)
    {
        $builder = $this->db->table('groups');
        $builder->select('groups.user_id, groups.role_id, roles.name, roles.level');
        $builder->join('roles', 'roles.id = groups.role_id');
        $builder->where('groups.user_id', $id);
        $builder->where('groups.role_id', $role);
        $query = $builder->get();
        return $query->getRowArray();
    }
}
