<br/>
<form role="form" action="<?=base_url("index.php/usuario/login")?>" method="post">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel member_signin">
      <div class="panel-body">
        <div class="fa_user">
          <i class="fa fa-user"></i>
        </div>          
        <p class="member">Entrar</p><p class="forgotpass">
            <a href="<?=base_url("index.php/usuario/registro")?>" class="small">Registrarse</a></p>
        <form role="form" class="loginform">
          <div class="form-group">
            <label for="exampleInputEmail1" class="sr-only">Email</label>
            <div class="input-group">
              <input type="email" class="form-control" id="exampleInputEmail1"
                placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1" class="sr-only">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="exampleInputPassword1"
                placeholder="Password">
            </div>
          </div>            
          <button type="submit" class="btn btn-primary btn-md login">Aceptar</button>
        </form>
        <p class="forgotpass"><a href="#" class="small">Recuperar contraseña</a> </p>
      </div>
    </div>
  </div>

</form>