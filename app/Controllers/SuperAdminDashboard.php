<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataAdminModel;
use App\Models\DataClientModel;
use App\Models\ProyekModel;

class SuperAdminDashboard extends BaseController
{
    protected $proyekModel;
    protected $adminModel;
    protected $clientModel;
    public function __construct()
    {
        $this->proyekModel = new ProyekModel();
        $this->adminModel = new DataAdminModel();
        $this->clientModel = new DataClientModel();
    }

    public function index()
    {
        $data = [
            "proyek" => $this->proyekModel->getProyekWithOwner(),
            "admin" => sizeof($this->adminModel->getUsers()),
            "client" => sizeof($this->clientModel->getUsers()),
        ];
        return viewSA('dashboard/super/main', $data);
    }

    public function proyek($idProyek = null, $idProgress = null)
    {
        if ($idProyek && $idProgress) {
            $progress = $this->proyekModel->getProgressById($idProgress);
            $data = [
                'progress' => $progress
            ];
            return viewSA('dashboard/super/detail_progress', $data);
        } else if ($idProyek) {
            return viewSA('dashboard/super/progress');
        }
        return viewSA('dashboard/super/proyek');
    }

    public function formProyek($idProyek = null)
    {
        $admin = $this->adminModel->getUsers();
        $users = $this->clientModel->getUsers();
        $data = [
            'admin' => $admin,
            'users' => $users,
        ];
        if ($idProyek) {
            $proyek = $this->proyekModel->getProyekById($idProyek);
            $data['proyek'] = $proyek;
        }
        return viewSA('dashboard/super/form_proyek', $data);
    }

    public function pembayaran($idProyek = null)
    {
        if ($idProyek) {
            $proyek = $this->proyekModel->getProyekById($idProyek);
            $data = [
                'proyek' => $proyek
            ];
            return viewSA('dashboard/super/pembayaran_proyek', $data);
        }
        return viewSA('dashboard/super/pembayaran');
    }

    public function portofolio()
    {
        return viewSA('dashboard/super/portofolio');
    }

    public function pengguna()
    {
        return viewSA('dashboard/super/pengguna');
    }

    public function profile()
    {
        return viewSA('dashboard/super/profile');
    }
}
