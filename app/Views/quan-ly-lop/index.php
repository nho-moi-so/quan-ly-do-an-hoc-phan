<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="title">
            <h4 class="text-center">Quản Lý Lớp</h4>
        </div>

        <div>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addLopModal">Thêm Lớp Mới</button>
        </div>
    </div>
</div>

<div class="container border-top pt-4">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Lớp</th>
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($lop): ?>
                <?php foreach ($lop as $l): ?>
                    <tr>
                        <th scope="row"><?php echo $l['maLop']; ?></th>
                        <td><?php echo $l['tenLop']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editLopModal"
                                data-id="<?php echo $l['maLop']; ?>"
                                data-tenLop="<?php echo $l['tenLop']; ?>"> <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-danger text-light"
                                data-coreui-toggle="modal"
                                data-coreui-target="#deleteLopModal"
                                data-id="<?php echo $l['maLop']; ?>"
                                data-tenLop="<?php echo $l['tenLop']; ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


</div>

<!-- Add New Ngành Modal -->
<div class="modal fade" id="addLopModal" tabindex="-1" aria-labelledby="addLopModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLopModalLabel">Thêm Lớp Mới</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('quan-ly-lop/add-lop/') ?>" method="POST">
                <input type="hidden" name="maNganh" value="<?= $maNganh ?>"> 
                    <div class="mb-3">
                        <label for="tenLop" class="form-label">Tên Lớp</label>
                        <input type="text" class="form-control" id="tenLop" name="tenLop" required>
                       
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

<!-- Edit Ngành Modal -->
<div class="modal fade" id="editLopModal" tabindex="-1" aria-labelledby="editNganhModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNganhModalLabel">Chỉnh Sửa Lớp</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editNganhForm" method="POST" action="<?= base_url('quan-ly-lop/edit-lop') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="maLop" id="maLop">
                    <div class="mb-3">
                        <label for="tenLopEdit" class="form-label">Tên Lớp</label>
                        <input type="text" class="form-control" id="tenLopEdit" name="tenLop" required>
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

<!-- Delete Ngành Modal -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLopModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLopModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Lớp <strong id="tenLopToDelete"></strong> không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteLopForm" method="GET" action="">
                    <input type="hidden" name="maLop" id="maLopDelete" value="">
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
                const maLop = this.getAttribute('data-id');
                const tenLop = this.getAttribute('data-tenLop');
           

                console.log(maLop);
                console.log(tenLop);
             

                document.getElementById('maLop').value = maLop;
                document.getElementById('tenLopEdit').value = tenLop;
               
            });
        });

        // Delete 
        const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteLop"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maLop = this.getAttribute('data-id');
                const tenLop = this.getAttribute('data-tenLop');

                document.getElementById('maLopDelete').value = maLop;
                document.getElementById('tenLopToDelete').textContent = tenLop;
                document.getElementById('deleteLopForm').action = "<?= base_url('quan-ly-lop/delete-lop/') ?>" + maLop;
            });
        });
    });
</script>
<?= $this->endSection() ?>