<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">

        {include file='include/styles.tpl'}

        <title>Профиль | Система авторизации</title>
    </head>
    <body>

        {include file='include/header.tpl'}

        <main>

            <section class="main-content display-content-width">
                <div class="content">
                    <div class="contact-form-block">
                        <h2>Редактирование данных профиля</h2>

                        {$notifions=$notifionsEdit}
                        {include file='include/notifions.tpl'}

                        {$errorText=$errorEdit}
                        {include file='include/error.tpl'}

                        <form action="" method="post" class="contact-form" >
                            <input type="hidden" name="mode" value="update_user_data" />
                            <div class="form-input-blocks">
                                <div class="form-input">
                                    <label for="firstName">Ваше имя *</label>
                                    <input type="text" id="firstName" name="first_name" placeholder="Например: Иван" required="required" value="{if isset($userData.user_first_name) }{$userData.user_first_name}{/if}" />
                                </div>
                                <div class="form-input">
                                    <label for="secondName">Ваша фамилия *</label>
                                    <input type="text" id="secondName" name="second_name" placeholder="Например: Смирнов" required="required" value="{if isset($userData.user_second_name) }{$userData.user_second_name}{/if}" />
                                </div>
                            </div>
                            <p>* - звездочкой отмечены поля обязательные для заполнения</p>
                            <button type="submit">Обновить</button>
                        </form>
                    </div>
                    <hr />
                    <div class="contact-form-block">
                        <h2>Изменение пароля</h2>
                        
                        {$notifions=$notifionsPassw}
                        {include file='include/notifions.tpl'}

                        {$errorText=$errorPassw}
                        {include file='include/error.tpl'}

                        <form action="" method="post" class="contact-form" >
                            <input type="hidden" name="mode" value="change_password" />
                            <div class="form-input-blocks">
                                <div class="form-input">
                                    <label for="oldPassw">Ваш старый пароль *</label>
                                    <input type="password" id="oldPassw" name="old_password" placeholder="Ваш пароль, указанный при регистрации" required="required" />
                                    <label for="passw">Ваш новый пароль *</label>
                                    <input type="password" id="passw" name="password" placeholder="Не менее 4 символов" required="required" />
                                    <label for="passwRep">Повторите новый пароль *</label>
                                    <input type="password" id="passwRep" name="password_repeat" placeholder="Введите сюда новый пароль повторно" required="required" />
                                </div>
                            </div>
                            <p>* - звездочкой отмечены поля обязательные для заполнения</p>
                            <button type="submit">Обновить</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>