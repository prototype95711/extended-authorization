<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">

        {include file='include/styles.tpl'}

        <title>Вход | Система авторизации</title>
    </head>
    <body>
        <main>

            <section class="main-content display-content-width">
                <div class="content login-form">
                    <h2>Вход</h2>

                    {include file='include/notifions.tpl'}
                    {include file='include/error.tpl'}

                    <form action="" method="post" class="contact-form" >
                        <input type="hidden" name="mode" value="login" />
                        <div class="form-input-blocks">
                            <div class="form-input">
                                <label for="email">Ваш Email</label>
                                <input type="text" id="email" name="email" placeholder="Ваш email, указанный при регистрации" required="required" value="{if isset($request.email) }{$request.email}{/if}" />
                                <label for="passw">Ваш пароль</label>
                                <input type="password" id="passw" name="password" placeholder="Ваш пароль, указанный при регистрации" required="required" />
                            </div>
                        </div>
                        <button type="submit">Войти</button>
                        <button class="button-2" onclick="location.href='{$location}/register';">Регистрация</button>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>