<div class="logi">
    <form  class="logi" role="form" action="<?= base_url("index.php/usuario/login") ?>" method="post">
        <div class="col-md-6 col-md-offset-2">
            <h3> <p class="text-primary text-center line-height">CERTIFICADOS 1.0</p></h3>
            <div class="panel member_signin">
                <div class="panel-body logi">
                    <div class="fa_user">
                        <i class="fa fa-user"></i>
                    </div>          
                    <h3> <p  class="text-primary text-center line-height">Entrar</p></h3>
                    <p class="forgotpass">
                        <a href="<?= base_url("index.php/usuario/registro") ?>" class="small">Registrarse</a></p>
                    <form role="form" class="loginform">

                        <div class="form-group">
                            <label class="control-label" for="mail">Email</label>
                            <input type="text" class="form-control" name="mail" value="<?= set_value('mail'); ?>" placeholder="Email"/>
                            <span class="help-block"><?= form_error('mail') ?></span>
                            <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="pasword">Password</label>
                            <input type="text" class="form-control" name="pasword" placeholder="Password"/>
                            <span class="text-danger"><?= form_error('pasword') ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-md login">Aceptar</button>
                    </form>
                    <p class="forgotpass"><a href="<?= base_url("index.php/usuario/recuperar_pass") ?>" class="small">Recuperar contraseña</a> </p>
                </div>
            </div>
        </div>

    </form>
</div>