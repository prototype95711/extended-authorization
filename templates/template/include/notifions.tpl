{if isset($notifions) and is_array($notifions) }
    {foreach from=$notifions item=notify}
        <p class="notify">{$notify}</p>
    {/foreach}
{/if}
