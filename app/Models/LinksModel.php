<?php

namespace App\Models;

use CodeIgniter\Model;

class LinksModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'link_code', 'link', 'text', 'description', 'clicks', 'user_id', 'publish_date', 'limit_date'  ];

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

    public function getTitle($short_link)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $short_link);
        $query = $builder->get();
        $title = $query->getRowArray();
        return $title['title'] ?? null;
    }

    public function getLink($short_link)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $short_link);
        $query = $builder->get();
        // from query i only get the long_link
        $link = $query->getRowArray();
        return $link['link'] ?? null;
    }

    public function getId($short_link)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $short_link);
        $query = $builder->get();
        $id = $query->getRowArray();
        return $id['id'] ?? null;
    }

    public function getDescription($short_link)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $short_link);
        $query = $builder->get();
        $description = $query->getRowArray();
        return $description['description'] ?? null;
    }

    public function isValid($short_link)
    {
        // publish_date < now() && limit_date > now()
        $builder = $this->db->table('links');
        $builder->where('link_code', $short_link);
        $builder->where('publish_date < now()');
        $builder->where('limit_date > now()');
        $query = $builder->get();
        $isValid = $query->getRowArray();
        if ($isValid) {
            return true;
        } else {
            return false;
        }
    }

    public function getLinksByID($id) 
    {
        $builder = $this->db->table('links');
        $builder->where('user_id', $id);
        $query = $builder->get();
        $links = $query->getResultArray();
        return $links;
    }

    public function getAllDataByCode($code)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $code);
        $query = $builder->get();
        $data = $query->getRowArray();
        return $data;
    }

    public function deleteLinkByCode($code)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $code);
        $builder->delete();
    }

    public function updateByShortLink($short_link, $data)
    {
        $builder = $this->db->table('links');
        $builder->where('link_code', $short_link);
        $builder->update($data);
        return $this->db->affectedRows();
    }
}
