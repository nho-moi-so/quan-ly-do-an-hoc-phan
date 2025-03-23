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

<div class="container border-top pt-4">
    <div class="filter mb-4">
        <form action="<?= base_url('/quan-ly-de-tai/timkiem') ?>" method="GET">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="maNganh">Ngành:</label>
                            <select name="maNganh" id="maNganh" class="form-control">
                                <option value="all">Tất cả ngành</option>
                                <?php if ($nganh): ?>
                                    <?php foreach ($nganh as $n): ?>
                                        <option value="<?= $n['maNganh']; ?>"><?= $n['tenNganh']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="hocKi">Học Kỳ:</label>
                            <select name="hocKi" id="hocKi" class="form-control">
                                <option value="all">Tất cả học kỳ</option>
                                <option value="1">Học Kỳ 1</option>
                                <option value="2">Học Kỳ 2</option>
                                <option value="Hè">Học kỳ hè</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="namHoc">Năm Học:</label>
                            <select name="namHoc" id="namHoc" class="form-control">
                                <option value="all">Tất cả năm học</option>
                                <?php if (!empty($namHoc)): ?>
                                    <?php foreach ($namHoc as $nh): ?>
                                        <option value="<?= $nh['namHoc']; ?>"><?= $nh['namHoc']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-end h-100">
                        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <?php
    $currentNamHoc = null;
    $currentHocKi = null;
    ?>

    <?php if (!empty($detai)): ?>
        <?php foreach ($detai as $dt): ?>

            <?php
            $currentNamHoc = $dt['namHoc'];
            $currentHocKi = $dt['hocKi'];
            ?>

            <h5 class="nam-hoc mt-5 mb-3">Năm học: <?php echo $currentNamHoc; ?> - Học kỳ: <?php echo $currentHocKi; ?></h5>
            <div class="container p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col" style="width: 20%;">Tên Đề Tài</th>
                            <th scope="col" style="width: 20%;">Mô Tả</th>
                            <th scope="col" style="width: 15%;">Giảng Viên</th>
                            <th scope="col" style="width: 20%;">Chuyên Ngành</th>
                            <th scope="col" style="width: 20%;">Hành Động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row"><?php echo $dt['maDT']; ?></th>
                            <td><?php echo $dt['tenDeTai']; ?></td>
                            <td><?php echo $dt['moTa']; ?></td>
                            <td><?php echo $dt['hoTen']; ?></td>
                            <td><?php echo $dt['tenNganh']; ?></td>
                            <td>
                                <div class="d-flex justify-items-between align-items-center gap-2">
                                    <?php if (session()->get('role') == 'GiangVien' || session()->get('role') == 'Admin'): ?>
                                        <button
                                            class="btn btn-sm btn-primary"
                                            title="Sửa"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#editDeTaiModal"
                                            data-id="<?php echo $dt['maDT']; ?>"
                                            data-tenDeTai="<?php echo $dt['tenDeTai']; ?>"
                                            data-moTa="<?php echo $dt['moTa']; ?>"
                                            data-maGiangVien="<?php echo $dt['maGiangVien']; ?>"
                                            data-hoTen="<?php echo $dt['hoTen']; ?>"
                                            data-maNganh="<?php echo $dt['maNganh']; ?>"
                                            data-tenNganh="<?php echo $dt['tenNganh']; ?>"
                                            data-hocKi="<?php echo $dt['hocKi']; ?>"
                                            data-namHoc="<?php echo $dt['namHoc']; ?>"> <i class="fa-solid fa-pen"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if (session()->get('role') == 'GiangVien' || session()->get('role') == 'Admin'): ?>
                                        <button
                                            class="btn btn-sm btn-danger text-light"
                                            title="Xóa"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#deleteDeTaiModal"
                                            data-id="<?php echo $dt['maDT']; ?>"
                                            data-tenDeTai="<?php echo $dt['tenDeTai']; ?>"
                                            data-moTa="<?php echo $dt['moTa']; ?>"
                                            data-maGiangVien="<?php echo $dt['maGiangVien']; ?>"
                                            data-maNganh="<?php echo $dt['maNganh']; ?>"
                                            data-tenNganh="<?php echo $dt['tenNganh']; ?>"
                                            data-hocKi="<?php echo $dt['hocKi']; ?>"
                                            data-namHoc="<?php echo $dt['namHoc']; ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                    <form method="POST" action="quan-ly-do-an/dang-ki-do-an">
                                        <input type="hidden" name="maDT" value="<?php echo $dt['maDT']; ?>">
                                        <input type="hidden" name="tenDeTai" value="<?php echo $dt['tenDeTai']; ?>">
                                        <input type="hidden" name="moTa" value="<?php echo $dt['moTa']; ?>">
                                        <input type="hidden" name="maGiangVien" value="<?php echo $dt['maGiangVien']; ?>">
                                        <input type="hidden" name="maNganh" value="<?php echo $dt['maNganh']; ?>">
                                        <input type="hidden" name="hocKi" value="<?php echo $dt['hocKi']; ?>">
                                        <input type="hidden" name="namHoc" value="<?php echo $dt['namHoc']; ?>">
                                        <input type="hidden" name="maSV" value="<?php echo session()->get('maSV'); ?>">

                                        <?php if (session()->get('role') == 'GiangVien' || session()->get('role') == 'SinhVien'): ?>
                                            <button type="submit" class="btn btn-sm btn-success text-light" title="Đăng ký">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="<?= base_url('quan-ly-do-an/') ?>" class="btn btn-sm btn-info text-light" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Add New Khoa Modal -->
<?php if (session()->get('role') == 'GiangVien' || session()->get('role') == 'Admin'): ?>
    <div class="modal fade" id="addDeTaiModal" tabindex="-1" aria-labelledby="addDeTaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
                        <label for="tenNganh" class="form-label">Ngành</label>
                        <select id="tenNganh" name="maNganh" class="form-select" required>
                            <?php if ($nganh): ?>
                                <?php foreach ($nganh as $n): ?>
                                    <option value="<?php echo $n['maNganh']; ?>"><?php echo $n['tenNganh']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="hocKi" class="form-label">Học Kì</label>
                        <select id="hocKi" name="hocKi" class="form-select" required>
                            <option value="null">Chọn học kỳ</option>
                            <option value="1">Học Kỳ 1</option>
                            <option value="2">Học Kỳ 2</option>
                            <option value="Hè">Học kỳ hè</option>
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
   
<?php endif; ?>

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
                        <label for="tenNganhEdit" class="form-label">Ngành</label>
                        <select id="tenNganhEdit" name="maNganh" class="form-select" required>
                            <?php if ($nganh): ?>
                                <?php foreach ($nganh as $n): ?>
                                    <option value="<?php echo $n['maNganh']; ?>"><?php echo $n['tenNganh']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="hocKiEdit" class="form-label">Học Kì</label>
                        <select id="hocKiEdit" name="hocKi" class="form-select" required>
                            <option value="null">Chọn học kỳ</option>
                            <option value="1">Học Kỳ 1</option>
                            <option value="2">Học Kỳ 2</option>
                            <option value="Hè">Học kỳ hè</option>
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
                const maNganh = this.getAttribute('data-maNganh');
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
                document.getElementById('tenNganhEdit').value = tenNganh;
                document.getElementById('moTaEdit').value = moTa;
                document.getElementById('namHocEdit').value = namHoc;
                document.getElementById('hocKiEdit').value = hocKi;



                for (let option of selectGiangVien.options) {
                    if (option.value == maGiangVien) {
                        option.selected = true;
                        break;
                    }
                }
                for (let option of selectNganh.options) {
                    if (option.value == maNganh) {
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
                const maNganh = this.getAttribute('data-maNganh');
                const hocKi = this.getAttribute('data-hocKi');



                document.getElementById('maDTDelete').value = maDT;
                document.getElementById('tenDeTaiToDelete').textContent = tenDeTai;
                document.getElementById('deleteDeTaiForm').action = "<?= base_url('quan-ly-de-tai/delete-de-tai/') ?>" + maDT;
            });
        });
    });
</script>h
<?= $this->endSection() ?>