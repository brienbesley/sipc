<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $session;


    public function __construct()
    {

        $this->session = \Config\Services::session();
        $this->session->start();
        helper('form');
    }



    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        } else {
            if ($this->session->get('usertype') == 1) {
                $departmentModel = new \App\Models\DepartmentModel();
                $staffModel = new \App\Models\StaffModel();
                $leaveModel = new \App\Models\LeaveModel();

                $data['department'] = $departmentModel->select_departments();
                $data['staff'] = $staffModel->select_staff();
                $data['leave'] = $leaveModel->select_leave_forApprove();

                return view('admin/header') . view('admin/dashboard', $data) . view('admin/footer');
            } else {
                $staff = $this->session->get('userid');
                $leaveModel = new \App\Models\LeaveModel();
                $data['leave'] = $leaveModel->select_leave_byStaffID($staff);
                return view('staff/header') . view('staff/dashboard', $data) . view('staff/footer');
            }
        }
    }

    public function login_page()
    {
        return view('login');
    }

    public function error_page()
    {
        return view('admin/header') . view('admin/error_page') . view('admin/footer');
    }

    public function login()
    {
        $un = $this->request->getPost('txtusername');
        $pw = $this->request->getPost('txtpassword');

        $homeModel = new \App\Models\HomeModel();
        $check_login = $homeModel->logindata($un, $pw);
        if ($check_login <> '') {
            if ($check_login[0]['status'] == 1) {
                if ($check_login[0]['usertype'] == 1) {
                    $data = array(
                        'logged_in'  =>  TRUE,
                        'username' => $check_login[0]['username'],
                        'usertype' => $check_login[0]['usertype'],
                        'userid' => $check_login[0]['id']
                    );
                    $this->session->set($data);
                    return redirect()->to('/');
                } elseif ($check_login[0]['usertype'] == 2) {
                    $data = array(
                        'logged_in'  =>  TRUE,
                        'username' => $check_login[0]['username'],
                        'usertype' => $check_login[0]['usertype'],
                        'userid' => $check_login[0]['id']
                    );
                    $this->session->set($data);
                    return redirect()->to('/');
                } else {
                    $this->session->setFlashdata('login_error', 'Sorry, you cant login right now.', 300);
                    return redirect()->to(base_url() . 'login');
                }
            } else {
                $this->session->setFlashdata('login_error', 'Sorry, your account is blocked.', 300);
                return redirect()->to(base_url() . 'login');
            }
        } else {
            $this->session->setFlashdata('login_error', 'Please check your username or password and try again.', 300);
            return redirect()->to(base_url() . 'login');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url() . 'login');
    }
}
