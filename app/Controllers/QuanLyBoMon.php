<?php

namespace App\Controllers;
use App\Models\BomonModel;
class QuanLyBoMon extends BaseController
{
    public function index(): string
    {
        $BomonModel = new BomonModel();
        $data['bomon'] = $BomonModel->orderBy('MaBoMon', 'DESC')->select('bomon.*, khoa.tenKhoa') // Lấy cả tên khoa
        ->join('khoa', 'khoa.maKhoa = bomon.maKhoa', 'left') ->findAll();
        return view('quan-ly-bo-mon/index', $data);
    }
    public function add()
    {
        // return view('quan-ly-bo-mon/index');
        session()->setFlashdata('message_type', 'success');
        return redirect()->to('/quan-ly-bo-mon')->with('message', 'Thêm Bộ Môn thành công!');
    }
    
    // luu
    public function store() 
    {
        $BomonModel = new BomonModel();
        $data = [
            'TenBoMon' => $this->request->getVar('TenBoMon'),
           
        ];
        if ($BomonModel->insert($data)) {
            return redirect()->to('/quan-ly-bo-mon');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
        return $this->response->redirect(site_url('/quan-ly-bo-mon'));
    }

    public function edit()
    {
        // Lấy dữ liệu từ POST
        $BoMonId = $this->request->getPost('BoMonId');
        $tenBoMon = $this->request->getPost('tenBoMon');

        // Cập nhật dữ liệu vào database
        // $model = new BoMonModel();
        // $data = [
        //     'ten_BoMon' => $tenBoMon,
        //     'mo_ta_BoMon' => $moTaBoMon,
        // ];
        // $model->update($BoMonId, $data);

        // Set flash message và redirect lại trang danh sách Bộ Môn
        session()->setFlashdata('message_type', 'success');
        session()->setFlashdata('message', 'Cập nhật Bộ Môn thành công!');
        return redirect()->to('/quan-ly-bo-mon');
    }

    public function delete()
    {
        // Lấy dữ liệu từ POST
        $BoMonId = $this->request->getPost('BoMonId');

        // Cập nhật dữ liệu vào database
        // $model = new BoMonModel();
        // $data = [
        //     'ten_BoMon' => $tenBoMon,
        //     'mo_ta_BoMon' => $moTaBoMon,
        // ];
        // $model->update($BoMonId, $data);

        // Set flash message và redirect lại trang danh sách Bộ Môn
        // session()->setFlashdata('message', 'Cập nhật Bộ Môn thành công!');
        session()->setFlashdata('message_type', 'error');
        session()->setFlashdata('message', 'Xóa Bộ Môn thất bại!');
        return redirect()->to('/quan-ly-bo-mon');
    }
}
