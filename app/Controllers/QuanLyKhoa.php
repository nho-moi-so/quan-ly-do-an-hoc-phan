<?php

namespace App\Controllers;

class QuanLyKhoa extends BaseController
{
    public function index(): string
    {
        return view('quan-ly-khoa/index');
    }

    public function add()
    {
        // return view('quan-ly-khoa/index');
        session()->setFlashdata('message_type', 'success');
        return redirect()->to('/quan-ly-khoa')->with('message', 'Thêm khoa thành công!');
    }

    public function edit()
    {
        // Lấy dữ liệu từ POST
        $khoaId = $this->request->getPost('khoaId');
        $tenKhoa = $this->request->getPost('tenKhoa');
        $moTaKhoa = $this->request->getPost('moTaKhoa');

        // Cập nhật dữ liệu vào database
        // $model = new KhoaModel();
        // $data = [
        //     'ten_khoa' => $tenKhoa,
        //     'mo_ta_khoa' => $moTaKhoa,
        // ];
        // $model->update($khoaId, $data);

        // Set flash message và redirect lại trang danh sách khoa
        session()->setFlashdata('message_type', 'success');
        session()->setFlashdata('message', 'Cập nhật khoa thành công!');
        return redirect()->to('/quan-ly-khoa');
    }

    public function delete()
    {
        // Lấy dữ liệu từ POST
        $khoaId = $this->request->getPost('khoaId');

        // Cập nhật dữ liệu vào database
        // $model = new KhoaModel();
        // $data = [
        //     'ten_khoa' => $tenKhoa,
        //     'mo_ta_khoa' => $moTaKhoa,
        // ];
        // $model->update($khoaId, $data);

        // Set flash message và redirect lại trang danh sách khoa
        // session()->setFlashdata('message', 'Cập nhật khoa thành công!');
        session()->setFlashdata('message_type', 'error');
        session()->setFlashdata('message', 'Xóa khoa thất bại!');
        return redirect()->to('/quan-ly-khoa');
    }
}
