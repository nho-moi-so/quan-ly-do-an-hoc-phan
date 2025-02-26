<?php

namespace App\Controllers;

use App\Models\BoMonModel;
use App\Models\KhoaModel;

class QuanLyBoMon extends BaseController
{
    public function index(): string
    {
        $BoMonModel = new BoMonModel();

        $data['bomon'] = $BoMonModel->select('bomon.*, khoa.tenKhoa, khoa.maKhoa')
            ->join('khoa', 'khoa.maKhoa = bomon.maKhoa', 'left')
            ->orderBy('maBoMon', 'DESC')
            ->findAll();

        $KhoaModel = new KhoaModel();
        $data['khoa'] = $KhoaModel->orderBy('maKhoa', 'DESC')->findAll();

        return view('quan-ly-bo-mon/index', $data);
    }

    public function add()
    {
        $BoMonModel = new BoMonModel();

        // Lấy dữ liệu từ form
        $tenBoMon = $this->request->getVar('tenBoMon');
        $maKhoa = $this->request->getVar('maKhoa');

        // Kiểm tra nếu tên khoa bị trống
        if (empty($tenBoMon)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Tên bộ môn không được để trống!');
            return redirect()->back();
        }

        // Chuẩn bị dữ liệu
        $data = [
            'tenBoMon' => $tenBoMon,
            'maKhoa' => $maKhoa,
        ];

        try {
            if ($BoMonModel->insert($data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Thêm bộ môn thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->to('/quan-ly-bo-mon');
    }

    public function edit()
    {
        $BoMonModel = new BoMonModel();
        $id = $this->request->getPost('maBoMon');

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Bộ môn không tồn tại!');
            return redirect()->to('/quan-ly-bo-mon');
        }

        if ($this->request->getMethod() === 'POST') {
            $tenBoMon = trim($this->request->getPost('tenBoMon'));
            $maKhoa = trim($this->request->getPost('maKhoa'));

            // Kiểm tra nếu dữ liệu bị bỏ trống
            if (empty($tenBoMon) || empty($maKhoa)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên bộ môn và khoa không được để trống!');
                return redirect()->back();
            }

            $curentBoMon = $BoMonModel->find($id);

            if (!$curentBoMon) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Bộ môn không tồn tại!');
                return redirect()->to('/quan-ly-bo-mon');
            }

            // Dữ liệu cần cập nhật
            $data = [
                'tenBoMon' => $tenBoMon,
                'maKhoa' => $maKhoa,
            ];

            // Cập nhật và kiểm tra kết quả
            if ($BoMonModel->update($id, $data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật bộ môn thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        }

        return redirect()->to('/quan-ly-bo-mon');
    }

    public function delete($id = null)
    {
        $BoMonModel = new BoMonModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy bộ môn cần xóa!');
            return redirect()->to('/quan-ly-bo-mon');
        }

        $curentBoMon = $BoMonModel->find($id);

        if (!$curentBoMon) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Bộ môn không tồn tại!');
            return redirect()->to('/quan-ly-bo-mon');
        }

        try {
            if ($BoMonModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa bộ môn thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa bộ môn thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            // Bắt lỗi nếu có ràng buộc khóa ngoại
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa bộ môn vì đang được sử dụng!');
        }

        return redirect()->to('/quan-ly-bo-mon');
    }
}
