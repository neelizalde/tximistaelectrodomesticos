<?php
    namespace App\Models\clientes;
    class Cliente
    {
        public $nombre;
        public $apellidos;
        public $telefono1;
        public $telefono2;

        function __construct(string $nombre,string $apellidos,int $telefono1,int $telefono2)
        {
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->telefono1 = $telefono1;
            $this->telefono2 = $telefono2;

        }

        function welcome()
        {
            return `Hola $this->nombre!!! Bienvenido`;
        }
    }
?>
