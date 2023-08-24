<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();
class Home extends CI_Controller {

    public function payment_load($centralisedId) {
        error_reporting(E_ALL);
        $check = true;
        $sale_Amount = 1000;
        $travel_date = data('Y-m-d',time());
        $customer_id = 1;
        if ($check) {
            $payment_data = array(
                'insert_id' => 1,
                'booking_id' => 'booking_id',
                'module' => 'Hotel',
                'sender_total_amount' => $sale_Amount,
                'response_status' => 'Pending',
                'booking_date' => $travel_date,
                'customer_id' => $customer_id
            );
            // $this->db->insert('payment_transactions',$payment_data);
            // $pay_id = $this->db->insert_id();
            $pay_id = 1;
            
            if(true){
                $convieniance = 0;
                $convieniance_fee = 0;
                $convieniance_type = 'No';
                
                if($convieniance_fee > 0){
                    if($convieniance_type == 0){
                        $applied_con = $convieniance_fee/1; 
                    }else{
                        $applied_con = ($ka*$convieniance_fee)/100;
                    }
                }   
                $data['klarnaAmount'] = round($sale_Amount+$applied_con);
                $data['totalAmountKlarna'] = round($sale_Amount+$applied_con);
            }
            $data['applied_con'] = $applied_con;
            $data['amount'] = round($sale_Amount,2);
            $data['totalAmount'] = round($sale_Amount,2);
            $data['currency'] = $currency;
            $data['centralisedId'] = $centralisedId;
            $data['insert_id'] = $insert_id;
            $data['pay_id'] = $pay_id;
            $data['booking_id'] = $booking_id;
            
            $data['url_hit'] = base_url('hotels_new/getclientsecret');
            $data['stripe_update_response'] = base_url('hotels_new/update_response');
            $data['error_response'] = base_url('hotels_new/update_error_response');
            $data['eloven_update_response'] = base_url('hotels_new/elovenupdate_response');
            $data['eloven_error_response'] = base_url('hotels_new/eloven_error_response');
            $data['error_response'] = base_url('hotels_new/update_error_response');
            $data['bookings'] = base_url('hotels_new/hotel_booking_payment/'.$centralisedId.'/'.$insert_id);
            $data['payment_error'] = base_url('hotels_new/payment_error/'.$insert_id);
            $data['mobile_no'] = $country_code . ' ' . $mobile_no;
            $data['name'] = $cust_name;
            $data['email'] = $customer_id;
            echo "<pre>";print_r($data);die;
            $this->load->view('klarna_checkout',$data);
        }
    }
    
}