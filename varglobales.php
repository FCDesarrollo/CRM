<?php
    echo "<script>
            const pBloqueado = 0;
            const pLectura = 1;
            const pLecYEsc = 2;
            const pTodo = 3;
            var namePermisos = new Array('Bloqueado', 'Lectura', 'Lectura y Escritura','Todo'); 
            var nameModulos = new Array('No Existe', 'Administrador', 'Indesk','Icloud'); 
            //var ws = 'http://localhost/ApiConsultorMX/miconsultor/public/';
            var ws = 'http://apicrm.dublock.com/';
            //var gIDEmpresa = 0;
            //var gNombreEmpresa = '';
            var idempresaglobal = 0;
            var idusuarioglobal = 0;
            var tipousuarioglobal = 0;
            var idmoduloglobal = 0;
            var idmenuglobal = 0;
            var idsubmenuglobal = 0;
            var dash = 'http://crm.dublock.com/DashEmpresa/empuser/';
            //var dash = 'http://localhost/crm/DashEmpresa/empuser/';
        </script>";
?>