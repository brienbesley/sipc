<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{

    protected $table = 'staff_tbl';
    protected $primaryKey = 'id';
    protected $allowedFields = ['first_name', 'last_name', 'email', 'phone_number', 'department_id'];

    public function insert_staff($data)
    {
        $this->insert($data);
        return $this->insertID();
    }

    public function select_staff()
    {
        $this->select('staff_tbl.*, department_tbl.department_name')
            ->join('department_tbl', 'department_tbl.id = staff_tbl.department_id')
            ->orderBy('staff_tbl.id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }

    public function select_staff_byID($id)
    {
        $this->select('staff_tbl.*, department_tbl.department_name')
            ->join('department_tbl', 'department_tbl.id = staff_tbl.department_id')
            ->where('staff_tbl.id', $id);
        $query = $this->get();
        return $query->getRowArray();
    }

    public function select_staff_byEmail($email)
    {
        $query = $this->where('email', $email)->get();
        return $query->getRowArray();
    }

    public function select_staff_byDept($dpt)
    {
        $this->select('staff_tbl.*, department_tbl.department_name')
            ->join('department_tbl', 'department_tbl.id = staff_tbl.department_id')
            ->where('staff_tbl.department_id', $dpt);
        $query = $this->get();
        return $query->getResultArray();
    }

    public function delete_staff($id)
    {
        $this->where('id', $id)->delete();
        return $this->affectedRows();
    }

    public function update_staff($data, $id)
    {
        $this->where('id', $id)->set($data)->update();
        return $this->affectedRows();
    }
}
