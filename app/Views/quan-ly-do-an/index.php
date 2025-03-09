<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="title">
            <h4 class="text-center">Quản Lý Đồ Án</h4>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addDoAnModal">Thêm Đồ Án Mới</button>
        </div>
    </div>
</div>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?= $trangThai == 1 ? 'active' : '' ?>" href="/quan-ly-do-an">Đang Đợi Duyệt</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $trangThai == 2 ? 'active' : '' ?>" href="/quan-ly-do-an?trangThai=2">Đã Duyệt</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $trangThai == 3 ? 'active' : '' ?>" href="/quan-ly-do-an?trangThai=3">Đã Hủy</a>
    </li>
</ul>

<div class="container border-top pt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <!-- <th scope="col">Đồ Án</th> -->
                <th scope="col">Tên Đề Tài</th>
                <th scope="col">Sinh Viên Thực Hiện</th>
                <th scope="col">Giảng Viên Hướng Dẫn</th>
                <!-- <th scope="col">Lớp</th> -->
                <th scope="col">Trạng Thái</th>
                <th scope="col">Thời Gian Đăng Ký</th>
                <th scope="col">Hoạt Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($doan): ?>
                <?php foreach ($doan as $da): ?>
                    <tr>
                        <th scope="row"><?php echo $da['maDA']; ?></th>
                        <td><?php echo $da['tenDeTai']; ?></td>
                        <td><?php echo $da['tenSinhVien'] ?? 'N/A'; ?></td>
                        <td><?php echo $da['tenGiangVien'] ?? 'N/A'; ?></td>
                        <td><?php echo $da['trangThai']; ?></td>
                        <td><?php echo $da['thoigianDangKi']; ?></td>
                        <td>
                            <form method="POST" action="quan-ly-do-an/cap-nhat-trang-thai">
                                <input type="hidden" name="maDA" value="<?php echo $da['maDA']; ?>">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fa-solid fa-check"></i> Đồng Ý
                                </button>
                            </form>
                            <form method="POST" action="quan-ly-do-an/tu-choi" style="margin-top:10px">
                                <input type="hidden" name="maDA" value="<?php echo $da['maDA']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-check"></i> Từ Chối
                                </button>
                            </form>
                            <form method="POST" action="quan-ly-do-an/huy-dang-ki" style="margin-top:10px">
                                <input type="hidden" name="maDA" value="<?php echo $da['maDA']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-check"></i> Hủy Đăng Ký
                                </button>
                            </form>


                            <a href="<?= base_url('quan-ly-do-an/chi-tiet-do-an/' . $da['maDA']) ?>" class="btn btn-sm btn-success" style="margin-top:10px">
                                <i class="fa-solid fa-eye"></i> Xem Chi Tiết
                            </a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


</div>

<!-- Add New Khoa Modal -->
<div class="modal fade" id="addDoAnModal" tabindex="-1" aria-labelledby="addDoAnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDoAnModalLabel">Thêm Đồ Án Mới</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('quan-ly-do-an/add-do-an') ?>" method="POST">
                    <div class="mb-3">
                        <label for="tenDeTai" class="form-label">Tên Đề tài</label>
                        <select id="tenDeTai" name="maDT" class="form-select" required>
                            <?php if ($detai): ?>
                                <?php foreach ($detai as $dt): ?>
                                    <option value="<?php echo $dt['maDT']; ?>"><?php echo $dt['tenDeTai']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tenSinhVien" class="form-label">Sinh Viên Thực Hiện</label>
                        <select id="tenSinhVien" name="maSV" class="form-select" required>
                            <?php if ($sinhvien): ?>
                                <?php foreach ($sinhvien as $sv): ?>
                                    <option value="<?php echo $sv['maSV']; ?>"><?php echo $sv['hoTen']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="tenGiangVien" class="form-label">Giảng Viên</label>
                        <select id="tenGiangVien" name="maGiangVien" class="form-select" required>
                            <?php if ($giangvien): ?>
                                <?php foreach ($giangvien as $gv): ?>
                                    <option value="<?php echo $gv['maGiangVien']; ?>"><?php echo $gv['hoTen']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>

            </div>
            <!-- <div class="modal-footer">
            </div> -->
        </div>
    </div>
</div>

<!-- Edit Giảng Viên Modal -->
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
                    <input type="hidden" name="maDA" id="maDAEdit">
                    <div class="mb-3">
                        <label for="tenDeTaiEdit" class="form-label">Tên Đề tài</label>
                        <select id="tenDeTaiEdit" name="maDT" class="form-select" required>
                            <?php if ($detai): ?>
                                <?php foreach ($detai as $dt): ?>
                                    <option value="<?php echo $dt['maDT']; ?>"><?php echo $dt['tenDeTai']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tenSinhVienEdit" class="form-label">Sinh Viên Thực Hiện</label>
                        <select id="tenSinhVienEdit" name="maSV" class="form-select" required>
                            <?php if ($sinhvien): ?>
                                <?php foreach ($sinhvien as $sv): ?>
                                    <option value="<?php echo $sv['maSV']; ?>"><?php echo $sv['hoTen']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tenGiangVienEdit" class="form-label">Giảng Viên</label>
                        <select id="tenGiangVienEdit" name="maGiangVien" class="form-select" required>
                            <?php if ($giangvien): ?>
                                <?php foreach ($giangvien as $gv): ?>
                                    <option value="<?php echo $gv['maGiangVien']; ?>"><?php echo $gv['hoTen']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="diemEdit" class="form-label">Điểm</label>
                        <input type="text" class="form-control" id="diemEdit" name="diem">
                    </div>
                    <div class="mb-3">
                        <label for="ngayNopEdit" class="form-label">Ngày Nộp:</label>
                        <input type="date" name="ngayNop" id="ngayNopEdit" class="form-control" required>
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

<!-- Delete Khoa Modal -->
<div class="modal fade" id="deleteDoAnModal" tabindex="-1" aria-labelledby="deleteDoAnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDoAnModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Đồ Án <strong id="tenDoAnToDelete"></strong> không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteDoAnForm" method="GET" action="">
                    <input type="hidden" name="maDA" id="maDADelete" value="">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
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

<!-- Toast script -->
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
                const maDA = this.getAttribute('data-id');
                const tenDoAn = this.getAttribute('data-tenDoAn');
                const maDT = this.getAttribute('data-maDT');
                const tenDeTai = this.getAttribute('data-tenDeTai');
                const selectDeTai = document.getElementById("tenDeTaiEdit");
                const maGiangVien = this.getAttribute('data-maGiangVien');
                const maSV = this.getAttribute('data-maSV');
                const tenSinhVien = this.getAttribute('data-tenSinhVien');
                const tenGiangVien = this.getAttribute('data-tenGiangVien');
                const selectSinhVien = document.getElementById("tenSinhVienEdit");
                const selectGiangVien = document.getElementById("tenGiangVienEdit");
                const diem = this.getAttribute('data-diem');
                const ngayNop = this.getAttribute('data-ngayNop');
                const trangThaiDiem = this.getAttribute('data-trangThaiDiem');

                console.log(maDA);
                console.log(tenDoAn);
                console.log(maGiangVien);
                console.log(tenSinhVien);
                console.log(ngayNop);
                console.log(maSV);


                document.getElementById('maDAEdit').value = maDA;
                document.getElementById('tenDeTaiEdit').value = tenDeTai;
                document.getElementById('tenGiangVienEdit').value = tenGiangVien;
                document.getElementById('tenSinhVienEdit').value = tenSinhVien;
                document.getElementById('diemEdit').value = diem;
                document.getElementById('ngayNopEdit').value = ngayNop;
                document.getElementById('trangThaiEdit').value = trangThaiDiem;

                for (let option of selectDeTai.options) {
                    if (option.value == maDT) {
                        option.selected = true;
                        break;
                    }
                }
                for (let option of selectSinhVien.options) {
                    if (option.value == maSV) {
                        option.selected = true;
                        break;
                    }
                }
                for (let option of selectGiangVien.options) {
                    if (option.value == maGiangVien) {
                        option.selected = true;
                        break;
                    }
                }
            });
        });

        // Delete 
        const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteDoAnModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maDA = this.getAttribute('data-id');
                const maDT = this.getAttribute('data-maDT');
                const tenDoAn = this.getAttribute('data-tenDoAn');
                const maSV = this.getAttribute('data-maSV');
                const tenSinhVien = this.getAttribute('data-tenSinhVien');
                const maGiangVien = this.getAttribute('data-maGiangVien');


                document.getElementById('maDADelete').value = maDA;
                document.getElementById('tenDoAnToDelete').textContent = tenDoAn;
                document.getElementById('deleteDoAnForm').action = "<?= base_url('quan-ly-do-an/delete-do-an/') ?>" + maDA;
            });
        });
    });
</script>
<?= $this->endSection() ?>