<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Quản Lý Bộ Môn
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
  <div class="d-flex align-items-center justify-content-between">
    <div class="title">
      <h4 class="text-center">Quản Lý Bộ Môn</h4>
    </div>
    <div>
      <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addBoMonModal">Thêm Bộ Môn Mới</button>
    </div>
  </div>
</div>

<div class="container border-top pt-4">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Tên Bộ Môn</th>
        <th scope="col">Mô Tả</th>
        <th scope="col">Hành Động</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Quản lý Bộ Môn 1</td>
        <td>Mô tả Bộ Môn 1</td>
        <td>
          <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editBoMonModal"
            data-id="1" data-tenBoMon="Quản lý Bộ Môn 1" data-moTaBoMon="Mô tả Bộ Môn 1">
            <i class="fa-solid fa-pen"></i>
          </button>
          <button class="btn btn-sm btn-danger text-light"
            data-coreui-toggle="modal"
            data-coreui-target="#deleteBoMonModal"
            data-id="1"
            data-tenBoMon="Quản lý Bộ Môn 1">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Quản lý Bộ Môn 2</td>
        <td>Mô tả Bộ Môn 2</td>
        <td>
          <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editBoMonModal"
            data-id="1" data-tenBoMon="Quản lý Bộ Môn 1" data-moTaBoMon="Mô tả Bộ Môn 1">
            <i class="fa-solid fa-pen"></i>
          </button>
          <button class="btn btn-sm btn-danger text-light"
            data-coreui-toggle="modal"
            data-coreui-target="#deleteBoMonModal"
            data-id="2"
            data-tenBoMon="Quản lý Bộ Môn 2">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Add New Bộ Môn Modal -->
<div class="modal fade" id="addBoMonModal" tabindex="-1" aria-labelledby="addBoMonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBoMonModalLabel">Thêm Bộ Môn Mới</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('quan-ly-bo-mon/add_bo_mon') ?>" method="POST">
          <div class="mb-3">
            <label for="tenBoMon" class="form-label">Tên Bộ Môn</label>
            <input type="text" class="form-control" id="tenBoMon" name="tenBoMon" required>
          </div>
          <div class="mb-3">
            <label for="moTaBoMon" class="form-label">Mô Tả Bộ Môn</label>
            <input type="text" class="form-control" id="moTaBoMon" name="moTaBoMon" required>
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
<div class="modal fade" id="editBoMonModal" tabindex="-1" aria-labelledby="editBoMonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBoMonModalLabel">Chỉnh Sửa Bộ Môn</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editBoMonForm" method="POST" action="<?= base_url('quan-ly-bo-mon/edit_bo_mon') ?>">
          <input type="hidden" name="BoMonId" id="BoMonId" value="">
          <div class="mb-3">
            <label for="tenBoMonEdit" class="form-label">Tên Bộ Môn</label>
            <input type="text" class="form-control" id="tenBoMonEdit" name="tenBoMon" required>
          </div>
          <div class="mb-3">
            <label for="moTaBoMonEdit" class="form-label">Mô Tả Bộ Môn</label>
            <input type="text" class="form-control" id="moTaBoMonEdit" name="moTaBoMon" required>
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

<!-- Delete Bộ Môn Modal -->
<div class="modal fade" id="deleteBoMonModal" tabindex="-1" aria-labelledby="deleteBoMonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBoMonModalLabel">Xác Nhận Xóa</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa Bộ Môn <strong id="BoMonNameToDelete"></strong> không?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteBoMonForm" method="POST" action="<?= base_url('quan-ly-bo-mon/delete_bo_mon') ?>">
          <input type="hidden" name="BoMonId" id="BoMonIdDelete" value="">
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
        const BoMonId = this.getAttribute('data-id');
        const tenBoMon = this.getAttribute('data-tenBoMon');
        const moTaBoMon = this.getAttribute('data-moTaBoMon');

        document.getElementById('BoMonId').value = BoMonId;
        document.getElementById('tenBoMonEdit').value = tenBoMon;
        document.getElementById('moTaBoMonEdit').value = moTaBoMon;
      });
    });

    // Delete 
    const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteBoMonModal"]');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const BoMonId = this.getAttribute('data-id');
        const tenBoMon = this.getAttribute('data-tenBoMon');

        document.getElementById('BoMonIdDelete').value = BoMonId;
        document.getElementById('BoMonNameToDelete').textContent = tenBoMon   ;
      });
    });
  });
</script>h 
<?= $this->endSection() ?>