<?php

namespace App\Controllers;

use App\Models\NganhModel;
use App\Models\KhoaModel;

class QuanLyNganh extends BaseController
{
    public function index($maKhoa = null):string
    {
        $NganhModel = new NganhModel();
        $KhoaModel = new KhoaModel();

        if (!empty($maKhoa)) {
           
            $data['nganh'] = $NganhModel->select('nganh.*, khoa.tenKhoa, khoa.maKhoa')
                ->join('khoa', 'khoa.maKhoa = nganh.maKhoa', 'inner')
                ->where('nganh.maKhoa', intval($maKhoa)) 
                ->orderBy('maNganh', 'DESC')
                ->findAll();
        } else {
           
            $data['nganh'] = $NganhModel->select('nganh.*, khoa.tenKhoa, khoa.maKhoa')
                ->join('khoa', 'khoa.maKhoa = nganh.maKhoa', 'inner')
                ->orderBy('maNganh', 'DESC')
                ->findAll();
        }
       
        $data['maKhoa'] = $maKhoa;
        $data['khoa'] = $KhoaModel->orderBy('maKhoa', 'DESC')->findAll();
        return view('quan-ly-nganh/index', $data);
    }

    public function add($maKhoa = null)
    {
        $NganhModel = new NganhModel();
    
        if (empty($maKhoa)) {
            $maKhoa = $this->request->getVar('maKhoa');
        }
    
     
        if (empty($maKhoa)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không xác định được khoa!');
            return redirect()->back();
        }
       
    
        $tenNganh = trim($this->request->getVar('tenNganh'));
    
        if (empty($tenNganh)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Tên ngành không được để trống!');
            return redirect()->back();
        }
    
        $data = [
            'tenNganh' => $tenNganh,
            'maKhoa' => $maKhoa,
        ];
    
        try {
            if ($NganhModel->insert($data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Thêm ngành thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }
    
        return redirect()->to('quan-ly-nganh/' . $maKhoa);
    }
    
    

    public function edit()
    {
        $NganhModel = new NganhModel();
        $id = $this->request->getPost('maNganh');
    
        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Ngành không tồn tại!');
            return redirect()->to('/quan-ly-nganh');
        }
    
        if ($this->request->getMethod() === 'POST') {
            $tenNganh = trim($this->request->getPost('tenNganh'));
            $maKhoa = trim($this->request->getPost('maKhoa'));
    
            if (empty($tenNganh)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên Ngành không được để trống!');
                return redirect()->back();
            }
    
            // Lấy thông tin ngành hiện tại
            $currentNganh = $NganhModel->find($id);
    
            if (!$currentNganh) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Ngành không tồn tại!');
                return redirect()->to('/quan-ly-nganh');
            }
    
            // Nếu không nhập khoa, giữ nguyên giá trị cũ
            if (empty($maKhoa)) {
                $maKhoa = $currentNganh['maKhoa'];
            }
    
            $data = [
                'tenNganh' => $tenNganh,
                'maKhoa' => $maKhoa,
            ];
    
            if ($NganhModel->update($id, $data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật ngành thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        }
    
        return redirect()->to('quan-ly-nganh/' .$maKhoa);
    }
    
    public function delete($id = null)
    {
        $NganhModel = new NganhModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy ngành cần xóa!');
            return redirect()->to('/quan-ly-nganh');
        }

        $curentNganh = $NganhModel->find($id);

        if (!$curentNganh) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Ngành không tồn tại!');
            return redirect()->to('/quan-ly-nganh');
        }

        $maKhoa = $curentNganh['maKhoa']; 

        try {
            if ($NganhModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa ngành thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa ngành thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa ngành vì đang được sử dụng!');
        }

        return redirect()->to('quan-ly-nganh/' .$maKhoa );
    }
}
