<?php

class PagSeguro { 
    
    /**
     * Url da api pagsegur
     *
     * @var string
     */
    protected $url_api = 'https://ws.sandbox.pagseguro.uol.com.br';
    //protected $url_api = 'https://ws.pagseguro.uol.com.br';
    protected $url_api2 = 'https://api.pagseguro.com/checkouts';

    /**
     * Url do pagseguro
     *
     * @var string
     */
    //protected $url = 'https://sandbox.pagseguro.uol.com.br';
    protected $url = 'https://pagseguro.uol.com.br';
    protected $url2 = 'https://pagamento.pagseguro.uol.com.br';

    /**
     * Rota de checkout
     *
     * @var string
     */
    protected $route_checkout = '/v2/checkout';
    protected $route_checkout2 = '/checkouts';

    /**
     * Rota de transação
     *
     * @var string
     */
    protected $route_transaction = '/v2/transactions';
    protected $route_transaction2 = 'transfers';

    /**
     * Rota de redirect
     *
     * @var string
     */
    protected $route_redirect = '/v2/checkout/payment.html';
    protected $route_redirect2 = '/pagamento';
    
    /**
     * E-mail da conta utilizada
     *
     * @var string
     */
    //protected $email = 'pagseguro@odix.com.br';
    protected $email = 'financeirocpg66@gmail.com';
   
    /**
     * Token da conta utilizada
     */
    //protected $token = '532A22F8C1C1209DD46FCF99AAEC304B'; //odix prd
    //protected $token = '6BCF3BCEFC974CA5926BA54CF3B778A2'; //cpg hml
    //protected $token = 'ea12fa56-79d3-40e6-b173-da43dfc460096721e8af45c59475a2341aeda74796680638-f51e-4e9e-b4a1-d492b5603081';
    protected $token = 'eb894cd7-4f1c-4a87-b1ec-8dcc2edbf61de52782b84807894f93c3125df709e9a7d135-2c29-486d-b9b1-77018f9d81c8';

    public function solicitarPagamento(array $data) 
    {
        //echo '<pre>';print_r($data);exit;
        $ch = curl_init();
        $header = array();
        $header[] = 'Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1';
     
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $this->url_api . $this->route_checkout. '?email=' . $this->email . '&token=' . $this->token);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close ($ch);
        //echo '<pre>';print_r($result);exit;
        return $result;
    }

    public function redirecionarPagamento($code)
    {
        return $this->url . $this->route_redirect . '?code=' . $code;
    }

    public function consultarTransacao($token)
    {
        $ch = curl_init();

        $header = array();
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
     
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $this->url_api . $this->route_transaction. '?email=' . $this->email . '&token=' . $this->token . '&reference=' . $token . '&transaction_code='.$token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close ($ch);

        return simplexml_load_string($result);
    }

    public function linkPagamento(array $data) 
    {
      $hoje = date('Y-m-d\TH:i:s');
      $venc = date('Y-m-d\TH:i:s-03:00', strtotime("+15 minutes",strtotime($hoje)));
        $dados_pagador = '{
            "reference_id": "'.$data['reference'].'",
            "expiration_date": "'.$venc.'",
            "created_at": "'.$hoje.'",
            "status": "ACTIVE",
            "customer": {
              "name": "'.$data['senderName'].'",
              "email": "'.$data['senderEmail'].'",
              "tax_id": "'.$data['senderCPF'].'",
              "phone": {
                "country": "+55",
                "area": "'.$data['senderAreaCode'].'",
                "number": "'.$data['senderPhone'].'"
              }
            },
            "customer_modifiable": true,
            "items": [
              {
                "reference_id": "'.$data['itemId1'].'",
                "name": "'.$data['itemDescription1'].'",
                "quantity": 1,
                "unit_amount": '.$data['itemAmount1'].'
              }
            ],
            "additional_amount": 0,
            "discount_amount": 0,
            "shipping": {
              "type": "FREE",
              "amount": 0,
              "address": {
                "country": "BRA",
                "region_code": "'.$data['regionCode'].'",
                "city": "'.$data['city'].'",
                "postal_code": "'.$data['postalCode'].'",
                "street": "'.$data['street'].'",
                "number": "'.$data['number'].'",
                "locality": "'.$data['locality'].'",
                "complement": "'.$data['complement'].'"
              },
              "address_modifiable": true
            },
            "payment_methods": [
              {
                "type": "CREDIT_CARD",
                "brands": [
                  "MASTERCARD",
                  "VISA"
                ]
              },
              {
                "type": "DEBIT_CARD",
                "brands": [
                  "VISA"
                ]
              },
              {
                "type": "PIX"
              }
            ],
            "payment_methods_configs": [
              {
                "type": "CREDIT_CARD",
                "config_options": [
                  {
                    "option": "INSTALLMENTS_LIMIT",
                    "value": "1"
                  }
                ]
              }
            ],
            "soft_descriptor": "CPG-pag",
            "redirect_url": "https://cpg.com.br/socios/payments?pg=redirect",
            "return_url": "https://cpg.com.br/socios/payments?pg=return",
            "notification_urls": [
              "https://cpg.com.br/socios/payments?pg=notifica"
            ],
            "payment_notification_urls": [
              "https://cpg.com.br/webhook/action/pagseguro?act=payntf"
            ]
          }';
          // showObject($dados_pagador);

          //checkout usando token
          //$conn = 'https://sandbox.api.pagseguro.com/checkouts';
          $conn = 'https://api.pagseguro.com/checkouts';
          $token = $this->token;
          $body = $dados_pagador;
          $head = array('Content-Type: application/json', 'Content-Length: '.strlen($body), 'Authorization: Bearer '.$token);

          $api = new ApiRest($conn); 
          $res = $api->post($body, $head); 
          $obj = json_decode($res); 
          
          return $obj;
    }


}