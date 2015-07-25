<div class="bettinggame bettinggame-index">
    <div class="border-box">
        <div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
        <div class="border-ml"><div class="border-mr"><div class="border-mc clearfix">
            <div class="context-block">
                {* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
                    <h1 class="context-title">{'Teams'|i18n('bettinggame')}</h1>
                    {* DESIGN: Mainline *}<div class="header-mainline"></div>
                {* DESIGN: Header END *}</div></div></div></div></div></div>

                {* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">
                    <form action={'bettinggame/teams'|ezurl} method="post">
                        <div class="block">
                            <label for="team_name">{'Name'|i18n('bettinggame')}</label>
                            <input id="team_name" name="name" type="text">
                        </div>
                        <div class="block">
                            <input type="submit" name="CreateTeamButton" value="{'Create'|i18n('bettinggame')}">
                        </div>
                    </form>
                    {if $teams|count}
                        <table class="list" cellspacing="0">
                            <tr>
                                <th>{'Name'|i18n( 'bettinggame' )}</th>
                                <th>{'Match count'|i18n( 'bettinggame' )}</th>
                                <th></th>
                            </tr>
                            {foreach $teams as $team sequence array( 'bglight', 'bgdark' ) as $seq}
                                <tr class="{$seq}">
                                    <td>{$team.name|wash}</td>
                                    <td>{$team.match_count}</td>
                                    <td>
                                        <form action={'bettinggame/teams'|ezurl} method="post">
                                            <input type="submit" name="DeleteTeamButton" value="{'Delete'|i18n('bettinggame')}">
                                            <input type="hidden" name="id" value="{$team.id}">
                                        </form>
                                    </td>
                                </tr>
                            {/foreach}
                        </table>
                    {/if}
                {* DESIGN: Content END *}</div></div></div></div></div></div>
            </div>
        </div></div></div>
        <div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
    </div>
</div>
