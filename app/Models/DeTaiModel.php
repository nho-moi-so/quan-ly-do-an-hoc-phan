<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Models\UserModel;
use App\Models\NganhModel;

use function PHPSTORM_META\type;

class DeTaiModel extends Model
{
    protected $table = 'detai';
    protected $primaryKey = 'maDT';

    protected $allowedFields = ['maUser', 'maGiangVien', 'tenDeTai', 'moTa', 'namHoc', 'hocKi', 'maNganh'];

    public function timKiemDeTai($maNganh = null, $hocKi = null, $namHoc = null)
    {
        $maNganh = (!empty($maNganh) && $maNganh != 'all') ? $maNganh : null;
        $hocKi = (!empty($hocKi) && $hocKi != 'all') ? $hocKi : null;
        $namHoc = (!empty($namHoc) && $namHoc != 'all') ? $namHoc : null;

        $detai = $this->db->table('detai');
        $detai->select('detai.*, nganh.maNganh, nganh.tenNganh, user.*, giangvien.*');
        $detai->join('nganh', 'nganh.maNganh = detai.maNganh', 'left');
        $detai->join('giangvien', 'giangvien.maGiangVien = detai.maGiangVien', 'left');
        $detai->join('user', 'user.maUser = giangvien.maUser', 'left');

        if (!empty($maNganh)) {
            $detai->where('detai.maNganh', $maNganh);
        }

        if (!empty($hocKi)) {
            $detai->where('detai.hocKi', $hocKi);
        }

        if (!empty($namHoc)) {
            $detai->where('detai.namHoc', $namHoc);
        }

        $detai->orderBy('detai.maDT', 'DESC');

        return $detai->get()->getResultArray();
    }

    public function getNganh()
    {
        $NganhModel = new NganhModel();

        return $NganhModel->select('maNganh, tenNganh')
            ->orderBy('maNganh', 'ASC')
            ->findAll();;
    }

    public function getGiangVien()
    {
        $UserModel = new UserModel();

        return $UserModel
            ->select('user.hoTen, giangvien.maGiangVien')
            ->join('giangvien', 'giangvien.maUser = user.maUser', 'left')
            ->where('user.role', 'GiangVien')
            ->orderBy('user.maUser', 'DESC')
            ->findAll();;
    }

    public function getHocKiOptions()
    {
        return $this->select('hocKi')->distinct()->findColumn('hocKi');
    }

    // Hàm lấy danh sách năm học
    public function getNamHocOptions()
    {
        return $this->select('namHoc')->distinct()->orderBy('namHoc', 'ASC')->findColumn('namHoc');
    }

    
}
