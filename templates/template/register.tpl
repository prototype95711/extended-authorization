<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">

        {include file='include/styles.tpl'}

        <title>Регистрация | Система авторизации</title>
    </head>
    <body>
        <main>

            <section class="main-content display-content-width">
                <div class="content registration-form">

                    <h2>Регистрация</h2>

                    {include file='include/error.tpl'}

                    <form action="" method="post" class="contact-form" >
                        <input type="hidden" name="mode" value="register" />
                        <div class="form-input-blocks">
                            <div class="form-input">
                                <label for="firstName">Ваше имя *</label>
                                <input type="text" id="firstName" name="first_name" placeholder="Например: Иван" required="required" value="{if isset($request.first_name) }{$request.first_name}{/if}" />
                                <label for="secondName">Ваша фамилия *</label>
                                <input type="text" id="secondName" name="second_name" placeholder="Например: Смирнов" required="required" value="{if isset($request.second_name) }{$request.second_name}{/if}" />
                            </div>
                            <div class="form-input">
                                <label for="email">Ваш Email *</label>
                                <input type="text" id="email" name="email" placeholder="Например: ivan@mail.ru" required="required" value="{if isset($request.email) }{$request.email}{/if}" />
                                <label for="passw">Ваш пароль *</label>
                                <input type="password" id="passw" name="password" placeholder="Не менее 4 символов" required="required" />
                                <label for="passwRep">Повторите пароль *</label>
                                <input type="password" id="passwRep" name="password_repeat" placeholder="Введите сюда пароль повторно" required="required" />
                            </div>
                            <p>* - звездочкой отмечены поля обязательные для заполнения</p>
                        </div>
                        <button type="submit">ЗАРЕГИСТРИРОВАТЬСЯ</button>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>