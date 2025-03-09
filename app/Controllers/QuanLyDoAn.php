<?php

namespace App\Controllers;

use App\Models\DoAnModel;
use App\Models\DeTaiModel;
use App\Models\GiangVienModel;
use App\Models\SinhVienModel;
use App\Models\UserModel;

class QuanLyDoAn extends BaseController
{
    public function index()
    {
        $DoAnModel = new DoAnModel();
        $DeTaiModel = new DeTaiModel();
        $trangThai = $this->request->getGet('trangThai') ?? 1;

        $data['trangThai'] = $trangThai;

        $data['doan'] = $DoAnModel->select('doan.*, detai.tenDeTai, sinhvien.maSV, giangvien.maGiangVien, 
        userSV.hoTen as tenSinhVien, userGV.hoTen as tenGiangVien, trangThai.name as trangThai')
            ->join('detai', 'detai.maDT = doan.maDT', 'left')
            ->join('sinhvien', 'sinhvien.maSV = doan.maSV', 'left')
            ->join('user as userSV', 'userSV.maUser = sinhvien.maUser', 'left')
            ->join('giangvien', 'giangvien.maGiangVien = doan.maGiangVien', 'left')
            ->join('user as userGV', 'userGV.maUser = giangvien.maUser', 'left')
            ->join('trangThai', 'trangThai.id = doan.trangThai', 'left')
            ->where('doan.trangThai', $trangThai)
            ->orderBy('sinhvien.maSV', 'DESC')
            ->findAll();

        $UserModel = new UserModel();
        $data['giangvien'] = $UserModel
            ->select('user.hoTen, giangvien.maGiangVien')
            ->join('giangvien', 'giangvien.maUser = user.maUser', 'left')
            ->where('user.role', 'GiangVien')
            ->orderBy('user.maUser', 'DESC')
            ->findAll();
        $data['sinhvien'] = $UserModel
            ->select('user.hoTen, sinhvien.maSV')
            ->join('sinhvien', 'sinhvien.maUser = user.maUser', 'left')
            ->where('user.role', 'SinhVien')
            ->orderBy('user.maUser', 'DESC')
            ->findAll();
        $data['detai'] = $DeTaiModel->findAll();

        return view('quan-ly-do-an/index', $data);
    }

    public function add()
    {
        $DoAnModel = new DoAnModel();

        $maDT = trim($this->request->getPost('maDT'));
        $maGiangVien = trim($this->request->getPost('maGiangVien'));
        $maSV = trim($this->request->getPost('maSV'));

        if (empty($maDT) || empty($maGiangVien) || empty($maSV)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->back();
        }

        $DoAnData = [
            'maDT' => $maDT,
            'maGiangVien' => $maGiangVien,
            'maSV' => $maSV,

        ];

        try {
            // echo "<pre>";
            // print_r($DoAnData); // Kiểm tra dữ liệu trước khi insert
            // echo "</pre>";
            if ($DoAnModel->insert($DoAnData)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Thêm đề tài thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi thêm đề tài!');
            }
        } catch (\Exception $e) {
            echo "LỖI SQL: " . $e->getMessage();  // In lỗi chi tiết
            die();
        }


        return redirect()->to('/quan-ly-do-an');
    }

    public function edit()
    {
        $DoAnModel = new DoAnModel();

        $maDA = $this->request->getPost('maDA');
        // $maDT = $this->request->getPost('maDT');
        // $maGiangVien = $this->request->getPost('maGiangVien');
        $maSV = $this->request->getPost('maSV');
        $diem = $this->request->getPost('diem');
        // $ngayNop = $this->request->getPost('ngayNop');
        $trangThaiDiem = $this->request->getPost('trangThaiDiem');

        // var_dump($maDA, $maSV,$diem,$trangThaiDiem);
        // exit();

        if (!$maDA || !$maSV) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Thiếu thông tin đề tài, giảng viên hoặc sinh viên!');
            return redirect()->to('/quan-ly-do-an');
        }

        if ($this->request->getMethod() === 'POST') {
            $curentDeTai = $DoAnModel->find($maDA);
            // var_dump($curentDeTai);
            // die();
            if (!$curentDeTai) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Đề tài không tồn tại!');
                return redirect()->to('/quan-ly-do-an');
            }

            try {
                $DoAnData = [];
                if (!empty($maSV)) $DoAnData['maSV'] = $maSV;
                if (!empty($diem)) $DoAnData['diem'] = $diem;
                if (!empty($trangThaiDiem)) $DoAnData['trangThaiDiem'] = $trangThaiDiem;

                // var_dump($maDT,$maGiangVien,$maSV,$diem,$ngayNop,$trangThaiDiem);
                // die();
                // var_dump("Dữ liệu trước khi update:", $maDA, $DoAnData);
                // die();

                if ($DoAnModel->update($maDA, $DoAnData)) {
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

        return redirect()->to('/quan-ly-do-an');
    }

    public function delete($id = null)
    {
        $UserModel = new UserModel();
        $DoAnModel = new DoAnModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy Sinh Viên cần xóa!');
            return redirect()->to('/quan-ly-do-an');
        }

        $curentGiangVien = $DoAnModel->find($id);

        if (!$curentGiangVien) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Sinh Viên không tồn tại!');
            return redirect()->to('/quan-ly-do-an');
        }

        try {
            if ($DoAnModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa Sinh Viên thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa Sinh Viên thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa Sinh Viên vì đang được sử dụng!');
        }

        return redirect()->to('/quan-ly-do-an');
    }

    public function dangKidoan()
    {
        session()->set('maSV', 1);
        $DoAnModel = new DoAnModel();

        $maDT = trim($this->request->getPost('maDT'));
        $maGiangVien = trim($this->request->getPost('maGiangVien'));
        $maSV = trim($this->request->getPost('maSV'));
        $trangThai = 1;
        $thoigianDangKi = date("Y-m-d H:i:s");;

        if (empty($maDT) || empty($maGiangVien) || empty($maSV)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->back();
        }


        $existing = $DoAnModel
            ->where('maSV', $maSV)
            ->whereNotIn('trangThai', [3])
            ->countAllResults();
        if ($existing > 0) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Bạn đã đăng ký một đề tài rồi!');
            return redirect()->back();
        }

        $DoAnData = [
            'maDT' => $maDT,
            'maGiangVien' => $maGiangVien,
            'maSV' => $maSV,
            'trangThai' => $trangThai,
            'thoigianDangKi' => $thoigianDangKi

        ];

        try {
            if ($DoAnModel->insert($DoAnData)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Đăng ký đề tài thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi đăng ký!');
            }
        } catch (\Exception $e) {
            echo "LỖI SQL: " . $e->getMessage();
            die();
        }

        return redirect()->to('/quan-ly-do-an');
    }

    public function capNhatTrangThai()
    {
        $trangThai = 2;
        $maDA = $this->request->getPost('maDA');
        $DoAnModel = new DoAnModel();

        if (!$maDA) {
            return redirect()->back()->with('error', 'Không tìm thấy đồ án!');
        }

        try {
            if ($DoAnModel->update($maDA, ['trangThai' => $trangThai])) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập Nhật Trạng Thái thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi cập nhật!');
            }
        } catch (\Exception $e) {
            echo "LỖI SQL: " . $e->getMessage();
            die();
        }
        return redirect()->to('/quan-ly-do-an');
    }

    public function tuchoi()
    {
        $trangThai = 3;
        $maDA = $this->request->getPost('maDA');
        $DoAnModel = new DoAnModel();

        if (!$maDA) {
            return redirect()->back()->with('error', 'Không tìm thấy đồ án!');
        }

        try {
            if ($DoAnModel->update($maDA, ['trangThai' => $trangThai])) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật trạng thái thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi cập nhật!');
            }
        } catch (\Exception $e) {
            echo "LỖI SQL: " . $e->getMessage();
            die();
        }

        return redirect()->to('/quan-ly-do-an');
    }

    public function huy()
    {
        $trangThai = 3;
        $maDA = $this->request->getPost('maDA');
        $DoAnModel = new DoAnModel();

        if (!$maDA) {
            return redirect()->back()->with('error', 'Không tìm thấy đồ án!');
        }

        try {
            if ($DoAnModel->update($maDA, ['trangThai' => $trangThai])) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật trạng thái thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi cập nhật!');
            }
        } catch (\Exception $e) {
            echo "LỖI SQL: " . $e->getMessage();
            die();
        }

        return redirect()->to('/quan-ly-do-an');
    }

    public function chitiet($maDA)
    {
        $DoAnModel = new DoAnModel();
        $SinhVienModel = new SinhVienModel();

        $data['maDA'] = $maDA;
        $SinhVienList = $SinhVienModel;

        $data['chiTiet'] = $DoAnModel->where('maDA', $maDA)->first();

        if (!$data['chiTiet']) {
            // return redirect()->back()->with('error', 'Không tìm thấy đồ án!');
        }
        $doan = $DoAnModel
            ->select('doan.maDA, doan.maDT, detai.tenDeTai, user.hoTen as tenGiangVien, doan.ngayNop')
            ->join('giangvien', 'giangvien.maGiangVien = doan.maGiangVien', 'left')
            ->join('user', 'user.maUser = giangvien.maUser', 'left')
            ->join('detai', 'doan.maDT =detai.maDT', 'left')
            ->where('doan.maDA', $maDA)
            ->first();
        // var_dump($doan);
        // exit();


        if (!$doan) {
            return redirect()->to('/quan-ly-do-an')->with('message', 'Không tìm thấy đồ án!');
        }

        $data['sinhVienList'] = $SinhVienList
            ->select('sinhvien.maSV, user.hoTen, user.maUser, doan.maDA, doan.diem, doan.trangThai, doan.trangThaiDiem')
            ->join('user', 'user.maUser = sinhvien.maUser', 'left')
            ->join('doan', 'doan.maSV = sinhvien.maSV', 'left')
            ->where('doan.trangThai', 2)
            ->where('doan.maDA', $maDA)
            ->findAll();
        $data['doan'] = $doan;

        return view('quan-ly-do-an/chi-tiet-do-an', $data);
    }

    public function quaylai()
    {
        $quaylai = $this->request->getPost('quaylai');

        if ($quaylai === 'cancel') {
            return redirect()->to('/quan-ly-do-an');
        }

        return redirect()->to('/quan-ly-do-an');
    }
}
