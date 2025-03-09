<?php

namespace App\Controllers;

use App\Models\BoMonModel;
use App\Models\KhoaModel;

class QuanLyBoMon extends BaseController
{
    public function index($maKhoa = null): string
    {
        $BoMonModel = new BoMonModel();
        $KhoaModel = new KhoaModel();

        if (!empty($maKhoa)) {

            $data['bomon'] = $BoMonModel->select('bomon.*, khoa.tenKhoa, khoa.maKhoa')
                ->join('khoa', 'khoa.maKhoa = bomon.maKhoa', 'inner')
                ->where('bomon.maKhoa', intval($maKhoa))
                ->orderBy('maBoMon', 'DESC')
                ->findAll();
        } else {

            $data['bomon'] = $BoMonModel->select('bomon.*, khoa.tenKhoa, khoa.maKhoa')
                ->join('khoa', 'khoa.maKhoa = bomon.maKhoa', 'inner')
                ->orderBy('maBoMon', 'DESC')
                ->findAll();
        }


        $data['maKhoa'] = $maKhoa;
        $data['khoa'] = $KhoaModel->orderBy('maKhoa', 'DESC')->findAll();

        return view('quan-ly-bo-mon/index', $data);
    }


    public function add($maKhoa = null)
    {
        $BoMonModel = new BoMonModel();
    
        if ($maKhoa === null) {
            $maKhoa = $this->request->getVar('maKhoa');
        }
    
        if (empty($maKhoa)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không xác định được khoa!');
            return redirect()->back();
        }
    
        $tenBoMon = $this->request->getVar('tenBoMon');
    
        if (empty($tenBoMon)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Tên bộ môn không được để trống!');
            return redirect()->back();
        }
    
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
    
        return redirect()->to('quan-ly-bo-mon/' . $maKhoa);
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

            if (empty($tenBoMon)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên bộ môn và khoa không được để trống!');
                return redirect()->back();
            }

            $currentBoMon = $BoMonModel->find($id);

            if (!$currentBoMon) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Bộ môn không tồn tại!');
                return redirect()->to('/quan-ly-bo-mon');
            }

            if (empty($maKhoa)) {
                $maKhoa = $currentBoMon['maKhoa'];
            }
    
            $data = [
                'tenBoMon' => $tenBoMon,
                'maKhoa' => $maKhoa,
            ];

            if ($BoMonModel->update($id, $data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật bộ môn thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        }

        return redirect()->to('quan-ly-bo-mon/'. $maKhoa);
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
        
        $maKhoa = $curentBoMon['maKhoa']; 

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

        return redirect()->to('quan-ly-bo-mon/'.$maKhoa);
    }
}
