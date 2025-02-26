<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="title">
            <h4 class="text-center">Quản Lý Sinh Viên</h4>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addSinhVienModal">Thêm Sinh Viên Mới</button>
        </div>
    </div>
</div>

<div class="container border-top pt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Sinh Viên</th>
                <th scope="col">Tên Lớp</th>
                <th scope="col">Email</th>
                <th scope="col">Giới Tính</th>
                <th scope="col">Ngày Sinh</th>
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($sinhvien): ?>
                <?php foreach ($sinhvien as $sv): ?>
                    <tr>
                        <th scope="row"><?php echo $sv['maSV']; ?></th>
                        <td><?php echo $sv['hoTen']; ?></td>
                        <td><?php echo $sv['tenLop']; ?></td>
                        <td><?php echo $sv['email']; ?></td>
                        <td><?php echo $sv['gioiTinh']; ?></td>
                        <td><?php echo $sv['ngaySinh']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editSinhVienModal"
                                data-id="<?php echo $sv['maSV']; ?>"
                                data-hoTen="<?php echo $sv['hoTen']; ?>"
                                data-maLop="<?php echo $sv['maLop']; ?>"
                                data-tenLop="<?php echo $sv['tenLop']; ?>"
                                data-email="<?php echo $sv['email']; ?>"
                                data-gioiTinh="<?php echo $sv['gioiTinh']; ?>"
                                data-ngaySinh="<?php echo $sv['ngaySinh']; ?>"> <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-danger text-light"
                                data-coreui-toggle="modal"
                                data-coreui-target="#deleteSinhVienModal"
                                data-id="<?php echo $sv['maSV']; ?>"
                                data-hoTen="<?php echo $sv['hoTen']; ?>"
                                data-email="<?php echo $sv['email']; ?>"
                                data-gioiTinh="<?php echo $sv['gioiTinh']; ?>"
                                data-ngaySinh="<?php echo $sv['ngaySinh']; ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


</div>

<!-- Add New Khoa Modal -->
<div class="modal fade" id="addSinhVienModal" tabindex="-1" aria-labelledby="addSinhVienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSinhVienModalLabel">Thêm Sinh Viên Mới</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('quan-ly-sinh-vien/add-sinh-vien') ?>" method="POST">
                    <div class="mb-3">
                        <label for="hoTen" class="form-label">Tên Sinh Viên</label>
                        <input type="text" class="form-control" id="hoTen" name="hoTen" required>
                    </div>
                    <div class="mb-3">
                        <label for="tenLop" class="form-label">Lớp</label>
                        <select id="tenLop" name="maLop" class="form-select" required>
                            <?php if ($lop): ?>
                                <?php foreach ($lop as $l): ?>
                                    <option value="<?php echo $l['maLop']; ?>"><?php echo $l['tenLop']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="gioiTinh" class="form-label">Giới tính:</label>
                        <select name="gioiTinh" id="gioiTinh" class="form-select" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ngaySinh" class="form-label">Ngày sinh:</label>
                        <input type="date" name="ngaySinh" id="ngaySinh" class="form-control" required>
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

<!-- Edit Lớp Modal -->
<div class="modal fade" id="editSinhVienModal" tabindex="-1" aria-labelledby="editSinhVienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSinhVienModalLabel">Chỉnh Sửa Sinh Viên</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSinhVienForm" method="POST" action="<?= base_url('quan-ly-sinh-vien/edit-sinh-vien') ?>">
                    <?= csrf_field() ?>
                    <!-- <input type="hidden" name="maUser" id="maUser"> -->
                    <input type="hidden" name="maSV" id="maSinhVienEdit">
                    <div class="mb-3">
                        <label for="hoTenEdit" class="form-label">Tên Sinh Viên</label>
                        <input type="text" class="form-control" id="hoTenEdit" name="hoTen" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailEdit" class="form-label">Email</label>
                        <input type="text" class="form-control" id="emailEdit" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="tenLopEdit" class="form-label">Lớp</label>
                        <select id="tenLopEdit" name="maLop" class="form-select" required>
                            <?php if ($lop): ?>
                                <?php foreach ($lop as $l): ?>
                                    <option value="<?php echo $l['maLop']; ?>"><?php echo $l['tenLop']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gioiTinh" class="form-label">Giới tính:</label>
                        <select name="gioiTinh" class="form-control" id="gioiTinhEdit" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ngaySinh" class="form-label">Ngày sinh:</label>
                        <input type="date" name="ngaySinh" class="form-control" id="ngaySinhEdit" required>
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
<div class="modal fade" id="deleteSinhVienModal" tabindex="-1" aria-labelledby="deleteSinhVienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSinhVienModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Sinh Viên <strong id="hoTenToDelete"></strong> không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteSinhVienForm" method="GET" action="">
                    <input type="hidden" name="maSV" id="maSinhVienDelete" value="">
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
                const maSV = this.getAttribute('data-id');
                const hoTen = this.getAttribute('data-hoTen');
                const maLop = this.getAttribute('data-maLop');
                const tenLop = this.getAttribute('data-tenLop');
                const email = this.getAttribute('data-email');
                const gioiTinh = this.getAttribute('data-gioiTinh');
                const ngaySinh = this.getAttribute('data-ngaySinh');
                const selectLop = document.getElementById("tenLopEdit");


                console.log(maSV);
                console.log(hoTen);
                console.log(maLop);
                console.log(tenLop);
                console.log(email);
                console.log(gioiTinh);
                console.log(ngaySinh);


                document.getElementById('maSinhVienEdit').value = maSV;
                document.getElementById('hoTenEdit').value = hoTen;
                document.getElementById('tenLopEdit').value = tenLop;
                document.getElementById('emailEdit').value = email;
                document.getElementById('gioiTinhEdit').value = gioiTinh;
                document.getElementById('ngaySinhEdit').value = ngaySinh;

                for (let option of selectLop.options) {
                    if (option.value == maLop) {
                        option.selected = true;
                        break;
                    }
                }
            });
        });

        // Delete 
        const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteSinhVienModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maSV = this.getAttribute('data-id');
                const hoTen = this.getAttribute('data-hoTen');
                const email = this.getAttribute('data-email');
                const gioiTinh = this.getAttribute('data-gioiTinh');
                const ngaySinh = this.getAttribute('data-ngaySinh');

                document.getElementById('maSinhVienDelete').value = maSV;
                document.getElementById('hoTenToDelete').textContent = hoTen;
                document.getElementById('deleteSinhVienForm').action = "<?= base_url('quan-ly-sinh-vien/delete-sinh-vien/') ?>" + maSV;
            });
        });
    });
</script>h
<?= $this->endSection() ?>