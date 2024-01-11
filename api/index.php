<?php

include 'bootstrap.php';
require 'vendor/autoload.php';

use Classes\Util\ConstantesGenericasUtil;
use Classes\Util\JsonUtil;
use Classes\Util\RotasUtil;
use Classes\Validator\RequestValidator;

try{
    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $RequestValidator->processarRequest();

    $JsonUtil = new JsonUtil;
    $JsonUtil->processarArrayParaRetornar($retorno);
}catch (Exception $exception){
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $exception->getMessage()

    ]);
    exit;
}
