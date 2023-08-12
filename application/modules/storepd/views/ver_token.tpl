<div class="container">
    <div class="row">

        {$link_active = "tokenpd"}
        {include file="../../ucp/views/ucp_navigation.tpl"}


        <div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">

            <div class="section-body">
                <h3 class="text-center">Ver Tokens sin activar</h3>
                <br>                
                                    

                        <table class="table table-dark table-striped">
                        
                            <thead class="table-dark ">
                                <tr>
                                    <th  class="text-center" scope="col">Token</th>
                                    <th class="text-center" scope="col">Valor</th>
                                    <th class="text-center" scope="col">Creado</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach from=$tokens item=p}
                                <tr>
                                    <th scope="row" class="text-center">
                                        {$p->token}
                                    </th>
                                    <th class="text-center">
                                        {$p->pd}
                                    </th>
                                    <td class="text-center">
                                        {$p->f_creado}
                                    </td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    
                

            </div>
                      <br>
                      <div class="text-right">
                                        <a href="{$url}tokenpd" class="btn btn-info ">Regresar</a>
                                    </div>
          
          <br> <br>
        </div>