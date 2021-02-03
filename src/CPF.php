<?php

namespace CPFTool;

class CPF
{
    public $cpf;

    public function __construct($cpf = NULL)
    {
        $this->cpf = $cpf;
    }

    static function generateCPF()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://geradorapp.com/api/v1/cpf/generate?token=f01e0024a26baef3cc53a2ac208dd141',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response, true);
        return $data['data']['number'];
    }

    public function generate()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://geradorapp.com/api/v1/cpf/generate?token=f01e0024a26baef3cc53a2ac208dd141',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response, true);
        $this->cpf = $data['data']['number'];
    }

    public function isValid()
    {
        $cpf = $this->cpf;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://www.juventudeweb.mte.gov.br/pnpepesquisas.asp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'acao=consultar%20cpf&cpf=' . $cpf . '&nocache=0.7636039437638835',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Host: www.juventudeweb.mte.gov.br'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = str_replace('<ROOT>', '', $response);
        $response = str_replace('</ROOT>', '', $response);
        $response = str_replace('<PESSOAFISICA', '', $response);
        $response = str_replace('/>', '', $response);
        if (count(explode('NRCPF=', $response)) > 1) {
            return true;
        } else {
            return false;
        }
    }

    static function validateCPF($cpf)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://www.juventudeweb.mte.gov.br/pnpepesquisas.asp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'acao=consultar%20cpf&cpf=' . $cpf . '&nocache=0.7636039437638835',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Host: www.juventudeweb.mte.gov.br'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = str_replace('<ROOT>', '', $response);
        $response = str_replace('</ROOT>', '', $response);
        $response = str_replace('<PESSOAFISICA', '', $response);
        $response = str_replace('/>', '', $response);
        if (count(explode('NRCPF=', $response)) > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getData()
    {
        if ($this->cpf == NULL) {
            return json_encode(array("status" => "error", "message" => "CPF is not defined on construct and is not generated"));
        }
        $cpf = $this->cpf;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://www.juventudeweb.mte.gov.br/pnpepesquisas.asp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'acao=consultar%20cpf&cpf=' . $cpf . '&nocache=0.7636039437638835',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Host: www.juventudeweb.mte.gov.br'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = str_replace('<ROOT>', '', $response);
        $response = str_replace('</ROOT>', '', $response);
        $response = str_replace('<PESSOAFISICA', '', $response);
        $response = str_replace('/>', '', $response);
        if (count(explode('NRCPF=', $response)) > 1) {
            $cpf = explode('"', explode('NRCPF=', $response)[1])[1];
            $nome = explode('"', explode('NOPESSOAFISICA=', $response)[1])[1];
            $nascimento = explode('"', explode('DTNASCIMENTO=', $response)[1])[1];
            $mae = explode('"', explode('NOMAE=', $response)[1])[1];
            $cidade = explode('"', explode('NOMUNICIPIO=', $response)[1])[1];
            $estado = explode('"', explode('SGUF=', $response)[1])[1];
            $data['cpf'] = $cpf;
            $data['nome'] = $nome;
            $data['nascimento'] = $nascimento;
            $data['mae'] = $mae;
            $data['cidade_moradia'] = $cidade;
            $data['estado_moradia'] = $estado;

            return json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(array("status" => "error", "message" => "CPF is invalid"));
        }
    }
}
