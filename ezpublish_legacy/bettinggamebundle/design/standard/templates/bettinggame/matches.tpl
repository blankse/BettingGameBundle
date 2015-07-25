<div class="bettinggame bettinggame-index">
    <div class="border-box">
        <div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
        <div class="border-ml"><div class="border-mr"><div class="border-mc clearfix">
            <div class="context-block">
                {* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
                    <h1 class="context-title">{'Matches'|i18n('bettinggame')}</h1>
                    {* DESIGN: Mainline *}<div class="header-mainline"></div>
                {* DESIGN: Header END *}</div></div></div></div></div></div>

                {* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">
                    {if $teams|count}
                        <form action={'bettinggame/matches'|ezurl} method="post">
                            <div class="block">
                                <label for="match_date">{'Date'|i18n('bettinggame')}</label>
                                <input id="match_date" name="date" value="{currentdate()|datetime( 'custom', '%Y-%m-%d %h:%i' )}" type="text">
                            </div>
                            <div class="block">
                                <label for="match_team">{'Team'|i18n('bettinggame')}</label>
                                <select id="match_team" name="team_id">
                                    {foreach $teams as $team}
                                        <option value="{$team.id}">{$team.name|wash}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="block">
                                <label for="match_opponent">{'Opponent'|i18n('bettinggame')}</label>
                                <input id="match_opponent" name="opponent" type="text">
                            </div>
                            <div class="block">
                                <label for="match_away_game"><input id="match_away_game" name="away_game" value="1" type="checkbox"> {'Away game'|i18n('bettinggame')}</label>
                            </div>
                            <div class="block">
                                <input type="submit" name="CreateMatchButton" value="{'Create'|i18n('bettinggame')}">
                            </div>
                        </form>
                        {if $matches|count}
                            <table class="list" cellspacing="0">
                                <tr>
                                    <th>{'Date'|i18n( 'bettinggame' )}</th>
                                    <th>{'Team'|i18n( 'bettinggame' )}</th>
                                    <th>{'Opponent'|i18n( 'bettinggame' )}</th>
                                    <th>{'Away game'|i18n( 'bettinggame' )}</th>
                                    <th></th>
                                </tr>
                                {foreach $matches as $match sequence array( 'bglight', 'bgdark' ) as $seq}
                                    <tr class="{$seq}">
                                        <td>{$match.date|datetime( 'custom', '%Y-%m-%d %h:%i' )}</td>
                                        <td>{$match.team|wash}</td>
                                        <td>{$match.opponent|wash}</td>
                                        <td>{$match.away_game}</td>
                                        <td>
                                            <form action={'bettinggame/matches'|ezurl} method="post">
                                                <input type="submit" name="DeleteMatchButton" value="{'Delete'|i18n('bettinggame')}">
                                                <input type="hidden" name="id" value="{$team.id}">
                                            </form>
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
                        {/if}
                    {else}
                        {'No team is found.'|i18n('bettinggame')}
                    {/if}
                {* DESIGN: Content END *}</div></div></div></div></div></div>
            </div>
        </div></div></div>
        <div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
    </div>
</div>
