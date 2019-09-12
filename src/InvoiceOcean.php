<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace biorkes\InvoiceOcean;

class InvoiceOcean
{
    protected $api_token;
    protected $service_url;
    protected $company_name;
    
    /**
     *
     * @var array
     */
    private $data = array();

    
    /**
     * 
     * @param string $api_token
     * @param string $company_name
     */
    public function __construct( string $api_token, string $company_name )
    {
        $this->api_token = $api_token;
        $this->company_name = $company_name;
        $this->service_url = 'https://' . $this->company_name . '.invoiceocean.com/invoices.json' ;
    }
    
    protected function _addToken( array $data )
    {
        if( !is_array( $data ) )
        {
            throw new Exception('Data is not an array');
        }
        
        $data["api_token"] = $this->api_token;
        
        return $data;
    }
    
    protected function _buildQuery( array $data )
    {
        return http_build_query($data);
    }
    
    protected function _prepData( array $data )
    {
        $data = $this->_addToken($data);
        $data = $this->_buildQuery($data);
        return $data;
    }

    protected function _postRequest( array $data )
    {
        $data = $this->_prepData($data);
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->service_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'Error:' . curl_error($ch);
        }
        
        curl_close ($ch);
        
        return $ch;
    }
    
    protected function _getRequest(string $destination = "", array $data )
    {
        $url = $this->service_url.$destination;
        $data = $this->_prepData($data);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';

        curl_setopt($ch, CURLOPT_URL, $url.$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'Error:' . curl_error($ch);
        }
        
        curl_close ($ch);
        
        return $ch;
    }

    public function getAll( string $period )
    {
        $this->data = array( 'period' => $period );
        $this->_request( $this->$data );
    }

    public function get( $invoice_id )
    {
        return $this->_request($invoice_data);
    }
    
    public function downloadPDF()
    {
        
    }
    
    public function sendEmail( $client_email )
    {
        
    }
    
    public function add( $invoice_data )
    {
        
    }
    
    public function delete( $invoice )
    {
    }
}