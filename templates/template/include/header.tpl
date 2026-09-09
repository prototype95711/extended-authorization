<header>
    <nav class="header-nav">
        <div class="header-menu display-content-width">
            <ul class="menu menu-left">
                <li class="menu-item">
                    <a href="{$location}/main">Главная</a>
                </li>
                <li class="menu-item">
                    <a href="{$location}/profile">Профиль</a>
                </li>

                {if $userType === 1}
                    <li class="menu-item">
                        <a href="{$location}/userlist">Пользователи</a>
                    </li>
                {/if}
                
            </ul>
            <ul class="menu">
                <li class="menu-item">
                    <a href="{$location}/logout/?mode=logout">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
</header>