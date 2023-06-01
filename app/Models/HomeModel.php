<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{

    public function logindata($un, $pw)
    {
        $builder = $this->db->table('login_tbl');
        $builder->where('username', $un);
        $builder->where('password', $pw);
        $qry = $builder->get();
        if ($qry->getNumRows() > 0) {
            $result = $qry->getResultArray();
            return $result;
        }
    }

    public function insert_login($data)
    {
        $builder = $this->db->table('login_tbl');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function delete_login_byID($id)
    {
        $builder = $this->db->table('login_tbl');
        $builder->where('id', $id);
        $builder->delete();
        return $this->db->affectedRows();
    }
}
