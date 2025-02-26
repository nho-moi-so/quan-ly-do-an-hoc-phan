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
        <th scope="col">ID</th>
        <th scope="col">Tên Bộ Môn</th>
        <th scope="col">Tên Khoa</th>
        <th scope="col">Hành Động</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($bomon): ?>
        <?php foreach ($bomon as $bm): ?>
          <tr>
            <th scope="row"><?php echo $bm['maBoMon']; ?></th>
            <td><?php echo $bm['tenBoMon']; ?></td>
            <td><?php echo $bm['tenKhoa']; ?></td>
            <td>
              <button class="btn btn-sm btn-primary"
                data-coreui-toggle="modal"
                data-coreui-target="#editBoMonModal"
                data-id="<?php echo $bm['maBoMon']; ?>"
                data-tenBoMon="<?php echo $bm['tenBoMon']; ?>"
                data-maKhoa="<?php echo $bm['maKhoa']; ?>"
                data-tenKhoa="<?php echo $bm['tenKhoa']; ?>"><i class="fa-solid fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-danger text-light"
                data-coreui-toggle="modal"
                data-coreui-target="#deleteBoMonModal"
                data-id="<?php echo $bm['maBoMon']; ?>"
                data-tenBoMon="<?php echo $bm['tenBoMon']; ?>"><i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
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
        <form action="<?= base_url('quan-ly-bo-mon/add-bo-mon') ?>" method="POST">
          <div class="mb-3">
            <label for="tenBoMon" class="form-label">Tên Bộ Môn</label>
            <input type="text" class="form-control" id="tenBoMon" name="tenBoMon" placeholder="Nhập tên bộ môn" required>
            <label for="chonKhoa" class="form-label">Khoa</label>
            <select id="chonKhoa" name="maKhoa" class="form-select" required>
              <?php if ($khoa): ?>
                <?php foreach ($khoa as $k): ?>
                  <option value="<?php echo $k['maKhoa']; ?>"><?php echo $k['tenKhoa']; ?></option>
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
<div class="modal fade" id="editBoMonModal" tabindex="-1" aria-labelledby="editBoMonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBoMonModalLabel">Chỉnh Sửa Bộ Môn</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editBoMonForm" method="POST" action="<?= base_url('quan-ly-bo-mon/edit-bo-mon') ?>">
          <input type="hidden" name="maBoMon" id="maBoMon" value="">
          <div class="mb-3">
            <label for="tenBoMonEdit" class="form-label">Tên Bộ Môn</label>
            <input type="text" class="form-control" id="tenBoMonEdit" name="tenBoMon" required>
          </div>
          <div class="mb-3">
            <label for="chonKhoaEdit" class="form-label">Khoa</label>
            <select id="chonKhoaEdit" name="maKhoa" class="form-select" required>
              <?php if ($khoa): ?>
                <?php foreach ($khoa as $k): ?>
                  <option value="<?php echo $k['maKhoa']; ?>"><?php echo $k['tenKhoa']; ?></option>
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

<!-- Delete Bộ Môn Modal -->
<div class="modal fade" id="deleteBoMonModal" tabindex="-1" aria-labelledby="deleteBoMonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBoMonModalLabel">Xác Nhận Xóa</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa Bộ Môn <strong id="tenBoMonToDelete"></strong> không?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteBoMonForm" method="GET" action="">
          <input type="hidden" name="maBoMon" id="maBoMonDelete" value="">
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
        const maBoMon = this.getAttribute('data-id');
        const tenBoMon = this.getAttribute('data-tenBoMon');
        const maKhoa = this.getAttribute('data-maKhoa');
        const selectKhoa = document.getElementById("chonKhoaEdit");

        document.getElementById('maBoMon').value = maBoMon;
        document.getElementById('tenBoMonEdit').value = tenBoMon;

        for (let option of selectKhoa.options) {
          if (option.value == maKhoa) {
            option.selected = true;
            break;
          }
        }
      });
    });

    // Delete 
    const deleteButtons = document.querySelectorAll('[data-coreui-target="#deleteBoMonModal"]');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const maBoMon = this.getAttribute('data-id');
        const tenBoMon = this.getAttribute('data-tenBoMon');

        document.getElementById('maBoMonDelete').value = maBoMon;
        document.getElementById('tenBoMonToDelete').textContent = tenBoMon;
        document.getElementById('deleteBoMonForm').action = "<?= base_url('quan-ly-bo-mon/delete-bo-mon/') ?>" + maBoMon;
      });
    });
  });
</script>
<?= $this->endSection() ?>