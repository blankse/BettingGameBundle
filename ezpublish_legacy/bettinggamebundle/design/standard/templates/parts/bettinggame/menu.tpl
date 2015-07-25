<div id="cockpit-menu">
    {if $module_result.ui_context|ne('edit')}
        {* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
            <h4>{'Betting Game'|i18n( 'bettinggame' )}</h4>
        {* DESIGN: Header END *}</div></div></div></div></div></div>

        {* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">
            <ul class="leftmenu-items">
                <li{if $uri_string|begins_with( 'bettinggame/teams' )} class="current"{/if}><a href={'bettinggame/teams'|ezurl} title="{'Teams'|i18n( 'bettinggame' )}">{'Teams'|i18n( 'bettinggame' )}</a></li>
                <li{if $uri_string|begins_with( 'bettinggame/matches' )} class="current"{/if}><a href={'bettinggame/matches'|ezurl} title="{'Matches'|i18n( 'bettinggame' )}">{'Matches'|i18n( 'bettinggame' )}</a></li>
            </ul>
        {* DESIGN: Content END *}</div></div></div></div></div></div>
    {/if}
</div>

{* This is the border placed to the left for draging width, js will handle disabling the one above and enabling this *}
<div id="widthcontrol-handler" class="hide">
    <div class="widthcontrol-grippy"></div>
</div>