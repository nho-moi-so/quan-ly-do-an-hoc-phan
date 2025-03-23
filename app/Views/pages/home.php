<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('title') ?>
Trang Chủ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="text-center mt-5">Chào mừng user <?= session()->get('maSV') ?> đến với Bootstrap 5</h1>
<p class="lead text-center">Sử dụng layout để dùng chung Bootstrap trên toàn bộ ứng dụng.</p>

<?= $this->endSection() ?>