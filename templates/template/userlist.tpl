<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">

        {include file='include/styles.tpl'}

        <title>Список пользователей | Система авторизации</title>
    </head>
    <body>

        {include file='include/header.tpl'}

        <main>
            <section class="main-content display-content-width">
                <div class="content">
                    <div class="pagination-container">
                        <ul class="pagination">

                            {if empty($error)}

                                {if $currentPage > 1}
                                    <li><a href="{$location}/userlist/?page={$currentPage - 1}">Пред.</a></li>
                                {/if}

                                {for $i=1 to $pages}
                                    <li><a href="{$location}/userlist/?page={$i}">{$i}</a></li>
                                {/for}

                                {if $currentPage != $pages}
                                    <li><a href="{$location}/userlist/?page={$currentPage + 1}">След.</a></li>
                                {/if}

                            {/if}

                        </ul>
                    </div>
                    <table cellspacing="15" class="userlist-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Права</th>
                            </tr>
                        </thead>
                        <tbody>

                            {if !empty($error)}

                                <tr><td colspan="4">{$error}</td></tr>

                            {else}

                                {foreach from=$users item=user}
                                    <tr>
                                        <td>{$user.id}</td>
                                        <td>{$user.user_first_name} {$user.user_second_name}</td>
                                        <td>{$user.user_email}</td>
                                        <td>{if $user.user_type == 1}Администратор{elseif $user.user_type == 0}Пользователь{else}Неизвестно{/if}</td>
                                    </tr>
                                {/foreach}

                            {/if}
                            
                        </tbody>
                    </table>
                    <div class="pagination-container">
                        <ul class="pagination">

                            {if empty($error)}

                                {if $currentPage > 1}
                                    <li><a href="{$location}/userlist/?page={$currentPage - 1}">Пред.</a></li>
                                {/if}

                                {for $i=1 to $pages}
                                    <li><a href="{$location}/userlist/?page={$i}">{$i}</a></li>
                                {/for}

                                {if $currentPage != $pages}
                                    <li><a href="{$location}/userlist/?page={$currentPage + 1}">След.</a></li>
                                {/if}

                            {/if}

                        </ul>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>