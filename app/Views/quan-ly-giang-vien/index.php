<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="title">
            <h4 class="text-center">Quản Lý Giảng Viên</h4>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addGiangVienModal">Thêm Giảng Viên Mới</button>
        </div>
    </div>
</div>

<div class="container border-top pt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Giảng Viên</th>
                <th scope="col">Tên Bộ Môn</th>
                <th scope="col">Email</th>
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($giangvien): ?>
                <?php foreach ($giangvien as $gv): ?>
                    <tr>
                        <th scope="row"><?php echo $gv['maGiangVien']; ?></th>
                        <td><?php echo $gv['hoTen']; ?></td>
                        <td><?php echo $gv['tenBoMon']; ?></td>
                        <td><?php echo $gv['email']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editGiangVienModal"
                                data-id="<?php echo $gv['maGiangVien']; ?>"
                                data-hoTen="<?php echo $gv['hoTen']; ?>"
                                data-maBoMon="<?php echo $gv['maBoMon']; ?>"
                                data-tenBoMon="<?php echo $gv['tenBoMon']; ?>"
                                data-email="<?php echo $gv['email']; ?>"> <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-danger text-light"
                                data-coreui-toggle="modal"
                                data-coreui-target="#deleteGiangVienModal"
                                data-id="<?php echo $gv['maGiangVien']; ?>"
                                data-hoTen="<?php echo $gv['hoTen']; ?>"
                                data-email="<?php echo $gv['email']; ?>">
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
<div class="modal fade" id="addGiangVienModal" tabindex="-1" aria-labelledby="addGiangVienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGiangVienModalLabel">Thêm Giảng Viên Mới</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('quan-ly-giang-vien/add-giang-vien') ?>" method="POST">
                    <div class="mb-3">
                        <label for="hoTen" class="form-label">Tên Giảng Viên</label>
                        <input type="text" class="form-control" id="hoTen" name="hoTen" required>

                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>

                        <label for="chonBoMon" class="form-label">Bộ Môn</label>
                        <select id="chonBoMon" name="maBoMon" class="form-select" required>
                            <?php if ($bomon): ?>
                                <?php foreach ($bomon as $bm): ?>
                                    <option value="<?php echo $bm['maBoMon']; ?>"><?php echo $bm['tenBoMon']; ?></option>
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

<!-- Edit Bộ Môn Modal -->
<div class="modal fade" id="editGiangVienModal" tabindex="-1" aria-labelledby="editGiangVienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGiangVienModalLabel">Chỉnh Sửa Giảng Viên</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editGiangVienForm" method="POST" action="<?= base_url('quan-ly-giang-vien/edit-giang-vien') ?>">
                    <?= csrf_field() ?>
                    <!-- <input type="hidden" name="maUser" id="maUser"> -->
                    <input type="hidden" name="maGiangVien" id="maGiangVienEdit">
                    <div class="mb-3">
                        <label for="hoTenEdit" class="form-label">Tên Giảng Viên</label>
                        <input type="text" class="form-control" id="hoTenEdit" name="hoTen" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailEdit" class="form-label">Email</label>
                        <input type="text" class="form-control" id="emailEdit" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="chonBoMonEdit" class="form-label">Bộ Môn</label>
                        <select id="chonBoMonEdit" name="maBoMon" class="form-select" required>
                            <?php if ($bomon): ?>
                                <?php foreach ($bomon as $bm): ?>
                                    <option value="<?php echo $bm['maBoMon']; ?>"><?php echo $bm['tenBoMon']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
<div class="modal fade" id="deleteGiangVienModal" tabindex="-1" aria-labelledby="deleteGiangVienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGiangVienModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Giảng Viên <strong id="hoTenToDelete"></strong> không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteGiangVienForm" method="GET" action="">
                    <input type="hidden" name="maGiangVien" id="maGiangVienDelete" value="">
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
                const maGiangVien = this.getAttribute('data-id');
                const hoTen = this.getAttribute('data-hoTen');
                const maBoMon = this.getAttribute('data-maBoMon');
                const tenBoMon = this.getAttribute('data-tenBoMon');
                const email = this.getAttribute('data-email');
                const selectBoMon = document.getElementById("chonBoMonEdit");

                console.log(maGiangVien);
                console.log(hoTen);
                console.log(tenBoMon);
                console.log(email);

                document.getElementById('maGiangVienEdit').value = maGiangVien;
                document.getElementById('hoTenEdit').value = hoTen;
                document.getElementById('emailEdit').value = email;

                for (let option of selectBoMon.options) {
                    if (option.value == maBoMon) {
                        option.selected = true;
                        break;
                    }
                }
            });
        });

        // Delete 
        const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteGiangVienModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maGiangVien = this.getAttribute('data-id');
                const hoTen = this.getAttribute('data-hoTen');
                const email = this.getAttribute('data-email');

                document.getElementById('maGiangVienDelete').value = maGiangVien;
                document.getElementById('hoTenToDelete').textContent = hoTen;
                document.getElementById('deleteGiangVienForm').action = "<?= base_url('quan-ly-giang-vien/delete-giang-vien/') ?>" + maGiangVien;
            });
        });
    });
</script>h
<?= $this->endSection() ?>