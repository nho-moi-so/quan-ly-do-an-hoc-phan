<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="title">
            <h4 class="text-center">Quản Lý Đề Tài</h4>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addDeTaiModal">Thêm Đề Tài Mới</button>
        </div>
    </div>
</div>
<div class="group">
    <div class="btn-group">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" data-coreui-auto-close="true" aria-expanded="false">
            Chuyên Ngành
        </button>
        <ul class="dropdown-menu">
            <?php foreach ($nganh as $n): ?>
                <li><a class="dropdown-item" href="#"><?= $n['tenNganh']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="btn-group">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" data-coreui-auto-close="inside" aria-expanded="false">
            Học Kì
        </button>
        <?php
        $hocKihientai = isset($detai['hocKi']) ? $detai['hocKi'] : '1';
        ?>
        <ul class="dropdown-menu">
            <option value="1" <?= ($hocKihientai == '1') ? 'selected' : ''; ?>>1</option>
            <option value="2" <?= ($hocKihientai == '2') ? 'selected' : ''; ?>>2</option>
            <option value="Hè" <?= ($hocKihientai == 'Hè') ? 'selected' : ''; ?>>Hè</option>
        </ul>
    </div>

    <div class="btn-group">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" data-coreui-auto-close="outside" aria-expanded="false">
            Năm Học
        </button>
        <ul class="dropdown-menu">
            <?php if (!empty($namHoc)): ?>
                <?php foreach ($namHoc as $nh): ?>
                    <option value="<?= $nh['namHoc']; ?>"><?= $nh['namHoc']; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <div>
        <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#timkiemModal">Tìm Kiếm</button>
    </div>
</div>

<div class="container border-top pt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Đề Tài</th>
                <th scope="col">Mô Tả</th>
                <th scope="col">Giảng Viên</th>
                <th scope="col">Chuyên Ngành</th>
                <th scope="col">Học Kì</th>
                <th scope="col">Năm Học</th>

            </tr>
        </thead>
        <tbody>
            <?php if ($detai): ?>
                <?php foreach ($detai as $dt): ?>
                    <tr>
                        <th scope="row"><?php echo $dt['maDT']; ?></th>
                        <td><?php echo $dt['tenDeTai']; ?></td>
                        <td><?php echo $dt['moTa']; ?></td>
                        <td><?php echo $dt['hoTen']; ?></td>
                        <td><?php echo $dt['tenNganh']; ?></td>
                        <td><?php echo $dt['hocKi']; ?></td>
                        <td><?php echo $dt['namHoc']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editDeTaiModal"
                                data-id="<?php echo $dt['maDT']; ?>"
                                data-tenDeTai="<?php echo $dt['tenDeTai']; ?>"
                                data-moTa="<?php echo $dt['moTa']; ?>"
                                data-maGiangVien="<?php echo $dt['maGiangVien']; ?>"
                                data-hoTen="<?php echo $dt['hoTen']; ?>"
                                data-tenNganh="<?php echo $dt['tenNganh']; ?>"
                                data-hocKi="<?php echo $dt['hocKi']; ?>"
                                data-namHoc="<?php echo $dt['namHoc']; ?>"> <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-danger text-light"
                                data-coreui-toggle="modal"
                                data-coreui-target="#deleteDeTaiModal"
                                data-id="<?php echo $dt['maDT']; ?>"
                                data-tenDeTai="<?php echo $dt['tenDeTai']; ?>"
                                data-moTa="<?php echo $dt['moTa']; ?>"
                                data-maGiangVien="<?php echo $dt['maGiangVien']; ?>"
                                data-tenNganh="<?php echo $dt['tenNganh']; ?>"
                                data-hocKi="<?php echo $dt['hocKi']; ?>"
                                data-namHoc="<?php echo $dt['namHoc']; ?>">
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
<div class="modal fade" id="addDeTaiModal" tabindex="-1" aria-labelledby="addDeTaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeTaiModalLabel">Thêm Đề Tài Mới</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('quan-ly-de-tai/add-de-tai') ?>" method="POST">
                    <div class="mb-3">
                        <label for="tenDeTai" class="form-label">Tên Đề Tài</label>
                        <input type="text" class="form-control" id="tenDeTai" name="tenDeTai" required>
                    </div>

                    <div class="mb-3">
                        <label for="moTa" class="form-label">Mô Tả</label>
                        <input type="text" class="form-control" id="moTa" name="moTa" required>
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

                    <div class="mb-3">
                        <label for="chonNganh" class="form-label">Ngành</label>
                        <select id="chonNganh" name="maNganh" class="form-select" required>
                            <?php if ($nganh): ?>
                                <?php foreach ($nganh as $n): ?>
                                    <option value="<?php echo $n['maNganh']; ?>"><?php echo $n['tenNganh']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <?php
                    $hocKihientai = isset($detai['hocKi']) ? $detai['hocKi'] : '1';
                    ?>
                    <div class="mb-3">
                        <label for="hocKiEdit" class="form-label">Học Kì</label>
                        <select id="hocKiEdit" name="hocKi" class="form-select" required>
                            <option value="1" <?= ($hocKihientai == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= ($hocKihientai == '2') ? 'selected' : ''; ?>>2</option>
                            <option value="Hè" <?= ($hocKihientai == 'Hè') ? 'selected' : ''; ?>>Hè</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="namHoc" class="form-label">Năm Học</label>
                        <input type="text" class="form-control" id="namHoc" name="namHoc" required>
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
<div class="modal fade" id="editDeTaiModal" tabindex="-1" aria-labelledby="editDeTaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeTaiModalLabel">Chỉnh Sửa Đề Tài</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDeTaiForm" method="POST" action="<?= base_url('quan-ly-de-tai/edit-de-tai') ?>">
                    <?= csrf_field() ?>
                    <!-- <input type="hidden" name="hoTen" id="hoTen"> -->
                    <input type="hidden" name="maDT" id="maDTEdit">
                    <div class="mb-3">
                        <label for="tenDeTaiEdit" class="form-label">Tên Đề Tài</label>
                        <input type="text" class="form-control" id="tenDeTaiEdit" name="tenDeTai" required>
                    </div>
                    <div class="mb-3">
                        <label for="moTaEdit" class="form-label">Mô Tả</label>
                        <input type="text" class="form-control" id="moTaEdit" name="moTa" required>
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
                        <label for="chonNganhEdit" class="form-label">Ngành</label>
                        <select id="chonNganhEdit" name="maNganh" class="form-select" required>
                            <?php if ($nganh): ?>
                                <?php foreach ($nganh as $n): ?>
                                    <option value="<?php echo $n['maNganh']; ?>"><?php echo $n['tenNganh']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <?php
                    $hocKihientai = isset($detai['hocKi']) ? $detai['hocKi'] : '1';
                    ?>
                    <div class="mb-3">
                        <label for="hocKiEdit" class="form-label">Học Kì</label>
                        <select id="hocKiEdit" name="hocKi" class="form-select" required>
                            <option value="1" <?= ($hocKihientai == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= ($hocKihientai == '2') ? 'selected' : ''; ?>>2</option>
                            <option value="Hè" <?= ($hocKihientai == 'Hè') ? 'selected' : ''; ?>>Hè</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="namHocEdit" class="form-label">Năm Học</label>
                        <select id="namHocEdit" name="namHoc" class="form-select" required>
                            <?php if (!empty($namHoc)): ?>
                                <?php foreach ($namHoc as $nh): ?>
                                    <option value="<?= $nh['namHoc']; ?>"><?= $nh['namHoc']; ?></option>
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
<div class="modal fade" id="deleteDeTaiModal" tabindex="-1" aria-labelledby="deleteDeTaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDeTaiModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Đề Tài <strong id="tenDeTaiToDelete"></strong> không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteDeTaiForm" method="GET" action="">
                    <input type="hidden" name="maDT" id="maDTDelete" value="">
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
                const maDT = this.getAttribute('data-id');
                const tenDeTai = this.getAttribute('data-tenDeTai');
                const maGiangVien = this.getAttribute('data-maGiangVien');
                const moTa = this.getAttribute('data-moTa');
                const namHoc = this.getAttribute('data-namHoc');
                const hocKi = this.getAttribute('data-hocKi');
                const selectGiangVien = document.getElementById("tenGiangVienEdit");
                const selectNganh = document.getElementById("tenNganhEdit");
                const selectnamHoc = document.getElementById("namHocEdit");
                const tenNganh = this.getAttribute('data-tenNganh');

                console.log(maDT);
                console.log(tenDeTai);
                console.log(maGiangVien);
                console.log(moTa);
                console.log(tenNganh);
                console.log(namHoc);
                console.log(hocKi);

                document.getElementById('maDTEdit').value = maDT;
                document.getElementById('tenDeTaiEdit').value = tenDeTai;
                document.getElementById('tenGiangVienEdit').value = tenGiangVien;
                document.getElementById('moTaEdit').value = moTa;
                document.getElementById('namHocEdit').value = namHoc;


                for (let option of selectGiangVien.options) {
                    if (option.value == maGiangVien) {
                        option.selected = true;
                        break;
                    }
                }

                // for (let option of selectNganh.options) {
                //     if (option.value == maNganh) {
                //         option.selected = true;
                //         break;
                //     }
                // }
            });
        });

        // Delete 
        const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteDeTaiModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maDT = this.getAttribute('data-id');
                const tenDeTai = this.getAttribute('data-tenDeTai');
                const moTa = this.getAttribute('data-moTa');
                const maGiangVien = this.getAttribute('data-maGiangVien');


                document.getElementById('maDTDelete').value = maDT;
                document.getElementById('tenDeTaiToDelete').textContent = tenDeTai;
                document.getElementById('deleteDeTaiForm').action = "<?= base_url('quan-ly-de-tai/delete-de-tai/') ?>" + maDT;
            });
        });
    });
</script>h
<?= $this->endSection() ?>