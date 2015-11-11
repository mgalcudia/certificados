<br/>
<form role="form" action="<?= base_url("index.php/usuario/login") ?>" method="post">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel member_signin">
            <div class="panel-body">
                <div class="fa_user">
                    <i class="fa fa-user"></i>
                </div>          
                <p class="member">Entrar</p><p class="forgotpass">
                    <a href="<?= base_url("index.php/usuario/registro") ?>" class="small">Registrarse</a></p>
                <form role="form" class="loginform">

                    <div class="form-group <?= (isset($clase_campo_form['mail'])) ? $clase_campo_form['mail'] : '' ?>">
                        <label class="control-label" for="mail">Email</label>
                        <input type="text" class="form-control" name="mail" value="<?= set_value('mail'); ?>" placeholder="Email"/>
                        <span class="help-block"><?= form_error('mail') ?></span>
                        <span class="help-block"><?php if (isset($error)) echo $error; ?></span>
                    </div>


                    <div class="form-group <?= (isset($clase_campo_form['pasword'])) ? $clase_campo_form['pasword'] : '' ?>">
                        <label class="control-label" for="pasword">Password</label>
                        <input type="text" class="form-control" name="pasword" placeholder="Password"/>
                        <span class="help-block"><?= form_error('pasword') ?></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-md login">Aceptar</button>
                </form>
                <p class="forgotpass"><a href="#" class="small">Recuperar contraseña</a> </p>
            </div>
        </div>
    </div>

</form>