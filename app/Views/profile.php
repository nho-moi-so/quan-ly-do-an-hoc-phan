<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('title') ?>
Hồ sơ cá nhân
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container border-top pt-4">
    <div class="container">
        <h2>Hồ sơ cá nhân</h2>

        <p><strong>Họ tên:</strong> <?= session()->get('hoTen') ?></p>
        <p><strong>Email:</strong> <?= session()->get('email') ?></p>
        <p><strong>Quyền:</strong> <?= session()->get('role') ?></p>

        <div class="container">
            <h2>Đổi Mật Khẩu</h2>
            <form action="change-password" method="POST">
                <label for="old-password">Mật khẩu cũ:</label>
                <input type="password" id="old-password" name="old-password" placeholder="Nhập mật khẩu cũ" required>

                <label for="new-password">Mật khẩu mới:</label>
                <input type="password" id="new-password" name="new-password" placeholder="Nhập mật khẩu mới" required>

                <label for="confirm-password">Xác nhận mật khẩu mới:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Nhập lại mật khẩu mới" required>

                <button type="submit">Xác nhận</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>