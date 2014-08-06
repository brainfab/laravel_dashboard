@extends('admin::default_login')
@section('content')

<div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <?php if(isset($error) && !empty($error)): ?>
            <div class="alert alert-danger">
                <?=$error?>
            </div>
            <?php endif; ?>
            <div style="max-width: 400px;margin: 0 auto;">
                <div class="well no-padding">
                    <form class="smart-form client-form" action="/admin/login" id="login-form" method="post">
                        <header>
                            Авторизация
                        </header>

                        <fieldset>

                            <section>
                                <label class="label">Логин</label>
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input value="<?php if(isset($login)): echo $login; endif; ?>" name="login" tabindex="1" >
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Введите свой логин</b></label>
                            </section>

                            <section>
                                <label class="label">Пароль</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" value="" name="password" tabindex="2">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Введите пароль</b> </label>
                            </section>
                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" type="submit">
                                Войти
                            </button>
                        </footer>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@stop