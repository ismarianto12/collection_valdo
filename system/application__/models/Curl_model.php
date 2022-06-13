<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//class Curl_model extends CI_Model {
class Curl_model extends Model {

    public function curlpost($targeturl, $postdata, $header=array()){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $targeturl,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => $header
        ));

        $resp = curl_exec($curl);
        
        if($resp){
            $response['error'] = false;
            $response['message'] = 'CURL Executed Successfuly';
            $response['result'] = $resp;
        } else {
            $response['error'] = true;
            $response['message'] = 'CURL Execution Failed';
            $response['result'] = null;
            $response['debuginfo'] = curl_getinfo($curl);
            $response['errorinfo'] = curl_error($curl);
        }
            
        curl_close($curl);
        return $response;
    }
    
    function curlget($targeturl, $parser, $header=array()){
        $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $targeturl.$parser,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,            
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $header,
        ));
        
        $resp = curl_exec($curl);
        
        if($resp){
            $response['error'] = false;
            $response['message'] = 'CURL Executed Successfuly';
            $response['result'] = $resp;
        } else {
            $response['error'] = true;
            $response['message'] = 'CURL Execution Failed';
            $response['result'] = null;
            $response['debuginfo'] = curl_getinfo($curl);
            $response['errorinfo'] = curl_error($curl);
        }
            
        curl_close($curl);
        return $response;                
    }

}
?>