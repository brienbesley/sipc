<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model
{
    protected $table = 'leave_tbl';

    protected $allowedFields = ['staff_id', 'start_date', 'end_date', 'reason', 'status'];

    public function insert_leave($data)
    {
        $this->insert($data);
        return $this->insertID();
    }

    public function select_leave()
    {
        return $this->select('leave_tbl.*,staff_tbl.pic,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name')
            ->orderBy('leave_tbl.id', 'DESC')
            ->join('staff_tbl', 'staff_tbl.id=leave_tbl.staff_id')
            ->join('department_tbl', 'department_tbl.id=staff_tbl.department_id')
            ->findAll();
    }

    public function select_department_byID($id)
    {
        return $this->db->table('department_tbl')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    public function select_leave_byStaffID($staffid)
    {
        return $this->select('leave_tbl.*,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name')
            ->where('leave_tbl.staff_id', $staffid)
            ->orderBy('leave_tbl.id', 'DESC')
            ->join('staff_tbl', 'staff_tbl.id=leave_tbl.staff_id')
            ->join('department_tbl', 'department_tbl.id=staff_tbl.department_id')
            ->findAll();
    }

    public function select_leave_forApprove()
    {
        return $this->select('leave_tbl.*,staff_tbl.pic,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name')
            ->where('leave_tbl.status', 0)
            ->join('staff_tbl', 'staff_tbl.id=leave_tbl.staff_id')
            ->join('department_tbl', 'department_tbl.id=staff_tbl.department_id')
            ->findAll();
    }

    public function delete_department($id)
    {
        return $this->db->table('department_tbl')
            ->where('id', $id)
            ->delete();
    }

    public function update_leave($data, $id)
    {
        return $this->where('id', $id)
            ->set($data)
            ->update();
    }
}
