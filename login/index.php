<? include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/header.php'; ?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>GS</b>BOTS
  </div>
	<!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Войдите в аккаунт</p>

      <form action="action_login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="login" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Пароль" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Запомнить меня
              </label>
            </div>
          </div>
					<!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
          </div>
					<!-- /.col -->
        </div>
      </form>
    </div>
		<!-- /.login-card-body -->
  </div>
</div>
<? include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/footer/footer.php'; ?>
