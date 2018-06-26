<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<script type="text/javascript" src="@pew/custom-textarea/ckeditor.js"></script>
<script type="text/javascript" src="standard.js"></script>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat');
    body{
        margin: 0px;
        font-family: 'Montserrat', sans-serif;
        background-color: #fff;
        color: #333;
        font-size: 16px;
    }
    .tickets-table{
        width: 90%;
        margin: 0 auto;
        color: #333;
    }
    .tickets-table .table-head{
        background-color: #eee;
    }
    .tickets-table thead td{
        padding: 10px;
    }
    .tickets-table tbody td{
        padding: 10px;
        border: 1px solid #eee;
    }
    .tickets-table .table-link{
        color: #333;
    }
</style>
<br>
<h1 align=center>Meus Tickets</h1>
<table class="tickets-table" cellspacing=0>
    <tr>
        <td colspan="7">Registrar novo ticket: <a href="create-ticket.php" class="link-padrao">adicionar</a></td>
    </tr>
    <tr class="table-head">
        <td>Referência</td>
        <td>Assunto</td>
        <td>Departamento</td>
        <td>Enviado</td>
        <td>Prioridade</td>
        <td>Status</td>
        <td align=center>Ver</td>
    </tr>
    <tbody>
    <?php
        require_once "@pew/@classe-system-functions.php";
        $conexao = mysqli_connect("localhost", "root", "", "pew_tickets");
    
        $condicao = "true";
        $contar = mysqli_query($conexao, "select count(id) as total from tickets_register where $condicao");
        $contagem = mysqli_fetch_assoc($contar);
        if($contagem['total'] > 0){
            $query = mysqli_query($conexao, "select * from tickets_register where $condicao");
            while($infoTicket = mysqli_fetch_array($query)){
                $dataCompleta = $infoTicket["data_controle"];
                $dataAno = substr($dataCompleta, 0, 10);
                $dataAno = $pew_functions->inverter_data($dataAno);
                $dataHorario = substr($dataCompleta, 11);

                switch($infoTicket["priority"]){
                    case 1:
                        $prioridade = "Média";
                        break;
                    case 2:
                        $prioridade = "Urgente";
                        break;
                    default:
                        $prioridade = "Normal";
                }

                switch($infoTicket["status"]){
                    case 0:
                        $status = "Fechado";
                        break;
                    case 2:
                        $status = "Aguardando resposta do cliente";
                        break;
                    default:
                        $status = "Aguardando resposta do atendente";
                        break;
                }
                
                echo "<tr class='ticket-line'>";
                    echo "<td>#{$infoTicket['ref']}</td>";
                    echo "<td>{$infoTicket['topic']}</td>";
                    echo "<td>{$infoTicket['department']}</td>";
                    echo "<td>$dataAno</td>";
                    echo "<td>$prioridade</td>";
                    echo "<td>$status</td>";
                    echo "<td align=center><a href='ticket.php?ref={$infoTicket['ref']}' class='link-padrao table-link'><i class='fas fa-eye'></i></a></td>";
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan=7><font style='color: #666;'>Nenhum ticket foi registrado.</font></td></tr>";
        }
    ?>
    </tbody>
</table>