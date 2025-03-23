<?php

namespace App\Controllers;

use App\Models\DoAnModel;
use App\Models\DeTaiModel;
use App\Models\GiangVienModel;
use App\Models\SinhVienModel;
use App\Models\UserModel;
use App\Models\NhomDoAnModel;

class QuanLyDoAn extends BaseController
{
    public function index()
    {
        $DoAnModel = new DoAnModel();
        $DeTaiModel = new DeTaiModel();
        $trangThai = $this->request->getGet('trangThai') ?? 1;
        // dd($trangThai);
        $data['trangThai'] = $trangThai;
        $data['doan'] = $DoAnModel->select('doan.*, detai.tenDeTai, sv1.maSV, giangvien.maGiangVien, 
        userSV.hoTen as tenSinhVien, userGV.hoTen as tenGiangVien, lop.tenLop, trangThai.name as trangThai')
            ->distinct()
            ->join('detai', 'detai.maDT = doan.maDT', 'left')
            ->join('sinhvien as sv1', 'sv1.maSV = doan.maSV', 'left')
            ->join('user as userSV', 'userSV.maUser = sv1.maUser', 'left')
            ->join('giangvien', 'giangvien.maGiangVien = doan.maGiangVien', 'left')
            ->join('user as userGV', 'userGV.maUser = giangvien.maUser', 'left')
            ->join('trangThai', 'trangThai.id = doan.trangThai', 'left')
            ->join('lop', 'lop.maLop = sv1.maLop', 'left')
            ->where('doan.trangThai', $trangThai)
            ->orderBy('doan.thoigianDangKi', 'DESC')
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
        $DoAnModel = new DoAnModel();
        $maSV = session()->get('maSV');

        if (!$maSV) {
            return redirect()->back()->with('error', 'Bạn chưa đăng nhập!');
        }

        $maDT = trim($this->request->getPost('maDT'));
        $maGiangVien = trim($this->request->getPost('maGiangVien'));
        $trangThai = 1;
        $thoigianDangKi = date("Y-m-d H:i:s");;

        $SinhVienModel = new SinhVienModel();
        $doan = $SinhVienModel->select('maLop')->where('maSV', $maSV)->first();

        $maLop = isset($doan['maLop']) ? $doan['maLop'] : null;


        if ($maLop === null) {
            return redirect()->back()->with('error', 'Không tìm thấy mã lớp của sinh viên!');
        }

        if (empty($maDT) || empty($maGiangVien) || empty($maSV)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->back();
        }

        $existing = $DoAnModel
            ->where('maSV', $maSV)
            ->where('maDT', $maDT)
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
            'maLop' => $maLop,
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

        return redirect()->to('quan-ly-do-an/');
    }

    public function capNhatTrangThai()
    {
        $trangThai = 2;
        $maDA = $this->request->getPost('maDA');
        $DoAnModel = new DoAnModel();
        $NhomDoAnModel = new NhomDoAnModel();

        if (!$maDA) {
            return redirect()->back()->with('error', 'Không tìm thấy đồ án!');
        }

        $doan = $DoAnModel->select('maSV, maLop, trangThai, doan.maDT, tenDeTai')
            ->where('maDA', $maDA)
            ->join('detai', 'doan.maDT = detai.maDT', 'left')
            ->first();

        if (!$doan) {
            return redirect()->back()->with('error', 'Không tìm thấy dữ liệu đồ án!');
        }

        $maSV = $doan['maSV'];
        $maLop = $doan['maLop'];

        if (empty($maSV)) {
            return redirect()->back()->with('error', 'Không tìm thấy sinh viên!');
        }

        if (empty($maLop)) {
            return redirect()->back()->with('error', 'Không tìm thấy lớp học của sinh viên!');
        }

        try {
            $DoAnModel->update($maDA, ['trangThai' => $trangThai]);

            // Kiểm tra nhóm đã tồn tại chưa
            $nhom = $NhomDoAnModel->where('maLop', $maLop)->first();

            if (!$nhom) {
                // Tạo nhóm mới
                $tenNhom = "Nhóm_" . $maLop . $doan['tenDeTai'];
                $dataNhom = [
                    'tenNhom' => $tenNhom,
                    'maLop' => $maLop,
                    'maDA' => $maDA,
                    'sv1' => $maSV
                ];


                if (!$NhomDoAnModel->insert($dataNhom)) {
                    return redirect()->back()->with('error', 'Không thể tạo nhóm mới!');
                }
            } else {
                // Kiểm tra sv2 và sv3 có tồn tại không, nếu chưa thì thêm vào
                if (!isset($nhom['sv2']) || empty($nhom['sv2'])) {
                    $NhomDoAnModel->update($nhom['maNhom'], ['sv2' => $maSV]);
                } elseif (!isset($nhom['sv3']) || empty($nhom['sv3'])) {
                    $NhomDoAnModel->update($nhom['maNhom'], ['sv3' => $maSV]);
                } else {
                    return redirect()->back()->with('error', 'Nhóm đã đủ 3 sinh viên!');
                }
            }

            session()->setFlashdata('message_type', 'success');
            session()->setFlashdata('message', 'Duyệt đồ án & cập nhật nhóm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'LỖI SQL: ' . $e->getMessage());
        }
        return redirect()->to('quan-ly-do-an?trangThai=2');
    }


    public function tuchoi()
    {
        $trangThai = 3;
        $maDA = $this->request->getPost('maDA');
        $DoAnModel = new DoAnModel();
        $NhomDoAnModel = new NhomDoAnModel();

        if (empty($maDA)) {
            return redirect()->back()->with('error', 'Không tìm thấy đồ án!');
        }

        try {
            $doAn = $DoAnModel->select('maSV, maLop')->where('maDA', $maDA)->first();
            if (!$doAn) {
                return redirect()->back()->with('error', 'Đồ án không tồn tại!');
            }

            $maSV = $doAn['maSV'];
            $maLop = $doAn['maLop'];

            // Cập nhật trạng thái đồ án
            $DoAnModel->update($maDA, ['trangThai' => $trangThai]);

            // Tìm nhóm đồ án của sinh viên
            $nhom = $NhomDoAnModel->where('maLop', $maLop)->first();

            if ($nhom) {
                if ($nhom['sv1'] == $maSV) {
                    // Nếu là SV1 -> xóa nhóm luôn
                    $NhomDoAnModel->delete($nhom['maNhom']);
                } elseif ($nhom['sv2'] == $maSV) {
                    // Nếu là SV2 -> cập nhật sv2 thành NULL
                    $NhomDoAnModel->update($nhom['maNhom'], ['sv2' => NULL]);
                } elseif ($nhom['sv3'] == $maSV) {
                    // Nếu là SV3 -> cập nhật sv3 thành NULL
                    $NhomDoAnModel->update($nhom['maNhom'], ['sv3' => NULL]);
                }

                // Nếu nhóm không còn SV nào, xóa nhóm
                $nhomUpdated = $NhomDoAnModel->find($nhom['maNhom']);
                if (empty($nhomUpdated['sv1']) && empty($nhomUpdated['sv2']) && empty($nhomUpdated['sv3'])) {
                    $NhomDoAnModel->delete($nhom['maNhom']);
                }
            }

            session()->setFlashdata('message_type', 'success');
            session()->setFlashdata('message', 'Hủy đăng ký thành công!');
        } catch (\Exception $e) {
            log_message('error', 'LỖI SQL: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi hệ thống! Vui lòng thử lại.');
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
}
