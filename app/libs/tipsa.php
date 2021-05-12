<?php 
/**
 * Clase que gestiona los envios que se realizan mediante TIPS@.
 * Las funcionalidades que se implementan son las siguientes:
 *  .- getFunctions
 *  .- getTypes
 *  .- GrabaEnvio16
 *  .- BorraEnvio
 *  .- ConsEnvEstados
 *  .- ConsEnvio
 *  .- ConsEtiquetaEnvio5
 *  
 *  
 *  CREDENCIALES DEPLOY
 *  
 *       $user       =   "00899";
 *       $password   =   "Tecnol899";
 *       $codeAgent  =   "043002";
 *       $urlBase    =   "http://webservices.tipsa-dinapaq.com/SOAP";
 *       $location   =   "http://webservices.tipsa-dinapaq.com/SOAP?service=LoginWSService";
 *       
 *  CREDENCIALES DEV
 *  
 *       $user              =   "33333";
 *       $password          =   "PR%20%18%";
 *       $codeAgent         =   "000000";
 *       $urlBase           =   "http://79.171.110.38:8097/";
 *       $location          =   "http://79.171.110.38:8097/SOAP?service=LoginWSService";
 *       $strCodAgeCargo    =   "000000";   //  CODIGO POSTAL ORIGEN REUS (TARRAGONA) 043002
 *       $strCodAgeOri      =   "000000";   //  CODIGO POSTAL ORIGEN REUS (TARRAGONA) 043002
 *       
 *   CONTACTO SOPORTE TIPS@ 
 *      email  : integraciones@tip-sa.com
 *      Nombre : sr. Pablo Rodr�guez de Jos� 
 *  
 * @author ferrys
 *
 */
define("DATA_TYPE"      ,   0);
define("DATA_VALUE"     ,   1);

class tipsa{

    /**
     * Error messages
     * @var unknown
     */
    public $errMsg;
    /**
     * Warning messages
     * @var unknown
     */
    public $warnMsg;
    /**
     * Info messages
     * @var unknown
     */
    public $infoMsg;
    
    /**
     * User credential 
     * @var string
     */
    public $user        =   "33333";      
    /**
     * User password
     * @var string
     */
    public $password    =   "PR%20%18%";    
    /**
     * Agent Code
     * @var string
     */
    public $codeAgent   =   "000000";       
    /**
     * Url base of the TIPS@'s webservice
     * @var string
     */
    public $urlBase     =   "http://79.171.110.38:8097/";                               
   
    /**
     * Url of the webservice
     * Para el login este:
     *   DEV        "http://79.171.110.38:8097/SOAP?service=LoginWSService" 
     *   DEPLOY     "http://webservices.tipsa-dinapaq.com/SOAP?service=LoginWSService"
     * Una vez logueado usar este:
     *   DEV        "http://79.171.110.38:8097/SOAP?service=WebServService"
     *   DEPLOY     "http://webservices.tipsa-dinapaq.com/SOAP?service=WebServService"
     * @var string
     */
    public $urlWebService   =   "http://79.171.110.38:8097/SOAP?service=WebServService"; 
    /**
     * WebService wsdl file path.
     * Used for listing all the functionality and data types of the WebService.
     * @var unknown
     */
    public $soapWebServiceWSDLPath  =  'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
    /**
     * WebService wsdl file path.
     * Used for listing the login functions and data types.
     * @var unknown
     */
    public $soapLoginWSDLPath       =   'wsdl'.DIRECTORY_SEPARATOR.'LoginWSService.wsdl';
    
    /**
     * GrabaEnvio16 parameters.
     * @var array
     */
    public $grabaEnvioParams    =   array(
        /**
         * C�digo de la agencia a la que pertenece el cliente.
         */
        "strCodAgeCargo"    =>  array( XSD_STRING,      "000000"),
        /**
         * C�digo de la agencia que recoger� el paquete e iniciar� el env�o. (043002, TARRAGONA)
         */
        "strCodAgeOri"      =>  array( XSD_STRING,      "000000"),       
        /**
         * Fecha del envio
         */
        "dtFecha"           =>  array( XSD_DATETIME,    "00/00/00"),     
        /**
         * Es el c�digo del tipo de servicio. Posibles valores:
         * .- 48 sirve para pen�nsula
         * .- 06 Para Baleares
         * .- 14 Para toda Espa�a
         */
        "strCodTipoServ"    =>  array( XSD_STRING,      "14"),
        /**
         * El usuario que utilizamos para validarnos en TIPS@.
         */
        "strCodCli"         =>  array( XSD_STRING,      ""),
        /**
         * Nombre del remitente.
         */
        "strNomOri"         =>  array( XSD_STRING,      "TQ TECNOL, S.A.U."),
        /**
         *  Direcci�n del remitente.
         */
        "strDirOri"         =>  array( XSD_STRING,      "C/ GUERAU DE LIOST, 11-13"),
        /**
         * Poblaci�n del remitente.
         */
        "strPobOri"         =>  array( XSD_STRING,      "REUS"),               
        /**
         * C�digo postal del remitente.
         */
        "strCPOri"          =>  array( XSD_STRING,      "43206"),              
        /**
         * Tlf de contacto del remitente.
         */ 
        "strTlfOri"         =>  array( XSD_STRING,      "977333353"),          
        /**
         * Nombre del destinatario
         */
        "strNomDes"         =>  array( XSD_STRING,      "CLIENTE S.L.U.U.U"),        
        /**
         * Direcci�n destinatario
         */
        "strDirDes"         =>  array( XSD_STRING,      "C/ DEL CLIENTE, n1, 1-4"),   
        /**
         * Poblaci�n destinatario
         */
        "strPobDes"         =>  array( XSD_STRING,      "TARRAGONA"),          
        /**
         * C�digo Postal destinatario
         */
        "strCPDes"          =>  array( XSD_STRING,      "43002"),              
        /**
         *  Tlf contacto destinatario
         */
        "strTlfDes"         =>  array( XSD_STRING,      "444555666"),
        /**
         * intPaq e intDoc determinan el n�mero de bultos que tendr� el env�o. 
         * IntPaq es para las cajas e intDoc para los sobres. Si solo env�as 
         * de un tipo, solo tienes que especificar uno de ellos.
         */
        "intPaq"            =>  array( XSD_INT,         1),             
        /**
         * Peso en origen en Kg.
         */
        "dPesoOri"          =>  array( XSD_DOUBLE,      0), 
        /**
         * Cantidad a cobrar en contrareembolso en euros.
         */
        "dReembolso"        =>  array( XSD_DOUBLE,      0),
        /**
         * Observaciones
         */
        "strObs"            =>  array( XSD_STRING,      "Observaciones"),       
        /**
         * Nuestra referencia interna, puede ser el n�mero de albar�n.
         */
        "strRef"            =>  array( XSD_STRING,      "LV777888"),            
        /**
         *  En el caso de que se vaya a editar un env�o este par�metro indica el
         *  n�mero de albar�n. Si se est� insertando este par�metro no se tiene
         *  en cuenta.
         */
        "strAlbaran"            =>  array( XSD_STRING,      ""),
        /**
         * Persona de contacto del destino.
         */
        "strPersContacto"   =>  array( XSD_STRING,      ""),
        /**
         * S�lo para envios internacionales
         */
        "strCodPais"        =>  array( XSD_STRING,      "ES"),
        /**
         * Indica si se est� insertando un nuevo pedido. 
         * Debe ponerse en false en casao de editar un 
         * pedido e indicar el campo strAlbaran
         */
        "boInsert"          =>  array( XSD_BOOLEAN,     true),                             
        /**
         * Solo para env�os internacionales. Aqu� se declara 
         * lo que contiene el env�o, para que lo sepan en las 
         * aduanas.
         */
        //"strContenido"      =>  array( XSD_STRING,      ""),
    );
    /**
     * SOAP Version
     * @var string
     */
    public $version         =   SOAP_1_1;
    /**
     * SOAP response style.
     * @var string
     */
    public $soapStyle       =   SOAP_DOCUMENT;
    /**
     * SOAP XML response.
     * @var string
     */
    public $soapUse         =   SOAP_LITERAL;
    /**
     * XML Header where is gonna be the LoginID.
     * @var string
     */
    public $soapHeader      =   "";
    public $soapOptions     =   array(
        'uri'           => '',
        'location'      => '',
        'soap_version'  => '',
        'exceptions'    => true,
        'trace'         => true,
        'style'         => '',
        'use'           => '',
    );
    /**
     * LoginID is a unique identifier varchar chain, that expires
     * in 15  minutes.
     * @var string
     */
    public $loginID         =   "";
    /**
     * Constructor
     * @param string $user
     * @param string $password
     * @param string $codeAgent
     * @param string $urlBase
     * @param string $urlService
     */
    function __construct($user="",$password="", $codeAgent="", $urlBase="", $urlLoginService="",$urlWebService="")
    {
        if($user                !=  "")
        {
            $this->user             =   $user;    
        }
        
        if($password            !=  "")
        {
            $this->password         =   $password;    
        }
        
        if($urlBase             !=  "")
        {
            $this->urlBase          =   $urlBase;
        }

        if($urlWebService       !=  "")
        {
            $this->urlWebService    =   $urlWebService;
        }
        
        if($codeAgent != "")
        {
            $this->codeAgent        =   $codeAgent;
        }

        $this->soapLoginWSDLPath        =   dirname(__FILE__).DIRECTORY_SEPARATOR.$this->soapLoginWSDLPath;
        $this->soapWebServiceWSDLPath   =   dirname(__FILE__).DIRECTORY_SEPARATOR.$this->soapWebServiceWSDLPath;
    }
    
    /**
     *  Sets a new soap header.
     */
    private function setSoapHeader()
    {
        $headerXML   =<<<XML
<ROClientIDHeader xmlns="http://tempuri.org/">
    <ID>$this->loginID</ID>
</ROClientIDHeader>
XML;
        $sHeaderVar         =   new SoapVar($headerXML, XSD_ANYXML);
        $this->soapHeader   =   new SoapHeader('http://tempuri.org/','RequestParams',$sHeaderVar);
    }
    
    /**
     * Sets the soap options array.
     */
    private function setSoapOptions()
    {
        $this->soapOptions['uri']           =   $this->urlBase;
        $this->soapOptions['location']      =   $this->urlWebService;
        $this->soapOptions['soap_version']  =   $this->version;
        $this->soapOptions['exceptions']    =   true;
        $this->soapOptions['trace']         =   true;
        $this->soapOptions['style']         =   $this->soapStyle;
        $this->soapOptions['use']           =   $this->soapUse;
    }
    
    /**
     * 
     */
    
    /**
     * Se encarga de crear un envio en el sistema de TIPS@
     * @return unknown
     */
    public function GrabaEnvio16()
    {
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET A NEW SOAP HEADER FOR INDICATING SOAP LOGIN ID
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SET THE CALL PARAMETERS
        $params[]       =   array();
        foreach($this->grabaEnvioParams as $key=>$value)
        {
            $params[]   =   new SoapVar($value[DATA_VALUE],   $value[DATA_TYPE],     null, null, $key);
        }
        
        //ENCAPSULATE ALL SOAP PARAMS IN A STRUCT DATA
        $sVarParam      =   new SoapVar($params, SOAP_ENC_OBJECT); //STRUCT
        
        //CALL THE FUNCTION DEFINED IN WSDL FILE
        $result         =   $sClient->GrabaEnvio16($sVarParam);//WSDL
        
        return $result;
    }
    /**
     * Se encarga de hacer el loggin en el sistema de TIPS@ del cual recuperaremos
     * el login id para poder hacer las llamadas. Dicho ID tiene una caducidad de
     * 15 minutos.
     */
    private function loginCLI(){
       
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       =   $this->soapLoginWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =   new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET A NEW SOAP HEADER FOR INDICATING SOAP LOGIN ID
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SET THE CALL PARAMETERS
        $params[]   =   array();
        $params[]   =   new SoapVar($this->codeAgent,   XSD_STRING,     null, null, "strCodAge");
        $params[]   =   new SoapVar($this->user,        XSD_STRING,     null, null, "strCod");
        $params[]   =   new SoapVar($this->password,    XSD_STRING,     null, null, "strPass");
        
        //ENCAPSULATE ALL SOAP PARAMS IN A STRUCT DATA
        $sVarParam      =   new SoapVar($params, SOAP_ENC_OBJECT); //STRUCT
        
        //CALL THE FUNCTION DEFINED IN WSDL FILE
        $result         =   $sClient->LoginCli($sVarParam);//WSDL
        
        //RESULT
        $this->loginID  =   $result->strSesion;
    }
    
    /**
     * Elimina el envio del sistema de TIPS@ pasandole el n�mero de albar�n.
     * @param unknown $codeAgeCargo
     * @param unknown $codeAgeOri
     * @param unknown $albaran
     * @return unknown
     */
    public function BorraEnvio($albaran,$codeAgeCargo, $codeAgeOri)
    {
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET A NEW SOAP HEADER FOR INDICATING SOAP LOGIN ID
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        $params          =   array();
        $params[]        =   new SoapVar($codeAgeOri,    XSD_STRING,     null, null, 'strCodAgeOri');
        $params[]        =   new SoapVar($codeAgeCargo,  XSD_STRING,     null, null, 'strCodAgeCar');
        $params[]        =   new SoapVar($albaran,       XSD_STRING,     null, null, 'strAlbaran');
        $sVarParam       =   new SoapVar($params,        SOAP_ENC_OBJECT); //STRUCT
        
        //SOAP FUNCTION CALL
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        $result         =   $sClient->BorraEnvio($sVarParam);//WSDL
        return $result;
        
        /*
         switch($result->intCodErrorOut){
            case 0: //EL ENVIO HA SIDO BORRADO CORRECTAMENTE
                
                break;
            case 1: break; //NO EXISTE EL ENVIO
            case 2: break; //NO TIENE PERMISOS PARA BORRAR EL ENVIO
            case 3: break; //NO TIENE PERMISOS PARA MODIFICAR EL ENVIO
            case 4:
            default: //ERROR DESCONOCIDO
                
                break;
        }
        echo "RESult <br>";
        */
        //FIN BORRA ENVIO
    }
    
    /**
     * Recupera los estados de un envio mediante su albar�n.
     * 
     * @param unknown $albaran
     * @param unknown $codeAgeCargo
     * @param unknown $codeAgeOri
     */
    public function EstadosEnvio($albaran,$codeAgeCargo,$codeAgeOri)
    {
        $statusList =   array();
        
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //ESTADOS        
        $params          =   array();
        $params[]        =   new SoapVar($codeAgeCargo, XSD_STRING, null, null, 'strCodAgeCargo');
        $params[]        =   new SoapVar($codeAgeOri,   XSD_STRING, null, null, 'strCodAgeOri');
        $params[]        =   new SoapVar($albaran,      XSD_STRING, null, null, 'strAlbaran');
        $sVarParam       =   new SoapVar($params, SOAP_ENC_OBJECT); //STRUCT
        
        //SOAP SET HEADER
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SOAP CALL FUNCTION
        $result         =   $sClient->ConsEnvEstados($sVarParam);//WSDL
        $xmlDataEstados =   simplexml_load_string( $result->strEnvEstados );
        
        if(isset($xmlDataEstados->ENV_ESTADOS))
        {
            foreach($xmlDataEstados->ENV_ESTADOS as $estado)
            {
                $attrList   =   $estado->attributes();
                if($attrList!=null && !empty($attrList))
                {
                    /*$statusList=array(
                        "0"=>"INICIO",
                        "1"=>"TRANSITO",
                        "2"=>"REPARTO",
                        "3"=>"ENTREGADO",
                        "4"=>"INCIDENCIA",
                        "5"=>"DEVUELTO",
                        "6"=>"FALTA EXPEDICION",
                        "7"=>"RECANALIZADO",
                        "8"=>"---???---",
                        "9"=>"FALTA EXPEDIENTE ADMINISTRATIVO",
                        "10"=>"DESTRUIDO",
                        "12"=>"---���---",
                    );*/
                    $statusList[]   =   $estado;
                }
            }
        }
        return $statusList;
        //FIN ESTADOS
    }
    
    /**
     * Recupera los estados de un envio en la fecha seleccionada.
     * 
     * @param unknown $date
     * @return unknown[]
     */
    public function EstadosEnvioFecha($date)
    {
        $statusList =   array();
        
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET PARAMS
        $dateRequest    =   $date;//date('Y/m/d');
        $params         =   array();
        $params[]       =   new SoapVar($dateRequest,   XSD_DATETIME, null, null, 'dtFecha');
        $sVarParam      =   new SoapVar($params,        SOAP_ENC_OBJECT); //STRUCT
        
        //SOAP HEADER
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SOAP FUNCTION CALL
        $result         =   $sClient->ConsEnvEstadosFecha($sVarParam);//WSDL
        $xmlDataEstados =   simplexml_load_string( $result->strEnvEstados );
        
        if(isset($xmlDataEstados->ENV_ESTADOS))
        {
            foreach($xmlDataEstados->ENV_ESTADOS as $estado)
            {
                $attrList   =   $estado->attributes();
                if($attrList!=null && !empty($attrList))
                {
                    /*$statusList=array(
                     "0"=>"INICIO",
                     "1"=>"TRANSITO",
                     "2"=>"REPARTO",
                     "3"=>"ENTREGADO",
                     "4"=>"INCIDENCIA",
                     "5"=>"DEVUELTO",
                     "6"=>"FALTA EXPEDICION",
                     "7"=>"RECANALIZADO",
                     "8"=>"---???---",
                     "9"=>"FALTA EXPEDIENTE ADMINISTRATIVO",
                     "10"=>"DESTRUIDO",
                     "12"=>"---���---",
                     );*/
                    $statusList[]   =   $estado;
                }
            }
        }
        return $statusList;
        //FIN ESTADOS
    }
    
    /**
     * Recupera la informaci�n de un envio, dado el n�mero de
     * albar�n.
     * @param unknown $albaran
     * @param unknown $codeAgeCargo
     * @param unknown $codeAgeOri
     * @return SimpleXMLElement
     */
    public function InfoEnvio($albaran, $codeAgeCargo, $codeAgeOri){

        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET PARAMS
        $params         =   array();
        $params[]       =   new SoapVar($codeAgeCargo, XSD_STRING, null, null, 'strCodAgeCargo');
        $params[]       =   new SoapVar($codeAgeOri,   XSD_STRING, null, null, 'strCodAgeOri');
        $params[]       =   new SoapVar($albaran,      XSD_STRING, null, null, 'strAlbaran');
        $sVarParam      =   new SoapVar($params,       SOAP_ENC_OBJECT); //STRUCT
        
        //SOAP HEADER
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SOAP FUNCTION CALL
        $result     =   $sClient->ConsEnvio($sVarParam);//WSDL
        $xmlResult  =   simplexml_load_string( $result->strEnvio);
       
        return $xmlResult;
    }
    /**
     * Imprime la etiqueta del envio indicando su n�mero de albar�n.
     * @param unknown $albaran
     * @param unknown $codeAgeCargo
     * @param unknown $codeAgeOri
     * @param string $bulto
     * @param string $tipoEtiqueta
     * @param string $formato
     */
    public function ImprimirEtiqueta($albaran, $codeAgeCargo, $codeAgeOri, $bulto="1", $tipoEtiqueta="225", $formato="txt")
    {
         //ETIQUETA IMPRIMIR
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET A NEW SOAP HEADER FOR INDICATING SOAP LOGIN ID
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SET PARAMS
        $params          =   array();
        $params[]        =   new SoapVar($codeAgeOri,    XSD_STRING,     null, null, 'strCodAgeOri');
        $params[]        =   new SoapVar($albaran,       XSD_STRING,     null, null, 'strAlbaran');
        $params[]        =   new SoapVar($formato,       XSD_STRING,     null, null, 'strFormato');
        $params[]        =   new SoapVar($tipoEtiqueta,  XSD_STRING,     null, null, 'IntIdRepDet');
        $params[]        =   new SoapVar($bulto,         XSD_STRING,     null, null, 'strNumBulto');
        $sVarParam       =   new SoapVar($params,         SOAP_ENC_OBJECT); //STRUCT
        
        //SOAP FUNCTION CALL
        $result             =   $sClient->ConsEtiquetaEnvio5($sVarParam);//WSDL
        $decodedResult      =   $result->strEtiqueta;
        $sock    =   null;
        $check   =   false;
        try{
            if(strlen($decodedResult)==0){throw new Exception();}
            $address   =   "10.10.31.12";
            $port      =   "9100";
            $domain    =   AF_INET;
            $type      =   SOCK_STREAM;
            $protocol  =   SOL_TCP;
            
            if (($sock = socket_create($domain, $type, $protocol)) === false)
            {
                throw new Exception("Fallo en la creación del Socket");
            }
            
            if(socket_connect($sock, $address, $port)===false)
            {
                throw new Exception("Fallo de conexión.".socket_strerror(socket_last_error($sock)));
            }
            
            //CONFIG
            $configCmd="
            ~SD15
            ~TA000
            ~JSN
            ^XA
            ^SZ2
            ^PW831
            ^LL1176
            ^PON
            ^PR5,5
            ^PMN
            ^MNY
            ^LS0
            ^MTD
            ^MMT,N
            ^MPE
            ^XZ
            ^XA^JUS^XZ";
            $sent       =   socket_write($sock,$configCmd);
            if($sent===strlen($configCmd))
            {
                $sent       =   socket_write($sock,$decodedResult);
            }
            $check   =   ($sent==strlen($decodedResult));
        }catch(Exception $e){
            $check  =   false;
        }finally{
            socket_close($sock);
            return $check;
        }
    }
    /**
     * Devuelve el listado de funciones disponibles en el sistema.
     * @return array
     */
    public function getFunctions(){
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET A NEW SOAP HEADER FOR INDICATING SOAP LOGIN ID
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SOAP FUNCTION CALL
        return $sClient->__getFunctions();
    }
    /**
     * Devuelve el listado de los tipos de datos disponibles en el sistema.
     * @return array
     */
    public function getTypes(){
        // SET SOAPOPTIONS
        $this->setSoapOptions();
        
        //SET WSDLPATH
        $wsdlPath       = $this->soapWebServiceWSDLPath;//'wsdl'.DIRECTORY_SEPARATOR.'WebServService.wsdl';
        
        //CREATE A NEW CLIENT
        $sClient        =  new SoapClient($wsdlPath,$this->soapOptions);
        
        //SET A NEW SOAP HEADER FOR INDICATING SOAP LOGIN ID
        $this->setSoapHeader();
        $sClient->__setSoapHeaders($this->soapHeader);
        
        //SOAP FUNCTION CALL
        return $sClient->__getTypes();
    }
   
    /**
     * Encapsula la funci�n loginCLI
     */
    public function login()
    {
        $this->loginCLI();
    }
}
?>