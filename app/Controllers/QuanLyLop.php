<?php

namespace App\Controllers;

use App\Models\LopModel;
use App\Models\NganhModel;

class QuanLyLop extends BaseController
{
    public function index($maNganh = null):string
    {
        $LopModel = new LopModel();
        $NganhModel = new NganhModel();

        if (!empty($maNganh)) {
            $data['lop'] = $LopModel->select('lop.*, nganh.tenNganh, nganh.maNganh')
                ->join('nganh', 'nganh.maNganh = lop.maNganh', 'inner')
                ->where('lop.maNganh', intval($maNganh))
                ->orderBy('nganh.maNganh', 'DESC') 
                ->findAll();
        } else {
            $data['lop'] = $LopModel->select('lop.*, nganh.tenNganh, nganh.maNganh')
                ->join('nganh', 'nganh.maNganh = lop.maNganh', 'inner')
                ->orderBy('nganh.maNganh', 'DESC')
                ->findAll();
        }

        $data['maNganh'] = $maNganh;
        $data['nganh'] = $NganhModel->orderBy('maNganh', 'DESC')->findAll();
        return view('quan-ly-lop/index', $data);
    }

    public function add($maNganh = null)
    {
        $LopModel = new LopModel();
    
        if ($maNganh === null) {
            $maNganh = $this->request->getVar('maNganh');
        }
       
        if (empty($maNganh)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không xác định được khoa!');
            return redirect()->back();
        }
    
        $tenLop = $this->request->getVar('tenLop');
    
        if (empty($tenLop)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Tên Lớp không được để trống!');
            return redirect()->back();
        }
    
        $data = [
            'tenLop' => $tenLop,
            'maNganh' => $maNganh,
        ];
    
        try {
            if ($LopModel->insert($data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Thêm Lớp thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }
    
        return redirect()->to('quan-ly-lop/' . $maNganh);
    }


    public function edit()
    {
        $LopModel = new LopModel();
        $id = $this->request->getPost('maLop');
    
        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lớp không tồn tại!');
            return redirect()->to('/quan-ly-lop');
        }
    
        if ($this->request->getMethod() === 'POST') {
            $tenLop = trim($this->request->getPost('tenLop'));
            $maNganh = trim($this->request->getPost('maNganh'));
    
            if (empty($tenLop)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên Lớp không được để trống!');
                return redirect()->back();
            }
    
          
            $currentLop = $LopModel->find($id);
            if (!$currentLop) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Lớp không tồn tại!');
                return redirect()->to('/quan-ly-lop');
            }
    
            if (empty($maNganh)) {
                $maNganh = $currentLop['maNganh'];
            }
    
            $data = [
                'tenLop' => $tenLop,
                'maNganh' => $maNganh,
            ];
    
            if ($LopModel->update($id, $data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật lớp thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        }
    
        return redirect()->to('quan-ly-lop/' . $maNganh);
    }
    

    public function delete($id = null)
    {
        $LopModel = new LopModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy lớp cần xóa!');
            return redirect()->to('/quan-ly-lop');
        }

        $curentLop = $LopModel->find($id);

        if (!$curentLop) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lớp không tồn tại!');
            return redirect()->to('/quan-ly-lop');
        }
        $maNganh = $curentLop['maNganh']; 

        try {
            if ($LopModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa lớp thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa lớp thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa lớp vì đang được sử dụng!');
        }

        return redirect()->to('quan-ly-lop/'.$maNganh);
    }
}
