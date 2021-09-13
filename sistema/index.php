<?php
// Verificador de sessão
require "../../etc/logado.php";
include ('../../header.php');	

?>
    
    <!-- main -->
    <main class="acessibilidade" id="main">
        <div class="container p-3">
            <h2 class="text-center font-weight-bold">Reserva de sala</h2>
        </div>

        <!-- Botões -->
        <div class="container">
            <div id="botoes-principais">
                <h3 class="text-center font-weight-bold p-3">Menu</h3>
                <ul class="nav justify-content-center">
                    <li class="nav-item p-1"><a href="salas.php" class="btn btn-primary btn-lg text-center" role="button" aria-disabled="true">Salas</a></li>
                    <li class="nav-item p-1"><a href="reservas.php" class="btn btn-success btn-lg text-center" role="button" aria-disabled="true">Reservas</a></li>
                </ul>
            </div> 
        </div>
    </main>
    <!-- //main -->


    <?php
		include ('../../footer.php');	
    ?>

</body>
</html>