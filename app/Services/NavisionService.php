<?php

namespace App\Services;

/**
 * SoapNavClient
 * cliente SOAP basado en el protocolo ODATAv4, en el que
 * se implementa las operaciones CRUD(create, read, update y Delete).
 * .- Debe activarse ODATA Services en el servicio de dynamicsNav.
 * .- Debe activarse la autorizaci�n via NTLM en el servicio de dynamicsNAV
 * .- El usuario para loggearse es el mismo usuario de Active Directory, es
 *    decir el mismo pass y usuario que se usa para loggear en el ordenador.
 * @author ferrys
 */

use Exception;

define('HTTP_OK',200);
define('HTTP_CREATED',201);
define('HTTP_NO_CONTENT',204);
class NavisionService
{
public $errMsg;
public $warnMsg;
public $infoMsg;
public $url;
public $user;
public $password;

    /**
     * Constructor.
     * @param string $url
     * @param string $user
     * @param string $password
     */
    function __construct($url="",$user="",$password="")
    {
        $this->url = $url;
        $this->user = env('NAV_USER');
        $this->password = env('NAV_PASSWORD');
    }

    /**
     * Se asegura que el usuario y el password sean correctos.
     * @param unknown $user
     * @param unknown $password
     * @return boolean
     */
    public function checkAuthorization()
    {
        $userpwd="$this->user:$this->password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        curl_exec($ch);
        $resCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($resCode==HTTP_OK);
    }

    /**
     * Lista todos los objetos del recurso solicitado.
     * @return mixed
     */
    public function listAll()
    {
       $result="";
       $userpwd="$this->user:$this->password";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $this->url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
       curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
       curl_setopt($ch, CURLOPT_POST, false);
       curl_setopt($ch, CURLOPT_HTTPHEADER, [
           'Accept: application/json',
           'Content-Type: application/json'
       ]);
       $result = curl_exec($ch);
       $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       curl_close($ch);
       if( $resultCode != HTTP_OK )
       {
           echo $result;
           throw new Exception($resultCode);
       }
       return json_decode($result,true);    
    }

    /**
     * Crea un nuevo registro.
     * @param unknown $data
     */
    public function create($data)
    {
        $resultCode = "";
        $userpwd    = "$this->user:$this->password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if( $resultCode != HTTP_CREATED )
        {
            return $response;
            throw new Exception($resultCode);
        }
        return json_decode($response, true);
    }

    /**
     * Lee la informaci�n del registro seleccionado.
     * @return mixed
     */
    public function read()
    {
        $result="";
        $userpwd    = "$this->user:$this->password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        $output= curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $result=json_decode($output,true);
        if( $resultCode != HTTP_OK )
        {
            throw new Exception($resultCode);
        }
        return $result;
    }

    /**
     * Actualiza el registro seleccionado.
     * @param unknown $etag
     * @param unknown $data
     */
    public function update($etag,$data)
    {
        $resultCode = "";
        $userpwd    = "$this->user:$this->password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ("Content-Type: application/json","If-Match: ".$etag));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result=curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if( $resultCode != HTTP_OK )
        {
            throw new Exception($result);
        }
    }

    /**
     * Borra el registro indicado en la url.
     */
    public function delete()
    {
        $resultCode="";
        $userpwd="$this->user:$this->password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if( $resultCode != HTTP_NO_CONTENT )
        {
            print_r($response);
            throw new Exception($resultCode);
        }
    }

      /** 
     * Llama a una función definida en el recurso.
     * P.e:
     *   http://webservice.tecnol.es:7048/DynamicsNAV110/ODataV4/Company('T.Q.%20TECNOL%2C%20S.A.')/Producto(No='70513')/NAV.UpdateFieldTest
     *   Se puede verificar la existencia de la función("action") llamando al $metadata:
     *       http://webservice.tecnol.es:7048/DynamicsNAV110/ODataV4/$metadata
     *  timeout en MS
     * @param array $data
     * @throws Exception
     * @return mixed
     */
    public function actionCall($data=array(),$timeout=0)
    {
        $resultCode = "";
        $userpwd    = "$this->user:$this->password";
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        if($timeout > 0 ){curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);}
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output     =   curl_exec($ch);
        $resultCode =   curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $result=json_decode($output,true);
        if( $resultCode != HTTP_OK )
        {
            throw new Exception($output);
        }
        return $result;
    }
}
?>
