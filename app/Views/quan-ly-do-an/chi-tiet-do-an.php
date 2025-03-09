<pre>
<?php var_dump($doan); ?>
</pre>

<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Chi Tiết Đồ Án
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container border-top pt-4">
    <ul class="breadcrumb">
        <li><a href="/quan-ly-do-an">Quản Lý Đồ Án / </a></li>
        <li><a href=""> Đồ Án 1 / </a></li>
        <li>Chi Tiết Đồ Án</li>
    </ul>
    <form action="<?= base_url('quan-ly-do-an/chitiet') ?>" method="POST">
        <!-- <fieldset disabled> -->
        <legend>Chi tiết đồ án</legend>

        <div class="row d-flex align-items-center">
            <div class="col-md-4">
                <label for="id" class="form-label">ID</label>
                <input type="text" id="maDA" class="form-control form-control-sm" value="<?= $doan['maDA'] ?? '' ?>" readonly>
            </div>

            <div class="col-md-4">
                <label for="tenDoAn" class="form-label">Tên Đồ Án</label>
                <input type="text" id="tenDeTai" class="form-control form-control-sm" value="<?= $doan['tenDeTai'] ?? '' ?>" readonly>
            </div>

            <div class="col-md-4">
                <label for="giangVien" class="form-label">Tên Giảng Viên</label>
                <input type="text" id="tenGiangVien" class="form-control form-control-sm" value="<?= $doan['tenGiangVien'] ?? '' ?>" readonly>
            </div>
        </div>
        <!-- </fieldset> -->

        <div class="mb-3">
            <label for="ngayNop" class="form-label">Ngày Nộp</label>
            <input type="date" class="form-control" id="ngayNop" name="ngayNop"
                value="<?= !empty($doan['ngayNop']) ? date('Y-m-d', strtotime($doan['ngayNop'])) : '' ?>">


        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên Sinh Viên</th>
                <th scope="col">Điểm</th>
                <th scope="col">Trạng Thái</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sinhVienList) && is_array($sinhVienList)): ?>
                <?php foreach ($sinhVienList as $sv): ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($sv['maDA'] ?? 'N/A') ?></th>
                        <td><?= htmlspecialchars($sv['hoTen'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($sv['diem'] ?? 'Chưa có') ?></td>
                        <td><?= htmlspecialchars($sv['trangThaiDiem'] ?? 'Chưa cập nhật') ?></td>

                        <td>
                            <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editDoAnModal"
                                data-id="<?php echo $sv['maDA']; ?>"
                                data-maSV="<?php echo $sv['maSV']; ?>"
                                data-hoTen="<?php echo $sv['hoTen']; ?>"
                                data-diem="<?php echo $sv['diem'] ?>"
                                data-trangThaiDiem="<?php echo $sv['trangThaiDiem'] ?>"> <i class="fa-solid fa-pen"></i>
                            </button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
    <form action="<?= base_url('quan-ly-do-an/quaylai') ?>" method="POST">
        <div class="d-flex align-items-center justify-content-end gap-2">
            <button type="submit" name="quaylai" value="cancel" class="btn btn-secondary">Quay lại</button>
        </div>
    </form>

</div>
<div class="modal fade" id="editDoAnModal" tabindex="-1" aria-labelledby="editDoAnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDoAnModalLabel">Chỉnh Sửa Đồ Án</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDoAnForm" method="POST" action="<?= base_url('quan-ly-do-an/edit-do-an') ?>">
                    <?= csrf_field() ?>
                    <!-- <input type="hidden" name="hoTen" id="hoTen"> -->
                    <input type="hidden" name="maDA" id="maDAEdit" value="<?= $sv['maDA'] ?? '' ?>">
                    <input type="hidden" name="maSV" id="maSVEdit" value="<?= $sv['maSV'] ?? '' ?>">

                    <div class="mb-3">
                        <label for="diemEdit" class="form-label">Điểm</label>
                        <input type="text" class="form-control" id="diemEdit" name="diem">
                    </div>
                    <?php
                    $trangThaiHienTai = isset($detai['trangThaiDiem']) ? $detai['trangThaiDiem'] : 'ChuaNop';
                    ?>
                    <div class="mb-3">
                        <label for="trangThaiEdit" class="form-label">Trạng Thái Đồ Án</label>
                        <select id="trangThaiEdit" name="trangThaiDiem" class="form-select" required>
                            <option value="ChuaNop" <?= ($trangThaiHienTai == 'ChuaNop') ? 'selected' : ''; ?>>Chưa Nộp</option>
                            <option value="DaNop" <?= ($trangThaiHienTai == 'DaNop') ? 'selected' : ''; ?>>Đã Nộp</option>
                            <option value="DaCham" <?= ($trangThaiHienTai == 'DaCham') ? 'selected' : ''; ?>>Đã Chấm</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if (session()->getFlashdata('message') || session()->getFlashdata('error')): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast" id="coreuiToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <div class="rounded me-2 <?= session()->getFlashdata('message_type') === 'error' ? 'bg-danger' : 'bg-success' ?>" style="width: 20px; height: 20px;"></div>
                <strong class="me-auto">Thông Báo</strong>
                <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= session()->getFlashdata('message_type') === 'error' ? session()->getFlashdata('message') : session()->getFlashdata('message'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.getElementById('coreuiToast');

        if (toastEl) {
            var toast = new coreui.Toast(toastEl);
            toast.show();
        }

        // Edit
        const editButtons = document.querySelectorAll('[data-coreui-toggle="modal"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maDA = this.getAttribute('data-maDA');
                const maSV = this.getAttribute('data-maSV');
                const hoTen = this.getAttribute('data-hoTen');
                const maGiangVien = this.getAttribute('data-maGiangVien');
                const tenGiangVien = this.getAttribute('data-tenGiangVien');
                const maDT = this.getAttribute('data-maDT');
                const tenDeTai = this.getAttribute('data-tenDeTai');
                const diem = this.getAttribute('data-diem');
                const trangThaiDiem = this.getAttribute('data-trangThaiDiem');

                console.log(maDA);
                console.log(hoTen);
                console.log(maSV);

                document.getElementById('tenSinhVienEdit').value = tenSinhVien;
                document.getElementById('diemEdit').value = diem;
                document.getElementById('maSVEdit').value = maSV;
                document.getElementById('trangThaiEdit').value = trangThaiDiem;

            });
        });


    });
</script>
<?= $this->endSection() ?>