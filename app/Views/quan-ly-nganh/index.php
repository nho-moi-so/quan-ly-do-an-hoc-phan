<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="title">
            <h4 class="text-center">Quản Lý Ngành</h4>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addNganhModal">Thêm Ngành Mới</button>
        </div>
    </div>
</div>

<div class="container border-top pt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Ngành</th>
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($nganh): ?>
                <?php foreach ($nganh as $n): ?>
                    <tr>
                        <th scope="row"><?php echo $n['maNganh']; ?></th>
                        <td><?php echo $n['tenNganh']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editNganhModal"
                                data-id="<?php echo $n['maNganh']; ?>"
                                data-tenNganh="<?php echo $n['tenNganh']; ?>"> <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-danger text-light"
                                data-coreui-toggle="modal"
                                data-coreui-target="#deleteNganhModal"
                                data-id="<?php echo $n['maNganh']; ?>"
                                data-tenNganh="<?php echo $n['tenNganh']; ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            <a href="<?= base_url('quan-ly-lop/' . $n['maNganh']) ?>" class="btn btn-sm btn-success" style="background-color:rgb(53, 65, 157); color: white;">
                                <i class="fa-solid fa-eye"></i> Xem Lớp
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


</div>

<!-- Add New Khoa Modal -->
<div class="modal fade" id="addNganhModal" tabindex="-1" aria-labelledby="addNganhModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNganhModalLabel">Thêm Ngành Mới</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('quan-ly-nganh/add-nganh') ?>" method="POST">
                <input type="hidden" name="maKhoa" value="<?= $maKhoa ?? '' ?>"> 
                    <div class="mb-3">
                        <label for="tenNganh" class="form-label">Tên Ngành</label>
                        <input type="text" class="form-control" id="tenNganh" name="tenNganh" required>
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

<!-- Edit Khoa Modal -->
<div class="modal fade" id="editNganhModal" tabindex="-1" aria-labelledby="editNganhModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNganhModalLabel">Chỉnh Sửa Ngành</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editNganhForm" method="POST" action="<?= base_url('quan-ly-nganh/edit-nganh') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="maNganh" id="maNganh">
                    <div class="mb-3">
                        <label for="tenNganhEdit" class="form-label">Tên Ngành</label>
                        <input type="text" class="form-control" id="tenNganhEdit" name="tenNganh" required>
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
<div class="modal fade" id="deleteNganhModal" tabindex="-1" aria-labelledby="deleteNganhModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNganhModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Ngành <strong id="tenNganhToDelete"></strong> không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteNganhForm" method="GET" action="">
                    <input type="hidden" name="maNganh" id="maNganhDelete" value="">
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
                const maNganh = this.getAttribute('data-id');
                const tenNganh = this.getAttribute('data-tenNganh');

                console.log(maNganh);
                console.log(tenNganh);


                document.getElementById('maNganh').value = maNganh;
                document.getElementById('tenNganhEdit').value = tenNganh;

            });
        });

        // Delete 
        const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteNganhModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maNganh = this.getAttribute('data-id');
                const tenNganh = this.getAttribute('data-tenNganh');

                document.getElementById('maNganhDelete').value = maNganh;
                document.getElementById('tenNganhToDelete').textContent = tenNganh;
                document.getElementById('deleteNganhForm').action = "<?= base_url('quan-ly-nganh/delete-nganh/') ?>" + maNganh;
            });
        });
    });
</script>h
<?= $this->endSection() ?>