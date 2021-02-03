<?php

require 'vendor/autoload.php';

use CPFTool\CPF;

$cpf = 01234567890;

$tool = new CPF($cpf);

echo $tool->isValid() ? "CPF Válido | Dados: <br>" . $tool->getData() : "CPF Inválido";

// OU

if (CPF::validateCPF($cpf)) {
    echo "CPF Válido";
} else {
    echo "CPF Inválido";
}
