<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mb-2">
  <div class="d-flex align-items-center justify-content-between">
    <div class="title">
      <h4 class="text-center">Quản Lý Khoa</h4>
    </div>

    <div>
      <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addKhoaModal">Thêm Khoa Mới</button>
    </div>
  </div>
</div>

<div class="container border-top pt-4">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Tên Khoa</th>
        <th scope="col">Mô Tả</th>
        <th scope="col" style="width: 25%">Hành Động</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($khoa): ?>
        <?php foreach ($khoa as $k): ?>
          <tr>
            <th scope="row"><?php echo $k['maKhoa']; ?></th>
            <td><?php echo $k['tenKhoa']; ?></td>
            <td><?php echo $k['moTaKhoa']; ?></td>
            <td>
              <button class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editKhoaModal"
                data-id="<?php echo $k['maKhoa']; ?>" data-tenKhoa="<?php echo $k['tenKhoa']; ?>" data-moTaKhoa="<?php echo $k['moTaKhoa']; ?>">
                <i class="fa-solid fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-danger text-light"
                data-coreui-toggle="modal"
                data-coreui-target="#deleteKhoaModal"
                data-id="<?php echo $k['maKhoa']; ?>"
                data-tenKhoa="<?php echo $k['tenKhoa']; ?>">
                <i class="fa-solid fa-trash"></i>
              </button>
              <a href="<?= base_url('quan-ly-bo-mon/' . $k['maKhoa']) ?>" class="btn btn-sm btn-success" style="background-color:rgb(53, 65, 157); color: white;">
                <i class="fa-solid fa-eye"></i> Bộ Môn
              </a>
              <a href="<?= base_url('quan-ly-nganh/' . $k['maKhoa']) ?>" class="btn btn-sm btn-success" style="background-color:rgb(53, 65, 157); color: white;">
                <i class="fa-solid fa-eye"></i> Ngành
              </a>
            </td>
           
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>


</div>

<!-- Add New Khoa Modal -->
<div class="modal fade" id="addKhoaModal" tabindex="-1" aria-labelledby="addKhoaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addKhoaModalLabel">Thêm Khoa Mới</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('quan-ly-khoa/add-khoa') ?>" method="POST">
          <div class="mb-3">
            <label for="tenKhoa" class="form-label">Tên Khoa</label>
            <input type="text" class="form-control" id="tenKhoa" name="tenKhoa" required>
          </div>
          <div class="mb-3">
            <label for="moTaKhoa" class="form-label">Mô Tả Khoa</label>
            <input type="text" class="form-control" id="moTaKhoa" name="moTaKhoa" required>
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
<div class="modal fade" id="editKhoaModal" tabindex="-1" aria-labelledby="editKhoaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKhoaModalLabel">Chỉnh Sửa Khoa</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editKhoaForm" method="POST" action="<?= base_url('quan-ly-khoa/edit-khoa') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="maKhoa" id="maKhoa">
          <div class="mb-3">
            <label for="tenKhoaEdit" class="form-label">Tên Khoa</label>
            <input type="text" class="form-control" id="tenKhoaEdit" name="tenKhoa" required>
          </div>
          <div class="mb-3">
            <label for="moTaKhoaEdit" class="form-label">Mô Tả Khoa</label>
            <input type="text" class="form-control" id="moTaKhoaEdit" name="moTaKhoa">
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
<div class="modal fade" id="deleteKhoaModal" tabindex="-1" aria-labelledby="deleteKhoaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteKhoaModalLabel">Xác Nhận Xóa</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa khoa <strong id="tenKhoaToDelete"></strong> không?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteKhoaForm" method="GET" action="">
          <input type="hidden" name="maKhoa" id="maKhoaDelete" value="">
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
        const maKhoa = this.getAttribute('data-id');
        const tenKhoa = this.getAttribute('data-tenKhoa');
        const moTaKhoa = this.getAttribute('data-moTaKhoa');

        console.log(maKhoa);
        console.log(tenKhoa);
        console.log(moTaKhoa);

        document.getElementById('maKhoa').value = maKhoa;
        document.getElementById('tenKhoaEdit').value = tenKhoa;
        document.getElementById('moTaKhoaEdit').value = moTaKhoa;
      });
    });

    // Delete 
    const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteKhoaModal"]');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const maKhoa = this.getAttribute('data-id');
        const tenKhoa = this.getAttribute('data-tenKhoa');

        document.getElementById('maKhoaDelete').value = maKhoa;
        document.getElementById('tenKhoaToDelete').textContent = tenKhoa;
        document.getElementById('deleteKhoaForm').action = "<?= base_url('quan-ly-khoa/delete-khoa/') ?>" + maKhoa;
      });
    });
  });
</script>h
<?= $this->endSection() ?>