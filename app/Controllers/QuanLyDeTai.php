<?php

namespace App\Controllers;

use App\Models\DeTaiModel;
use App\Models\GiangVienModel;
use App\Models\UserModel;
use App\Models\NganhModel;


class QuanLyDeTai extends BaseController
{
    public function index()
    {
        $DeTaiModel = new DeTaiModel();
        $data['detai'] = $DeTaiModel->select('detai.*, user.*, giangvien.*, nganh.tenNganh')
            ->join('giangvien', 'giangvien.maGiangVien = detai.maGiangVien', 'left')
            ->join('user', 'user.maUser = giangvien.maUser', 'left')
            ->join('nganh', 'nganh.maNganh = detai.maNganh', 'left')
            ->orderBy('detai.maDT', 'DESC')
            ->findAll();

        $namHoc = $DeTaiModel->select('namHoc')->distinct()->findAll();

        $UserModel = new UserModel();
        $data['giangvien'] = $UserModel
            ->select('user.hoTen, giangvien.maGiangVien')
            ->join('giangvien', 'giangvien.maUser = user.maUser', 'left')
            ->where('user.role', 'GiangVien')
            ->orderBy('user.maUser', 'DESC')
            ->findAll();
        $NganhModel = new NganhModel();
        $data['nganh'] = $NganhModel->orderBy('maNganh', 'DESC')->findAll();
        return view('quan-ly-de-tai/index', $data);
    }

    public function add()
    {
        $DeTaiModel = new DeTaiModel();

        $tenDeTai = trim($this->request->getPost('tenDeTai'));
        $moTa = trim($this->request->getPost('moTa'));
        $maGiangVien = trim($this->request->getPost('maGiangVien'));
        $maNganh = $this->request->getVar('maNganh');
        $namHoc = trim($this->request->getPost('namHoc'));
        $hocKi = trim($this->request->getPost('hocKi'));

        // var_dump($maGiangVien);
        // die();


        if (empty($tenDeTai) || empty($moTa) || empty($maGiangVien) || empty($maNganh) || empty($namHoc)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->back();
        }

        $DeTaiData = [
            'tenDeTai' => $tenDeTai,
            'moTa' => $moTa,
            'maGiangVien' => $maGiangVien,
            'maNganh' => $maNganh,
            'namHoc' => $namHoc,
            'hocKi' => $hocKi,
        ];
       

        try {

            if ($DeTaiModel->insert($DeTaiData)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Thêm đề tài thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi thêm đề tài!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->to('/quan-ly-de-tai');
    }


    public function edit()
    {
        $DeTaiModel = new DeTaiModel();
        $GiangVienModel = new GiangVienModel();

        $maDT = $this->request->getPost('maDT');

        if (!$maDT) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Đề tài không tồn tại!');
            return redirect()->to('/quan-ly-de-tai');
        }

        if ($this->request->getMethod() === 'POST') {
            $tenDeTai = trim($this->request->getPost('tenDeTai'));
            $moTa = trim($this->request->getPost('moTa'));
            $maGiangVien = trim($this->request->getPost('maGiangVien'));
            $maNganh = trim($this->request->getPost('maNganh'));
            $namHoc = trim($this->request->getPost('namHoc'));
            $hocKi = trim($this->request->getPost('hocKi'));

            $deTai = $DeTaiModel->find($maDT);
            if (!$deTai) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Đề tài không tồn tại!');
                return redirect()->to('/quan-ly-de-tai');
            }

            if (!empty($maGiangVien)) {
                $giangVien = $GiangVienModel->find($maGiangVien);

                if (!$giangVien) {
                    session()->setFlashdata('message_type', 'error');
                    session()->setFlashdata('message', 'Mã giảng viên không hợp lệ!');
                    return redirect()->back();
                }
            }

            if (empty($tenDeTai)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên đề tài không được để trống!');
                return redirect()->back();
            }


            try {
                $DeTaiData = [
                    'tenDeTai' => $tenDeTai,
                    'moTa' => $moTa,
                    'maGiangVien' => $maGiangVien,
                    'maNganh' => $maNganh,
                    'namHoc' => $namHoc,
                    'hocKi' => $hocKi,
                ];

                if ($DeTaiModel->update($maDT, $DeTaiData)) {
                    session()->setFlashdata('message_type', 'success');
                    session()->setFlashdata('message', 'Cập nhật đề tài thành công!');
                } else {
                    session()->setFlashdata('message_type', 'error');
                    session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
                }
            } catch (\Exception $e) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
            }
        }

        return redirect()->to('/quan-ly-de-tai');
    }

    public function delete($id = null)
    {
        $DeTaiModel = new DeTaiModel();


        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy Đề Tài cần xóa!');
            return redirect()->to('/quan-ly-de-tai');
        }


        $deTai = $DeTaiModel->find($id);
        if (!$deTai) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Đề Tài không tồn tại!');
            return redirect()->to('/quan-ly-de-tai');
        }

        try {

            if ($DeTaiModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa Đề Tài thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa Đề Tài thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->to('/quan-ly-de-tai');
    }
}
