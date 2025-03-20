<?php include(".layouts/header.php"); ?>
<!-- Register -->
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-text demo text-uppercase fw-bolder">Vehicle rental</span>
      </a>
    </div>
    <!-- /Logo -->
    <h4 class="mb-2">Selamat datang di Vehicle rental! 👋</h4>
    <form class="mb-3" action="login_auth.php" method="POST">
      <div class="mb-3">
        <label class="form-label">nama</label>
        <input type="text" class="form-control" name="username"
          placeholder="Masukkan nama anda" autofocus required />
      </div>
      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="nomor_lisensi">nomor_lisensi</label>
        </div>
        <div class="input-group input-group-merge">
          <input type="nomor_lisensi" class="form-control" name="nomor_lisensi"
            placeholder="Masukkan nomor lisensi" />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>
      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
      </div>
    </form>
    <p class="text-center">
      <span>Belum punya akun?</span><a href="register.php"><span> Daftar</span></a>
    </p>
  </div>
</div>
<!-- /Register -->
<?php include(".layouts/footer.php"); ?>