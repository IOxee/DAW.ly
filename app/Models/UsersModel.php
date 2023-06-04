<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'email', 'activated'];

    // Dates
    protected $useTimestamps = true;
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


    public function updateUserById($id, $data)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        $builder->update($data);
        return $this->db->affectedRows();
    }

    public function getAllDataById($id)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    public function getAllData()
    {
        $builder = $this->db->table('users');
        return $builder->get()->getResultArray();
    }

    public function getInsertID()
    {
        return $this->db->insertID();
    }

    public function updateByMail($email, $data)
    {
        $builder = $this->db->table('users');
        $builder->where('email', $email);
        $builder->update($data);
        return $this->db->affectedRows();
    }

    public function getPassword($id)
    {
        $builder = $this->db->table('users');
        $builder->select('password');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    public function isAccountActivated($id)
    {
        $builder = $this->db->table('users');
        $builder->select('activated');
        $builder->where('id', $id);
        if ($builder->get()->getRowArray()['activated'] == 1) {
            return true;
        } else {
            return false;
        }
    }
}

