<section id="statistics_wrapper">

	<section id="checkout"></section>

	<section id="statistics">

        {if $realms_count > 0}
        
            <section id="statistics_top">
                <section id="statistics_realms">
                    <div style="float: right;">
                        <select style="width: 200px;" id="realm-changer" onchange="return RealmChange();">
                            {foreach from=$realms item=realm key=realmId}
                                <option value="{$realmId}" {if $selected_realm == $realmId}selected="selected"{/if}>{$realm.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="clear"></div>
                </section>
    
                <div class="clear"></div>
            </section>
		
        	<section id="statistics_title" style="margin-top: 40px; margin-bottom: 10px;">
            	<div><h3>Jugadores Primeros del Reino</h3></div>
            </section>
        
        	<section class="statistics_top_hk" style="display:block;">
                
                <table class="nice_table" cellspacing="0" cellpadding="0">
                    <tr>
                    	<td width="10%" align="center">#</td>
                    	<td width="60%">Logro</td>
                        <td width="30%">Personaje</td>
                    </tr>
    				
                    {if $AchievFirst}
                        {foreach from=$AchievFirst item=character}
                        <tr>
                        	<td width="10%" align="center">{$character.rank}</td>
                            <td width="60%">
                                <img width="18px" height="18px" alt="*"
                                    src="https://wow-zamimg.amanthul.cu/static/images/icons/large/{$character.achiicon}.jpg" />
                                {$character.achiname}
                            </td>
                            <td width="30%"><a data-tip="Ver perfil del personaje" href="{$url}character/{$selected_realm}/{$character.guid}">{$character.name}</a></td>
                        </tr>
                        {/foreach}
                  	{else}
                    	<tr>
                        	<td colspan="5"><center>No hay jugadores con primero en el reino.</center></td>
                      	</tr>
                	{/if}
                </table>
                
            </section>
        
        {/if}<!-- End.If we have realms -->
        
	</section>
</section>
