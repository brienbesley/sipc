<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{

    protected $table = 'department_tbl';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];

    public function insert_department($data)
    {
        $this->insert($data);
        return $this->insertID();
    }

    public function select_departments()
    {
        $qry = $this->db->table($this->table)->get();
        if ($qry->getNumRows() > 0) {
            $result = $qry->getResultArray();
            return $result;
        }
    }

    public function select_department_byID($id)
    {
        $qry = $this->db->table($this->table)->where('id', $id)->get();
        if ($qry->getNumRows() > 0) {
            $result = $qry->getResultArray();
            return $result;
        }
    }

    public function delete_department($id)
    {
        $this->db->table($this->table)->where('id', $id)->delete();
        return $this->db->affectedRows();
    }

    public function update_department($data, $id)
    {
        $this->db->table($this->table)->where('id', $id)->update($data);
        return $this->db->affectedRows();
    }
}
