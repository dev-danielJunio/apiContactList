<?php

namespace Classes\Validator;

use Classes\Repository\TokensAutorizadosRepository;
use Classes\Service\UsuariosService;
use Classes\Util\ConstantesGenericasUtil;
use Classes\Util\JsonUtil;
use InvalidArgumentException;

class RequestValidator{

    private $request;
    private array $dadosRequest = [];
    private object $TokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';

    public function __construct($request)
    {
        $this->request = $request;
        $this->TokensAutorizadosRepository = new TokensAutorizadosRepository();
    }

    public function processarRequest() {
         $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;


         $this->request['metodo'] == 'POST';
         if(in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)){
            $retorno = $this->direcionarRequest();
         }
         return $retorno; //Erro
         
    }

    private function direcionarRequest(){

        if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE){
            $this->dadosRequest = JsonUtil::tratarCorpoRequsicaoJson();
        }
        $this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        $metodo = $this->request['metodo'];
        return $this->$metodo(); //função variaveis get();
    }

    private function get(){
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)){
            switch ($this->request['rota']){
                case self::USUARIOS:
                    $usuariosService = new UsuariosService($this->request);
                    $retorno = $usuariosService->validarGet();
                    break;
                default:
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function delete(){
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE, true)){
            switch ($this->request['rota']){
                case self::USUARIOS:
                    $usuariosService = new UsuariosService($this->request);
                    $retorno = $usuariosService->validarDelete();
                    break;
                default:
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function post(){
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_POST, true)){
            switch ($this->request['rota']){
                case self::USUARIOS:
                    $usuariosService = new UsuariosService($this->request);
                    $usuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $usuariosService->validarPost();
                    break;
                default:
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function put(){
        $retorno = null;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_PUT, true)){
            switch ($this->request['rota']){
                case self::USUARIOS:
                    $usuariosService = new UsuariosService($this->request);
                    $usuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $usuariosService->validarPut();
                    break;
                default:
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

}