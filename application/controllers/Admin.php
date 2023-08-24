<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: Joyonto Roy
 * 	date		: 27 september, 2014
 * 	primus School Management System Pro
 * 	http://codecanyon.net/user/Creativeitem
 * 	support@creativeitem.com
 */
session_start();
error_reporting(E_ALL);
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function student_profile_new($value='') {
        $this->load->view('backend/admin/student-profile');
    }
    public function multiselect($page = null) {
        if (isset($page) && $page === 'service') {
            return $this->load->view('backend/admin/service_multiselect',$this->input->post());
        }
        return $this->load->view('backend/admin/package_multiselect',$this->input->post());
        echo '<script src="assets/js/multiselect.js"></script>';

    }
    public function reward_masters($param1 = '', $param2 = '')
    {

            
        if (($param1 === 'create') === true) {
            $data = [
                'name' => $this->input->post('name'),
                'reward_point' => $this->input->post('reward_point'),
                'reward_category' => $this->input->post('reward_category')
            ];
            $data['createdBy'] = $this->session->userdata('login_type');
            $data['createdID'] = $this->session->userdata('login_user_id');
            if ($data['reward_category'] === 'student' ){
                $data['package_id'] = json_encode($this->input->post('package_id'));
            }

            if ($data['reward_category'] === 'customer_service' ){
                $data['customer_service_id'] = json_encode($this->input->post('customer_service_id'));
            }

            if ($data['reward_category'] === 'customer_task' ){
                $data['customer_task_id'] = json_encode($this->input->post('customer_task_id'));
            }

            if ($data['reward_category'] === 'customer_followup' ){
                $data['customer_followup'] = $this->input->post('customer_followup');
            }
            $this->db->insert('reward',$data);
            redirect($_SERVER['HTTP_REFERER']);

        }
        
        if($param1 === 'do_update') {
            $data = [
                'name' => $this->input->post('name'),
                'reward_point' => $this->input->post('reward_point'),
                'reward_category' => $this->input->post('reward_category')
            ];
            $data['createdBy'] = $this->session->userdata('login_type');
            $data['createdID'] = $this->session->userdata('login_user_id');
            if ($data['reward_category'] === 'student' ){
                $data['package_id'] = json_encode($this->input->post('package_id'));
            }

            if ($data['reward_category'] === 'customer_service' ){
                $data['customer_service_id'] = json_encode($this->input->post('customer_service_id'));
            }

            if ($data['reward_category'] === 'customer_task' ){
                $data['customer_task_id'] = json_encode($this->input->post('customer_task_id'));
            }

            if ($data['reward_category'] === 'customer_followup' ){
                $data['customer_followup'] = $this->input->post('customer_followup');
            }

            $this->db->where('reward_id', $param2);
            $this->db->update('reward', $data);

            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($param1 === 'delete') {
            $this->db->where('reward_id', $param2);
            $this->db->delete('reward');

            redirect($_SERVER['HTTP_REFERER']);
        }

        $page_data['page_name'] = 'reward';
        $page_data['page_title'] = get_phrase('reward');
        $this->load->view('backend/index', $page_data);
    }

    public function branch_report()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $page_data = $_POST;
        }
        $page_data['page_name'] = 'branch_report';
        $page_data['page_title'] = get_phrase('branch_report');
        $this->load->view('backend/index', $page_data);
    }
    
    public function branchReport()
    {
        echo "<pre>";print_r($_POST);die;
    }
    public function saveOrder()
    {
        foreach($_POST['order'] as $key => $val){
            $where = [];
            if($this->session->userdata('login_type') == 'admin'){
                $where['admin_id'] = $this->session->userdata('login_user_id');
            }else if($this->session->userdata('login_type') == 'staff'){
                $where['staff_id'] = $this->session->userdata('login_user_id');
            }
            $where['name'] = $val;
            $this->db->where($where);
            $this->db->update('navigation',['order_number' => $key+1]);
        }
    }
    public function stripe() {
        $data = [
            'return_url' => base_url('index.php/admin/stripe_return'),
            'fetch_url' => base_url('index.php?admin/stripe_fetch'),
            'error_url' => base_url('admin/stripe_error'),
            'name' => 'Jenny Rosen',
            'email' => 'jenny.rosen@example.com',
        ];
        $this->load->view('stripe',$data);
    }
    function calculateOrderAmount(array $items): int {
        // Replace this constant with a calculation of the order's amount
        // Calculate the order total on the server to prevent
        // people from directly manipulating the amount on the client
        return 1400;
    }

    public function stripe_fetch(){
        $stripeSecretKey = 'sk_test_51MoPcISEhS2gjaFcoLAYmhy6ljmskBqwJ5znn1SWSMby80hnngsTyIY4HnFtFtObxsJrDXY7c2FlutAW4IO1SIEw00iYW9h1Zp';
        try {
            \Stripe\Stripe::setApiKey($stripeSecretKey);
            header('Content-Type: application/json');
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => calculateOrderAmount($jsonObj->items),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function stripe_return(){
        echo "<pre>";print_r($_POST);die;
    }

    public function stripe_error(){
        echo "<pre>";print_r($_POST);die;
    }

    /*     * *default functin, redirects to login page if no admin logged in yet** */

    public function index() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    /*     * *ADMIN DASHBOARD** */

    function dashboard() {


        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE VEHICLE CLASSWISE**** */

    function vehicle_add() {
        $this->checkAccess();

        $page_data['page_name'] = 'vehicle_add';
        $page_data['page_title'] = get_phrase('vehicle_add');
        $this->load->view('backend/index', $page_data);
    }

    function vehicle_information() {
        $this->checkAccess();

        $page_data['page_name'] = 'vehicle_information';
        $page_data['page_title'] = get_phrase('vehicle_information') ." : ";
        // print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE STUDENTS CLASSWISE**** */

    function student_add($param1 = null) {
        $this->checkAccess();
        $page_data['page_name'] = 'student_add';
        $page_data['page_title'] = get_phrase('add_student');
        $page_data['customer_data'] = null;
        $page_data['param1'] = $param1;   
        if ($param1 != '') {
            $page_data['customer_data'] = $this->db->get_where('customer',['customer_id' => $param1])->row_array();         
        }
        $this->load->view('backend/index', $page_data);
    }

    function customer_add() {
        $this->checkAccess();
        $page_data['page_name'] = 'customer_add';
        $page_data['page_title'] = get_phrase('add_customer');
        $this->load->view('backend/index', $page_data);
    }

    function customer_enquiry_add() {
        $this->checkAccess();
        $page_data['page_name'] = 'customer_enquiry_add';
        $page_data['page_title'] = get_phrase('enquiry_add');
        $this->load->view('backend/index', $page_data);
    }

    function student_bulk_add($param1 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'add_bulk_student') {

            $names = $this->input->post('name');
            $rolls = $this->input->post('roll');
            $emails = $this->input->post('email');
            $passwords = $this->input->post('password');
            $phones = $this->input->post('phone');
            $addresses = $this->input->post('address');
            $genders = $this->input->post('sex');

            $student_entries = sizeof($names);
            for ($i = 0; $i < $student_entries; $i++) {
                $data['name'] = $names[$i];
                $data['email'] = $emails[$i];
                $data['password'] = sha1($passwords[$i]);
                $data['phone'] = $phones[$i];
                $data['address'] = $addresses[$i];
                $data['sex'] = $genders[$i];

                //validate here, if the row(name, email, password) is empty or not
                if ($data['name'] == '' || $data['email'] == '' || $data['password'] == '')
                    continue;

                $this->db->insert('student', $data);
                $student_id = $this->db->insert_id();

                $data2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['student_id'] = $student_id;
                $data2['class_id'] = $this->input->post('class_id');
                if ($this->input->post('section_id') != '') {
                    $data2['section_id'] = $this->input->post('section_id');
                }
                $data2['roll'] = $rolls[$i];
                $data2['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $data2['year'] = $this->db->get_where('settings', array(
                            'type' => 'running_year'
                        ))->row()->description;

                $this->db->insert('enroll', $data2);
            }
            $this->session->set_flashdata('flash_message', get_phrase('students_added'));
            redirect(base_url() . 'index.php?admin/student_information/' . $this->input->post('class_id'), 'refresh');
        }

        $page_data['page_name'] = 'student_bulk_add';
        $page_data['page_title'] = get_phrase('add_bulk_student');
        $this->load->view('backend/index', $page_data);
    }

    function get_sections($class_id) {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/student_bulk_add_sections', $page_data);
    }

    function student_information($class_id = '') {
        $this->checkAccess();
        $page_data['page_name'] = 'student_information';
        $page_data['page_title'] = get_phrase('student_information') . " - " . get_phrase('class') . " : " .
                $this->crud_model->get_class_name($class_id);
        $page_data['class_id'] = $class_id;
        //print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    function customer_profile(int $customer_id) {
        $this->checkAccess();
        $page_data['page_name'] = 'customer_profile';
        $page_data['page_title'] = get_phrase('customer_profile');
        $page_data['customer_id'] = $customer_id;
        $page_data['customer_data'] = $this->db->get_where('customer',['customer_id' => $customer_id])->row_array();
        $this->load->view('backend/index', $page_data);
    }

    function student_profile(int $student_id) {
        $this->checkAccess();
        $page_data['page_name'] = 'student_profile';
        $page_data['page_title'] = get_phrase('student_profile');
        $page_data['student_id'] = $student_id;
        $page_data['student_data'] = $this->db->get_where('student',['student_id' => $student_id])->row_array();
        $page_data['class_data'] = $this->db->get('class')->result_array();
        $page_data['enroll_data'] = $this->db->get_where('enroll',['student_id' => $student_id])->result_array();
        $page_data['payment_data'] = $this->db->get_where('payment',['student_id' => $student_id])->result_array();
        $page_data['exam_data'] = $this->db->get_where('exam',['student_id' => $student_id])->result_array();
        // echo "<pre>"; print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    function student_list($param1 = null) {
        $this->checkAccess();
        $page_data['page_name'] = 'student_list';
        $page_data['page_title'] = get_phrase('student_list');
        
        $page_data['class_id'] = $class_id;
        $page_data['param1'] = $param1;
        //print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    function student_stream_list($stream_id = null) {
        $this->checkAccess();
        $page_data['page_name'] = 'student_list';
        $page_data['page_title'] = get_phrase('student_list');
        
        $page_data['class_id'] = $class_id;
        $page_data['stream_id'] = $stream_id;
        //print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    function customer_list() {
        $this->checkAccess();
        $page_data['page_name'] = 'customer_list';
        $page_data['page_title'] = get_phrase('customer_list');
        $page_data['class_id'] = $class_id;
        //print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    function vehicle_classsheet($param1 = null) {
        $this->checkAccess();
        $page_data['page_name'] = 'vehicle_class_sheet';
        $page_data['page_title'] = get_phrase('vehicle_class_sheet');
        
        $page_data['class_id'] = $class_id;
        $page_data['param1'] = $param1;
        //print_r($page_data); exit;
        $this->load->view('backend/index', $page_data);
    }

    function enroll($param1 = null, $param2 = null) {
        if($param1 == 'do_update'){
            $enrollData = $this->db->get_where('enroll',['enroll_id' => $param2])->row_array();
            $class_status = $enrollData['class_status'] + $this->input->post('hours') * 60 + $this->input->post('minutes');  
            $class_count_status = (int) $enrollData['class_count_status']+1;
            $data = [
                'class_status' => $class_status,
                'class_count_status' => $class_count_status,
            ];
            $settings = $this->db->get_where('settings',['type' => 'running_year'])->row_array();
            $data2 = [
                'year' => $settings['description'],
                'class_id' => $enrollData['class_id'],
                'student_id' => $enrollData['student_id'],
                'vehicle_id' => $this->input->post('vehicle_id'),
                'instructor_id' => $this->input->post('instructor_id'),
                'hours' => $this->input->post('hours'), 
                'minutes' => $this->input->post('minutes'), 
                'timestamp' => time(),
            ];

            $this->db->insert('attendance',$data2);

            $this->db->where('enroll_id',$param2);
            $this->db->update('enroll',$data);

        }
        redirect(base_url() . 'index.php?admin/student_profile/' . $enrollData['student_id'], 'refresh');
    }

    function instructor_information($instructor_id = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $page_data['page_name'] = 'instructor_information';
        $page_data['page_title'] = get_phrase('instructor_information') . " - " . get_phrase('instructor') . " : " .
                $this->crud_model->get_class_name($instructor_id);
        $page_data['instructor_id'] = $instructor_id;
        print_r($page_data);
        exit;
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet($student_id = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        $class_id = $this->db->get_where('enroll', array(
                    'student_id' => $student_id, 'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                ))->row()->class_id;
        $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
        $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
        $page_data['page_name'] = 'student_marksheet';
        $page_data['page_title'] = get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id, $exam_id) {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        $class_id = $this->db->get_where('enroll', array(
                    'student_id' => $student_id, 'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                ))->row()->class_id;
        $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] = $student_id;
        $page_data['class_id'] = $class_id;
        $page_data['exam_id'] = $exam_id;
        $this->load->view('backend/admin/student_marksheet_print_view', $page_data);
    }

    function vehicle($param1 = '', $param2 = '', $param3 = '') {
        $this->checkAccess();
        $running_year = $this->db->get_where('settings', array(
                    'type' => 'running_year'
                ))->row()->description;
        if ($param1 == 'create') {
            $data = $this->input->post();
            $data['createdBy'] = $this->session->userdata('login_type');
            $data['createdID'] = $this->session->userdata('login_user_id');

            $this->db->insert('vehicle', $data);
            $vehicle_id = $this->db->insert_id();

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/vehicle_image/' . $vehicle_id . '.jpg');

            $updateData = [
                'image' => 'uploads/vehicle_image/' . $vehicle_id . '.jpg'
            ];
            
            $this->db->where('id', $vehicle_id);
            $this->db->update('vehicle', $updateData);
            
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            // $this->email_model->account_opening_email('vehicle', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/vehicle_add/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data = $this->input->post();

            if(isset($_FILES['userfile']) && !empty($_FILES['userfile'])){
                $filename = 'uploads/vehicle_image/' . $param2 . '.jpg';
                unlink($filename);
                move_uploaded_file($_FILES['userfile']['tmp_name'], $filename);
                $data['image'] = $filename;
            }

            $this->db->where('id', $param2);
            $this->db->update('vehicle', $data);

            $this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/vehicle_information/' . $param3, 'refresh');
        }

        if ($param2 == 'delete') {
            $this->db->where('id', $param3);
            $this->db->delete('vehicle');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/vehicle_information/' . $param1, 'refresh');
        }
    }

    function uploadDocuments($student_id){
        $count = count($_FILES['documents']['name']);
        if ($count > 0){
            for($i = 0; $i < $count; $i++) {
                $file_ext = pathinfo($_FILES["documents"]["name"][$i], PATHINFO_EXTENSION);
                $path = 'uploads/student_doc/'.$student_id;
    
                if (!file_exists($path)) {
                    mkdir("uploads/student_doc/" . $student_id, 0755);
                }
                move_uploaded_file($_FILES['documents']['tmp_name'][$i], $path.'/'.$i .'.'.$file_ext);
                
            }
        }
    }

    public function addDocumnets($student_id, $type = 'student') {
        $directory = sprintf("uploads/%s_doc/%u",$type,$student_id);
        $files = [];
        if (file_exists($directory)) {
            $files = array_diff(scandir($directory), array('.', '..'));
        }else{
            mkdir($directory,0755);
        }
        $lastElement = end($files);
        $lastElementFile = explode('.',$lastElement)[0];
        $lastElementFile ++;
        $count = count($_FILES['documents']['name']);
        if ($count > 0){
            for($i = 0; $i < $count; $i++) {
                $file_ext = pathinfo($_FILES["documents"]["name"][$i], PATHINFO_EXTENSION);
                $lastElementFile = $lastElementFile+$i;
                move_uploaded_file($_FILES['documents']['tmp_name'][$i], $directory.'/'.$lastElementFile .'.'.$file_ext);
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    function studentsDocRemove() {
        $path = $this->input->post('path');
        unlink($path);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function studentsDocuments($param1, $type) {
        $directory = sprintf("uploads/%s_doc/%u",$type,$param1);

        if (file_exists($directory)) {
            $files = array_diff(scandir($directory), array('.', '..'));
        }

        $page_data['page_name'] = 'student_documents';
        $page_data['page_title'] = 'student_documents';
        $page_data['files'] = $files;
        $page_data['param2'] = $param1;
        $page_data['directory'] = $directory;
        $this->load->view('backend/index', $page_data);
    }
    function student($param1 = '', $param2 = '', $param3 = '') {
        $this->checkAccess();
        $running_year = $this->db->get_where('settings', array(
                    'type' => 'running_year'
                ))->row()->description;
        if ($param1 == 'create') {

            $system_name = $this->db->get_where('settings',['type' => 'system_name'])->row();
            $branch = $this->crud_model->getBranch();
            $data['customer_id'] = $this->input->post('customer_id');
            $data['branch_id'] = $branch->branch_id; 
            $data['name'] = $this->input->post('name');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['gardian_name'] = $this->input->post('gardian_name');
            $data['birthday'] = $this->input->post('birthday');
            $data['sex'] = $this->input->post('sex');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['password'] = sha1($this->input->post('name'));
            $data['nationality'] = $this->input->post('nationality');
            $data['adhaar_number'] = $this->input->post('adhaar_number');
            $data['date_of_admission'] = $this->input->post('date_of_admission');
            $data['address_line_1'] = $this->input->post('address_line_1');
            $data['address_line_2'] = $this->input->post('address_line_2');
            $data['address_line_3'] = $this->input->post('address_line_3');
            $data['address_line_4'] = $this->input->post('address_line_4');
            $data['pincode'] = $this->input->post('pincode');
            $data['address_line_1_temp'] = $this->input->post('address_line_1_temp');
            $data['address_line_2_temp'] = $this->input->post('address_line_2_temp');
            $data['address_line_3_temp'] = $this->input->post('address_line_3_temp');
            $data['address_line_4_temp'] = $this->input->post('address_line_4_temp');
            $data['pincode_temp'] = $this->input->post('pincode_temp');
            $data['education_qualification'] = $this->input->post('education_qualification');
            $data['operating_rto'] = $this->input->post('operating_rto');
            $data['identification_mark'] = json_encode($this->input->post('identification_mark'));
            $data['settings'] = $this->input->post('settings');
            $data['whatsapp_number'] = $this->input->post('whatsapp_number');
            $data['status'] = 'Active';
            $data['stream_id'] = $this->input->post('stream_id');
            $data['student_code'] = 'PDS-'.rand(00000000,99999999);
            
            $package_id = $this->input->post('package_id');
            if (empty($package_id)) {
                $this->session->set_flashdata('flash_message', get_phrase('please select package'));
                redirect($_SERVER['HTTP_REFERER']);
            }
            $this->db->where_in('package_id',$package_id);
            $packages = $this->db->get('package')->result();
            $tottalFee = 0;
            $classArray = $sectionA = $classTime = $class_idA = [];
            foreach($packages as $package):
                $tottalFee += $package->amount;
                if(empty($classArray) === true){
                    $class_idA =    json_decode($package->class_id,true);
                    $classTime =    json_decode($package->allocatedTiem,true);
                    $classArray =    json_decode($package->allocatedClass,true);
                } else {
                    $class_idA = array_merge($class_idA,json_decode($package->class_id,true));
                    $classTime = array_merge($classTime,json_decode($package->allocatedTiem,true));
                    $classArray = array_merge($classArray,json_decode($package->allocatedClass,true));
                }
                foreach (json_decode($package->section,true) as $key => $val) {
                    $sectionA[$key] = $val;
                }
            endforeach;
            $data['tottalFee'] = $tottalFee;
            $data['package_id'] = json_encode($package_id);

            $this->db->insert('student', $data);
            $student_id = $this->db->insert_id();
            
            foreach($class_idA as $key => $classId) {
                $data2['student_id'] = $student_id;
                $data2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['class_id'] = $classId;
                $data2['class_time_total'] = $classTime[$key] * 60;

                $data2['section_id'] = $sectionA[$classId][0];
                $data2['class_count'] = $classArray[$key];
                $data2['roll'] = substr($system_name->description,0,2) . rand(100000,2000000);

                $data2['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $data2['year'] = $running_year;
                $this->db->insert('enroll', $data2);
            }
            if(isset($data['customer_id']) && $data['customer_id'] != null) {
                copy('uploads/customer_image/' . $data['customer_id'] . '.jpg', 'uploads/student_image/' . $student_id . '.jpg');    
            }

            if (isset($_FILES['userfile'])) {
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
            }
            $this->uploadDocuments($student_id);

            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/student_add/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['stream_id'] = $this->input->post('stream_id');
            $data['name'] = $this->input->post('name');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['gardian_name'] = $this->input->post('gardian_name');
            $data['birthday'] = $this->input->post('birthday');
            $data['sex'] = $this->input->post('sex');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['password'] = sha1($this->input->post('name'));
            $data['nationality'] = $this->input->post('nationality');
            $data['adhaar_number'] = $this->input->post('adhaar_number');
            $data['date_of_admission'] = $this->input->post('date_of_admission');
            $data['address_line_1'] = $this->input->post('address_line_1');
            $data['address_line_2'] = $this->input->post('address_line_2');
            $data['address_line_3'] = $this->input->post('address_line_3');
            $data['address_line_4'] = $this->input->post('address_line_4');
            $data['pincode'] = $this->input->post('pincode');
            $data['address_line_1_temp'] = $this->input->post('address_line_1_temp');
            $data['address_line_2_temp'] = $this->input->post('address_line_2_temp');
            $data['address_line_3_temp'] = $this->input->post('address_line_3_temp');
            $data['address_line_4_temp'] = $this->input->post('address_line_4_temp');
            $data['pincode_temp'] = $this->input->post('pincode_temp');
            $data['education_qualification'] = $this->input->post('education_qualification');
            $data['operating_rto'] = $this->input->post('operating_rto');
            $data['identification_mark'] = json_encode($this->input->post('identification_mark'));
            $data['whatsapp_number'] = $this->input->post('whatsapp_number');
            $data['settings'] = $this->input->post('settings');
            $data['status'] = $this->input->post('status');;
            $data['licence_number'] = $this->input->post('licence_number');;
            $data['learners_number'] = $this->input->post('learners_number');;
            $data['driving_licence_number'] = $this->input->post('driving_licence_number');;
            $data['application_number'] = $this->input->post('application_number');;
            $package_id = $this->input->post('package_id');
            $this->db->where_in('package_id',$package_id);
            $packages = $this->db->get('package')->result();
            $tottalFee = 0;
            $classArray = $sectionA = $classTime = $class_idA = [];

            foreach($packages as $package):
                $tottalFee += $package->amount;
                if(empty($classArray) === true){
                    $class_idA =    json_decode($package->class_id,true);
                    $classTime =    json_decode($package->allocatedTiem,true);
                    $classArray =    json_decode($package->allocatedClass,true);
                } else {
                    $class_idA = array_merge($class_idA,json_decode($package->class_id,true));
                    $classTime = array_merge($classTime,json_decode($package->allocatedTiem,true));
                    $classArray = array_merge($classArray,json_decode($package->allocatedClass,true));

                }
                foreach (json_decode($package->section,true) as $key => $val) {
                    $sectionA[$key] = $val;
                }
            endforeach;

            $data['tottalFee'] = $tottalFee;
            $data['package_id'] = json_encode($package_id);

            $this->db->where('student_id', $param2);
            $this->db->update('student', $data);
            $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

            foreach($class_idA as $key => $classId) {
                $data2['student_id'] = $param2;
                $data2['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $data2['class_id'] = $classId;
                $data2['class_time_total'] = $classTime[$key] * 60;
                $data2['class_count'] = $classArray[$key];
                $data2['section_id'] = $sectionA[$classId][0];

                $data2['roll'] = substr($system_name->description,0,2) . rand(100000,2000000);

                $data2['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $data2['year'] = $running_year;

                $check = $this->db->get_where('enroll',['student_id' => $param2, 'class_id' => $classId, 'section_id' => $data2['section_id']])->row();
                if (isset($check) && !empty($check) === true) {
                    $this->db->where('enroll_id',$check->enroll_id);
                    $this->db->update('enroll', array(
                        'section_id' => $data2['section_id'], 'roll' => $data2['roll']
                    ));
                } else {
                    $this->db->insert('enroll',$data2);
                }
            }
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
            $this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($param2 == 'delete') {
            $this->db->where('student_id', $param3);
            $this->db->delete('student');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/student_information/' . $param1, 'refresh');
        }
    }

    public function access_management($param1 = '', $param2 = '')
    {
        $this->checkAccess();

        if($param1 == ''){
            $page_data['page_name'] = 'access_managment';
            $page_data['page_title'] = get_phrase('access_managment');
            $page_data['access_controller'] = $this->db->get('access_controller')->result_array();
            $this->load->view('backend/index', $page_data);
        }

        if ($param1 == 'create') {
            $data = [
                'name' => $this->input->post('name'),
                'access' => json_encode($this->input->post('access'))
            ];

            $this->db->insert('access_controller',$data);
            $this->session->set_flashdata('flash_message', get_phrase('data_added'));
            redirect($_SERVER['HTTP_REFERER']);

        }

        if ($param1 == 'edit') {
            $page_data['data'] = $this->db->get_where('access_controller',['id' => $param2])->row_array();
            $page_data['page_name'] = 'access_managment_edit';
            $page_data['page_title'] = get_phrase('access_managment_edit');
            $this->load->view('backend/index', $page_data);

        }

        if ($param1 == 'do_update') {
            $data = [
                'name' => $this->input->post('name'),
                'access' => json_encode($this->input->post('access'))
            ];
            
            $this->db->where('id',$param2);
            $this->db->update('access_controller',$data);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect($_SERVER['HTTP_REFERER']);

        }    

        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('access_controller');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect($_SERVER['HTTP_REFERER']);

        }

    }

    function customer_enquiry($param1 = '', $param2 = '', $param3 = '') {
        $this->checkAccess();
        $running_year = $this->db->get_where('settings', array(
                    'type' => 'running_year'
                ))->row()->description;
        if ($param1 == 'create') {
            $branch = $this->crud_model->getBranch();
            $data['branch_id'] = $branch->branch_id; 
            $data['stream_id'] = $this->input->post('stream_id');
            $data['name'] = $this->input->post('name');
            $data['birthday'] = $this->input->post('birthday');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['sex'] = $this->input->post('sex');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['email'] = $this->input->post('email');
            // $data['password'] = sha1($this->input->post('password'));
            $data['createdBy'] = $this->session->userdata('login_type');
            $data['createdID'] = $this->session->userdata('login_user_id');
            $data['customer_code'] = 'PDS-'.rand(00000000,99999999);
            
            $this->db->insert('customer', $data);
            $customer_id = $this->db->insert_id();

            $data1 = [
                'customer_id' => $customer_id,
                'customer_enquiry' => $this->input->post('enquiry'),
                'extimate_date' => $this->input->post('extimate_date_completion'),
                'notes' => $this->input->post('notes'),
                'createdBy' => $this->session->userdata('login_type'),
                'createdID' => $this->session->userdata('login_user_id'),
            ];
            $this->db->insert('customer_enquiry_list',$data1);            
            $customer_service_limit_id = $this->db->insert_id();
            
            redirect(base_url() . 'index.php?admin/customer_list/', 'refresh');
        }
        if ($param1 == 'profile_create') {
            $data = [
                'customer_id' => $this->input->post('customer_id'),
                'status' => $this->input->post('status'),
                'customer_enquiry' => $this->input->post('enquiry'),
                'extimate_date' => $this->input->post('extimate_date_completion'),
                'notes' => $this->input->post('notes'),
            ];

            $this->db->insert('customer_enquiry_list',$data);
            redirect($_SERVER['HTTP_REFERER']);

        }
        if ($param1 == 'direct_create') {
            $data = [
                'customer_id' => $this->input->post('customer_id'),
                'status' => $this->input->post('status'),
                'customer_enquiry' => $this->input->post('customer_enquiry'),
                'extimate_date' => $this->input->post('extimate_date'),
                'notes' => $this->input->post('notes'),
                'assign_to' => $this->input->post('assign_to'),
            ];
            $this->addNotification( __FUNCTION__ ,$param1,$this->db->insert_id());
            
            $this->db->insert('customer_enquiry_list',$data);
            redirect($_SERVER['HTTP_REFERER']);

        }
        if ($param1 == 'direct_update') {
            $data = [
                'customer_id' => $this->input->post('customer_id'),
                'status' => $this->input->post('status'),
                'customer_enquiry' => $this->input->post('customer_enquiry'),
                'extimate_date' => $this->input->post('extimate_date'),
                'notes' => $this->input->post('notes'),
                'assign_to' => $this->input->post('assign_to'),
            ];
            $this->addNotification( __FUNCTION__ ,$param1,$param2);
            
            $this->db->where('customer_enquiry_id', $param2);
            $this->db->update('customer_enquiry_list', $data);
            redirect($_SERVER['HTTP_REFERER']);

        }
        if ($param1 == 'do_update') {
            $data = [
                'status' => $this->input->post('status'),
                'customer_enquiry' => $this->input->post('enquiry'),
                'extimate_date' => $this->input->post('extimate_date'),
                'notes' => $this->input->post('notes'),
            ];

            $this->db->where('customer_enquiry_id', $param2);
            $this->db->update('customer_enquiry_list', $data);
            redirect($_SERVER['HTTP_REFERER']);

        }

        if ($param2 == 'delete') {
            $this->db->where('customer_enquiry_id', $param3);
            $this->db->delete('customer_enquiry_list');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $where = $this->crud_model->setSplitWhere('customer_enquiry_list');

        $page_data['customer_enquiry'] = $this->db->get_where('customer_enquiry_list',$where)->result_array();
        $page_data['page_name'] = 'customer_enquiry';
        $page_data['page_title'] = get_phrase('manage_customer_enquiry');
        // echo "<pre>";print_r($page_data);die('here');

        $this->load->view('backend/index', $page_data);
    }

    function customer($param1 = '', $param2 = '', $param3 = '') {
        $this->checkAccess();
        $running_year = $this->db->get_where('settings', array(
                    'type' => 'running_year'
                ))->row()->description;
        if ($param1 == 'create') {
            $branch = $this->crud_model->getBranch();
            $data['branch_id'] = $branch->branch_id; 
            $data['name'] = $this->input->post('name');
            $data['stream_id'] = $this->input->post('stream_id');
            $data['birthday'] = $this->input->post('birthday');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['sex'] = $this->input->post('sex');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['email'] = $this->input->post('email');
            // $data['password'] = sha1($this->input->post('password'));
            $data['createdBy'] = $this->session->userdata('login_type');
            $data['createdID'] = $this->session->userdata('login_user_id');
            $data['customer_code'] = 'PDS-'.rand(00000000,99999999);
            
            $this->db->insert('customer', $data);
            $customer_id = $this->db->insert_id();

            $serviceDet = $this->db->get_where('customer_service',['customer_service_id' => $this->input->post('service')])->row();
            $data1 = [
                'customer_id' => $customer_id,
                'customer_service_id' => $this->input->post('service'),
                'date_of_issue' => $this->input->post('date_of_issue'),
                'article_number' => $this->input->post('article_number'),
                'createdBy' => $this->session->userdata('login_type'),
                'createdID' => $this->session->userdata('login_user_id'),
                'tottalFee' => $serviceDet->amount + $this->input->post('amount'),
            ];
            $this->db->insert('customer_service_list',$data1);            
            $customer_service_limit_id = $this->db->insert_id();
            
            $data2 = [
                'customer_id' => $customer_id,
                'customer_service_id' => $this->input->post('service'),
                'customer_service_list_id' => $customer_service_limit_id,
                'article_number' => $this->input->post('article_number'),
                'extimate_date' => $this->input->post('extimate_date'),
                'task_id' => $this->input->post('task'),
                'notes' => $this->input->post('notes'),
                'createdBy' => $this->session->userdata('login_type'),
                'createdID' => $this->session->userdata('login_user_id'),
            ];
            $this->db->insert('customer_task_list',$data2);            
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/customer_image/' . $customer_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/customer_add/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name'] = $this->input->post('name');
            $data['stream_id'] = $this->input->post('stream_id');
            $data['birthday'] = $this->input->post('birthday');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['sex'] = $this->input->post('sex');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['email'] = $this->input->post('email');
            $param2 = $this->input->post('param2');
            $this->db->where('customer_id', $param2);
            $this->db->update('customer', $data);

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/customer_image/' . $param2 . '.jpg');
            $this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));

            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($param2 == 'delete') {
            $this->db->where('student_id', $param3);
            $this->db->delete('student');
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/student_information/' . $param1, 'refresh');
        }
    }
    // STUDENT PROMOTION
    function student_promotion($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'promote') {
            $running_year = $this->input->post('running_year');
            $from_class_id = $this->input->post('promotion_from_class_id');
            $students_of_promotion_class = $this->db->get_where('enroll', array(
                        'class_id' => $from_class_id, 'year' => $running_year
                    ))->result_array();
            foreach ($students_of_promotion_class as $row) {
                $enroll_data['enroll_code'] = substr(md5(rand(0, 1000000)), 0, 7);
                $enroll_data['student_id'] = $row['student_id'];
                $enroll_data['class_id'] = $this->input->post('promotion_status_' . $row['student_id']);
                $enroll_data['year'] = $this->input->post('promotion_year');
                $enroll_data['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $this->db->insert('enroll', $enroll_data);
            }
            $this->session->set_flashdata('flash_message', get_phrase('new_enrollment_successfull'));
            redirect(base_url() . 'index.php?admin/student_promotion', 'refresh');
        }

        $page_data['page_title'] = get_phrase('student_promotion');
        $page_data['page_name'] = 'student_promotion';
        $this->load->view('backend/index', $page_data);
    }

    function get_students_to_promote($class_id_from, $class_id_to, $running_year, $promotion_year) {
        $page_data['class_id_from'] = $class_id_from;
        $page_data['class_id_to'] = $class_id_to;
        $page_data['running_year'] = $running_year;
        $page_data['promotion_year'] = $promotion_year;
        $this->load->view('backend/admin/student_promotion_selector', $page_data);
    }

    /*     * **MANAGE PARENTS CLASSWISE**** */

    function parent($param1 = '', $param2 = '', $param3 = '')
    {
    if($this->  session->userdata('admin_login') != 1)
        redirect('login', 'refresh');
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));
        $data['phone'] = $this->input->post('phone');
        $data['address'] = $this->input->post('address');
        $data['profession'] = $this->input->post('profession');
        $this->db->insert('parent', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        $this->email_model->account_opening_email('parent', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?admin/parent/', 'refresh');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['address'] = $this->input->post('address');
        $data['profession'] = $this->input->post('profession');
        $this->db->where('parent_id', $param2);
        $this->db->update('parent', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/parent/', 'refresh');
    }
    if ($param1 == 'delete') {
        $this->db->where('parent_id', $param2);
        $this->db->delete('parent');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/parent/', 'refresh');
    }
    $page_data['page_title'] = get_phrase('all_parents');
    $page_data['page_name'] = 'parent';
    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE instructorS**** */

function instructor($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['branch_id'] = $this->input->post('branch_id');
        $data['name'] = $this->input->post('name');
        $data['card_no'] = $this->input->post('card_no');
        $data['birthday'] = $this->input->post('birthday');
        $data['sex'] = $this->input->post('sex');
        $data['address'] = $this->input->post('address');
        $data['salary'] = $this->input->post('salary');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('name'));
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('instructor', $data);
        $instructor_id = $this->db->insert_id();
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/instructor_image/' . $instructor_id . '.jpg');
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        $this->email_model->account_opening_email('instructor', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?admin/instructor/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['branch_id'] = $this->input->post('branch_id');
        $data['name'] = $this->input->post('name');
        $data['card_no'] = $this->input->post('card_no');
        $data['birthday'] = $this->input->post('birthday');
        $data['sex'] = $this->input->post('sex');
        $data['address'] = $this->input->post('address');
        $data['salary'] = $this->input->post('salary');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['tstatus'] = $this->input->post('tstatus');
        $this->db->where('instructor_id', $param2);
        $this->db->update('instructor', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/instructor_image/' . $param2 . '.jpg');
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/instructor/', 'refresh');
    } else if ($param1 == 'personal_profile') {
        $page_data['personal_profile'] = true;
        $page_data['current_instructor_id'] = $param2;
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('instructor', array(
                    'instructor_id' => $param2
                ))->result_array();
    }

    if ($param1 == 'delete') {
        $this->db->where('instructor_id', $param2);
        $this->db->delete('instructor');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/instructor/', 'refresh');
    }

    $page_data['instructors'] = $this->db->get('instructor')->result_array();
    $page_data['page_name'] = 'instructor';
    $page_data['page_title'] = get_phrase('manage_instructor');
    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE SUBJECTS**** */

function subject($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['class_id'] = $this->input->post('class_id');
        $data['instructor_id'] = $this->input->post('instructor_id');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $this->db->insert('subject', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/subject/' . $data['class_id'], 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['class_id'] = $this->input->post('class_id');
        $data['instructor_id'] = $this->input->post('instructor_id');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->where('subject_id', $param2);
        $this->db->update('subject', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/subject/' . $data['class_id'], 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('subject', array(
                    'subject_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('subject_id', $param2);
        $this->db->delete('subject');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/subject/' . $param3, 'refresh');
    }
    $page_data['class_id'] = $param1;
    $page_data['subjects'] = $this->db->get_where('subject', array('class_id' => $param1))->result_array();
    $page_data['page_name'] = 'subject';
    $page_data['page_title'] = get_phrase('manage_subject');
    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE packageS**** */

function packages($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $class_id = $this->input->post('class_id');
        $class_id = array_filter($class_id);
        if (empty($class_id)) {
            $this->session->set_flashdata('flash_message', get_phrase('please_select_class'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $allocatedClass = $this->input->post('allocatedClass');
        $allocatedClass = array_filter($allocatedClass);
        if (empty($allocatedClass)) {
            $this->session->set_flashdata('flash_message', get_phrase('select_number_of_class'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['stream_id'] = $this->input->post('stream_id');
        $data['name'] = $this->input->post('name');
        $data['amount'] = $this->input->post('amount');
        $data['class_id'] = json_encode($this->input->post('class_id'));
        $data['allocatedTiem'] = json_encode(array_filter($this->input->post('allocatedTiem')));
        $data['allocatedClass'] = json_encode(array_filter($this->input->post('allocatedClass')));
        $postedSection = $_POST['section'];
        foreach ($_POST['section'] as $key => $section) {
            if (!in_array($key, $_POST['class_id'])) {
                unset($postedSection[$key]);
            }
        } 
        $data['section'] = json_encode($postedSection);
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');
        $this->db->insert('package', $data);
        $class_id = $this->db->insert_id();
        //create a section by default
        
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/packages/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $class_id = $this->input->post('class_id');
        $class_id = array_filter($class_id);
        if (empty($class_id)) {
            $this->session->set_flashdata('flash_message', get_phrase('please_select_class'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $allocatedClass = $this->input->post('allocatedClass');
        $allocatedClass = array_filter($allocatedClass);
        if (empty($allocatedClass)) {
            $this->session->set_flashdata('flash_message', get_phrase('select_number_of_class'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['stream_id'] = $this->input->post('stream_id');
        
        $data['name'] = $this->input->post('name');
        $data['amount'] = $this->input->post('amount');
        $data['class_id'] = json_encode($this->input->post('class_id'));
        $class = $this->input->post('class_id');
        $allocatedTiem = $this->input->post('allocatedTiem');
        foreach($allocatedTiem as $key => $value):
            if(!in_array($key,$class) === true)
                unset($allocatedTiem[$key]);
        endforeach;

        $allocatedClass = $this->input->post('allocatedClass');
        foreach($allocatedClass as $key => $value):
            if(!in_array($key,$class) === true)
                unset($allocatedClass[$key]);
        endforeach;
        $data['allocatedTiem'] = json_encode($allocatedTiem);
        $data['allocatedClass'] = json_encode($allocatedClass);
        $data['section'] = json_encode(array_filter($this->input->post('section')));
        $this->db->where('package_id', $param2);
        $this->db->update('package', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/packages/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('class', array(
                    'class_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('package_id', $param2);
        $this->db->delete('package');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/packages/', 'refresh');
    }
    $where = $this->crud_model->setSplitWhere('package');

    $page_data['package'] = $this->db->order_by('package_id','desc')->get_where('package',$where)->result_array();
    $page_data['page_name'] = 'package';
    $page_data['page_title'] = get_phrase('manage_package');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE CLASSES**** */

function classes($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['name_numeric'] = $this->input->post('name_numeric');
        $data['instructor_id'] = $this->input->post('instructor_id');
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('class', $data);
        $class_id = $this->db->insert_id();
        //create a section by default
        $data2['class_id'] = $class_id;
        $data2['name'] = 'Morning Section';
        $this->db->insert('section', $data2);

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/classes/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['name_numeric'] = $this->input->post('name_numeric');
        $data['instructor_id'] = $this->input->post('instructor_id');

        $this->db->where('class_id', $param2);
        $this->db->update('class', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/classes/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('class', array(
                    'class_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('class_id', $param2);
        $this->db->delete('class');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/classes/', 'refresh');
    }
    $where = $this->crud_model->setSplitWhere('class');

    $page_data['class'] = $this->db->get_where('class',$where)->result_array();
    $page_data['page_name'] = 'class';
    $page_data['page_title'] = get_phrase('manage_class');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}


function customer_service_list($param1 = '', $param2 = '' , $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['customer_service_id'] = $param3;
        $data['customer_id'] = $param2;
        $data['tottalFee'] = $this->db->get_where('customer_service',['customer_service_id' => $param3])->row()->amount;
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');
        $this->db->insert('customer_service_list', $data);
        $class_id = $this->db->insert_id();
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'customer_create') {
        $data['customer_service_id'] = $this->input->post('customer_service_id');
        $data['customer_id'] = $this->input->post('customer_id');
        $data['tottalFee'] = $this->db->get_where('customer_service',['customer_service_id' => $data['customer_service_id']])->row()->amount;
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');
        $data['article_number'] = $this->input->post('article_number');
        $data['date_of_issue'] = $this->input->post('extimate_date');
        $this->db->insert('customer_service_list', $data);
        $class_id = $this->db->insert_id();
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'student_create') {
        $data['customer_service_id'] = $this->input->post('customer_service_id');
        $data['student_id'] = $this->input->post('student_id');
        $data['tottalFee'] = $this->db->get_where('customer_service',['customer_service_id' => $data['customer_service_id']])->row()->amount;
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');
        $data['article_number'] = $this->input->post('article_number');
        $data['date_of_issue'] = $this->input->post('extimate_date');
        $this->db->insert('customer_service_list', $data);

        if (isset($data['student_id']) && $data['student_id'] != null) {
            $this->db->where('student_id',$data['student_id']);
            $this->db->set('tottalFee', 'tottalFee + ' . $data['tottalFee'], FALSE);
            $this->db->update('student');
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'do_update') {
        $data['article_number'] = $this->input->post('article_number');
        if (isset($_POST['tottalFee'])) {
            $data['tottalFee'] = $this->input->post('tottalFee');
        }
        $data['status'] = $this->input->post('status');
        $data['date_of_issue'] = $this->input->post('extimate_date');
        $this->db->where('service_list_id', $param2);
        $this->db->update('customer_service_list', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect($_SERVER['HTTP_REFERER']);
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('customer_service', array(
                    'customer_service_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('customer_service_id', $param2);
        $this->db->delete('customer_service');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/customer_profile/', 'refresh');
    }
    $where = $this->crud_model->setSplitWhere('customer_service');
    
    $page_data['customer_service'] = $this->db->get_where('customer_service',$where)->result_array();
    $page_data['page_name'] = 'customer_service';
    $page_data['page_title'] = get_phrase('manage_customer_service');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}

function customer_service($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['stream_id'] = $this->input->post('stream_id');
        $data['name'] = $this->input->post('name');
        $data['amount'] = $this->input->post('amount');
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('customer_service', $data);
        $class_id = $this->db->insert_id();
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/customer_service/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['stream_id'] = $this->input->post('stream_id');
        $data['name'] = $this->input->post('name');
        $data['amount'] = $this->input->post('amount');

        $this->db->where('customer_service_id', $param2);
        $this->db->update('customer_service', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/customer_service/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('customer_service', array(
                    'customer_service_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('customer_service_id', $param2);
        $this->db->delete('customer_service');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/customer_service/', 'refresh');
    }
    $where = $this->crud_model->setSplitWhere('customer_service');
    
    $page_data['customer_service'] = $this->db->get_where('customer_service',$where)->result_array();
    $page_data['page_name'] = 'customer_service';
    $page_data['page_title'] = get_phrase('manage_customer_service');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}


function customer_task($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['comments'] = $this->input->post('comments');
        $data['defualt_days_required'] = $this->input->post('days');
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('customer_task', $data);
        $class_id = $this->db->insert_id();
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/customer_task/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['comments'] = trim($this->input->post('comments'));
        $data['defualt_days_required'] = $this->input->post('days');

        $this->db->where('customer_task_id', $param2);
        $this->db->update('customer_task', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/customer_task/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('customer_task', array(
                    'customer_task_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('customer_task_id', $param2);
        $this->db->delete('customer_task');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/customer_task/', 'refresh');
    }
    $where = $this->crud_model->setSplitWhere('customer_service');

    $page_data['customer_task'] = $this->db->get_where('customer_task',$where)->result_array();
    $page_data['page_name'] = 'customer_task';
    $page_data['page_title'] = get_phrase('manage_customer_task');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}
public function insertToCustomerServiceList()
{
    $services = $this->db->get_where('customer_service',['customer_service_id' => $this->input->post('customer_service_id')])->row();


    $data = [
        'customer_service_id' => $this->input->post('customer_service_id'),
        'customer_id' => $this->input->post('customer_id'),
        'article_number' => $this->input->post('article_number'),
        'tottalFee' => $services->amount,
        'status' => $this->input->post('status'),
        'createdBy' => $this->session->userdata('login_type'),
        'createdID' => $this->session->userdata('login_user_id'),
    ];

    $this->db->insert('customer_service_list',$data);
    return $this->db->insert_id();
}

public function addNotification($method,$action,$id){
    $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
    
    if ($method === 'customer_task_list') {
        $table = 'customer_task_list';
        $entry = $this->db->get_where($table,['task_list_id' => $id])->row();
        $customer = $this->db->get_where('customer',['customer_id' => $entry->customer_id])->row();
        $data['reciever'] = 'staff-'.$entry->assign_to;
        switch ($action) {
          case "direct_create":
            $data['message'] = 'New task assigned to you by '.$sender; 
            break;
          case "direct_update":
            $data['message'] = 'Update in task assigned to you by '.$sender; 
            break;
        }
        $data['message'] .=  '(Customer : '.$customer->name.' Task : '.$entry->notes.' extimate date is '.$entry->extimate_date.' <a href="index.php?admin/customer_task_list">view</a>)';
    }

    if ($method === 'customer_follow_up') {
        $table = 'follow_up';
        $entry = $this->db->get_where($table,['follow_up_id' => $id])->row();
        $customer = $this->db->get_where('customer',['customer_id' => $entry->customer_id])->row();
        $data['reciever'] = 'staff-'.$entry->assign_to;
        switch ($action) {
          case "direct_create":
            $data['message'] = 'New follow up assigned to you by '.$sender; 
            break;
          case "direct_update":
            $data['message'] = 'Update in follow up assigned to you by '.$sender; 
            break;
        }
        $data['message'] .=  '(Customer : '.$customer->name.' Task : '.$entry->remark.' follow up on date is '.$entry->follow_up_on.' <a href="index.php?admin/customer_follow_up">view</a>)';
    }

    if ($method === 'customer_enquiry') {
        $table = 'customer_enquiry_list';
        $entry = $this->db->get_where($table,['customer_enquiry_id' => $id])->row();
        $customer = $this->db->get_where('customer',['customer_id' => $entry->customer_id])->row();
        $data['reciever'] = 'staff-'.$entry->assign_to;
        switch ($action) {
          case "direct_create":
            $data['message'] = 'New enquiry assigned to you by '.$sender; 
            break;
          case "direct_update":
            $data['message'] = 'Update in enquiry assigned to you by '.$sender; 
            break;
        }
        $data['message'] .=  '(Customer : '.$customer->name.' Task : '.$entry->remark.' follow up on date is '.$entry->extimate_date.' <a href="index.php?admin/customer_follow_up">view</a>)';
    }

    $code = $this->crud_model->send_new_automatic_message($data);

}

function customer_task_list($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'direct_create') {
        $customer_service_list = $this->db->get_where('customer_service_list',['service_list_id' => $this->input->post('customer_service_id'), 'customer_id' => $this->input->post('customer_id')])->row();
        if(!empty($customer_service_list)){
            $customer_service_list_id = $customer_service_list->service_list_id; 
        } else {
            $customer_service_list_id = $this->insertToCustomerServiceList();
        }
        $data = [
            'customer_service_list_id' => $customer_service_list_id,
            'customer_service_id' => $this->input->post('customer_service_id'), 
            'customer_id' => $this->input->post('customer_id'), 
            'task_id' => $this->input->post('task_id'), 
            'extimate_date' => $this->input->post('extimate_date'), 
            'article_number' => $this->input->post('article_number'), 
            'notes' => $this->input->post('notes'), 
            'status' => $this->input->post('status'), 
            'createdBy' => $this->session->userdata('login_type'),
            'createdID' => $this->session->userdata('login_user_id'),
            'assign_to' => $this->input->post('assign_to')
        ];

        $this->db->insert('customer_task_list', $data);
        $this->addNotification( __FUNCTION__ ,$param1,$this->db->insert_id());

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);

    }

    if ($param1 == 'direct_update') {
        $customer_service_list = $this->db->get_where('customer_service_list',['service_list_id' => $this->input->post('customer_service_id'), 'customer_id' => $this->input->post('customer_id')])->row();
        if(!empty($customer_service_list)){
            $customer_service_list_id = $customer_service_list->service_list_id; 
        } else {
            $customer_service_list_id = $this->insertToCustomerServiceList();
        }
        $data = [
            'customer_service_list_id' => $customer_service_list_id,
            'customer_service_id' => $this->input->post('customer_service_id'), 
            'customer_id' => $this->input->post('customer_id'), 
            'task_id' => $this->input->post('task_id'), 
            'extimate_date' => $this->input->post('extimate_date'), 
            'article_number' => $this->input->post('article_number'), 
            'notes' => $this->input->post('notes'), 
            'status' => $this->input->post('status'), 
            'assign_to' => $this->input->post('assign_to')
        ];
        
        $task = $this->db->get_where('customer_task_list',['task_list_id' => $param2])->row();

        $this->db->where('task_list_id', $param2);
        $this->db->update('customer_task_list', $data);
        
        if (($task->status !== 'Completed' ) === true && ($data['status'] === 'Completed') === true) {
            $this->addReward(
                    [
                        "customer_task_list" => $task,
                    ]
                );    
        }
        $this->addNotification( __FUNCTION__ ,$param1,$param2);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'create') {
        $customer_service_list = $this->db->get_where('customer_service_list',['service_list_id' => $this->input->post('customer_service_list_id')])->row();
        $data = [
            'customer_service_id' => $customer_service_list->customer_service_id, 
            'customer_id' => $this->input->post('customer_id'), 
            'task_id' => $this->input->post('task_id'), 
            'extimate_date' => $this->input->post('extimate_date'), 
            'article_number' => $this->input->post('article_number'), 
            'notes' => $this->input->post('notes'), 
            'status' => $this->input->post('status'), 
            'createdBy' => $this->session->userdata('login_type'),
            'createdID' => $this->session->userdata('login_user_id'),
        ];
        $this->db->insert('customer_task_list', $data);
        $class_id = $this->db->insert_id();
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/customer_profile/'. $this->input->post('customer_id'), 'refresh');
    }
    if ($param1 == 'do_update') {
        $data = [
            'extimate_date' => $this->input->post('extimate_date'), 
            'article_number' => $this->input->post('article_number'), 
            'notes' => $this->input->post('notes'), 
            'status' => $this->input->post('status'), 
        ];

        $task = $this->db->get_where('customer_task_list',['task_list_id' => $param2])->row();
        if (($task->status !== 'Completed' ) === true && ($data['status'] === 'Completed') === true) {
            $this->addReward(
                    [
                        "customer_task_list" => $task,
                    ]
                );    
        }
        $this->db->where('task_list_id', $param2);
        $this->db->update('customer_task_list', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect($_SERVER['HTTP_REFERER']);
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('customer_task', array(
                    'customer_task_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('task_list_id', $param2);
        $this->db->delete('customer_task_list');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/customer_list', 'refresh');
    }

    $where = $this->crud_model->setSplitWhere('customer_task_list');
    $page_data['customer_task'] = $this->db->get_where('customer_task_list',$where)->result_array();
    $page_data['page_name'] = 'customer_task_list';
    $page_data['page_title'] = get_phrase('manage_customer_task');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}

function customer_follow_up($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'direct_create') {
        $data = [
            'customer_id' => $this->input->post('customer_id'), 
            'follow_up_on' => $this->input->post('follow_up_on'), 
            'remark' => $this->input->post('notes'), 
            'status' => $this->input->post('status'), 
            'assign_to' => $this->input->post('assign_to'), 
            'createdBy' => $this->session->userdata('login_type'),
            'createdID' => $this->session->userdata('login_user_id'),
        ];

        $this->db->insert('follow_up', $data);
        $this->addNotification( __FUNCTION__ ,$param1,$this->db->insert_id());
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'direct_update') {
        $data = [
            'customer_id' => $this->input->post('customer_id'), 
            'follow_up_on' => $this->input->post('follow_up_on'), 
            'remark' => $this->input->post('notes'), 
            'status' => $this->input->post('status'), 
            'createdBy' => $this->session->userdata('login_type'),
            'createdID' => $this->session->userdata('login_user_id'),
        ];
        if (isset($_POST['assign_to']) && $this->input->post('assign_to') != ''){
            $data['assign_to'] = $this->input->post('assign_to');
        }

        $followup = $this->db->get_where('follow_up',['follow_up_id' => $param2])->row();
        
        $this->db->where('follow_up_id', $param2);
        $this->db->update('follow_up', $data);
        $this->addNotification( __FUNCTION__ ,$param1,$param2);
        
        if (($followup->status !== 'Completed') === true && $data['status'] === 'Completed' ) {
            $this->addReward(
                    [
                        "followup" => $followup,
                    ]
                );
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'create') {
        $data = [
            'customer_id' => $this->input->post('customer_id'), 
            'follow_up_on' => $this->input->post('follow_up_on'), 
            'remark' => $this->input->post('remarks'), 
            'status' => $this->input->post('status'), 
            'createdBy' => $this->session->userdata('login_type'),
            'createdID' => $this->session->userdata('login_user_id'),
        ];
        $this->db->insert('follow_up', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }
    if ($param1 == 'do_update') {
        $data = [
            'follow_up_on' => $this->input->post('follow_up_on'), 
            'remark' => $this->input->post('remarks'), 
            'status' => $this->input->post('status'), 
        ];

        $followup = $this->db->get_where('follow_up',['follow_up_id' => $param2])->row();
        $this->db->where('follow_up_id', $param2);
        $this->db->update('follow_up', $data);
        
        if (($followup->status !== 'Completed') === true && $data['status'] === 'Completed' ) {
            $this->addReward(
                    [
                        "followup" => $followup,
                    ]
                );
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/customer_list', 'refresh');

    }
    if ($param1 == 'delete') {
        $this->db->where('follow_up_id', $param2);
        $this->db->delete('follow_up');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect($_SERVER['HTTP_REFERER']);
    }
    $where = $this->crud_model->setSplitWhere('follow_up');

    $page_data['follow_up'] = $this->db->get_where('follow_up',$where)->result_array();
    $page_data['page_name'] = 'follow_up';
    $page_data['page_title'] = get_phrase('manage_follow_up');
    // echo "<pre>";print_r($page_data);die('here');

    $this->load->view('backend/index', $page_data);
}

function get_subject($class_id) {
    $subject = $this->db->get_where('subject', array(
                'class_id' => $class_id
            ))->result_array();
    foreach ($subject as $row) {
        echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
    }
}

// ACADEMIC SYLLABUS
function academic_syllabus($class_id = '') {
    $this->checkAccess();
    // detect the first class
    if ($class_id == '')
        $class_id = $this->db->get('class')->first_row()->class_id;

    $page_data['page_name'] = 'academic_syllabus';
    $page_data['page_title'] = get_phrase('academic_syllabus');
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/index', $page_data);
}

function upload_academic_syllabus() {
    $data['academic_syllabus_code'] = substr(md5(rand(0, 1000000)), 0, 7);
    $data['title'] = $this->input->post('title');
    $data['description'] = $this->input->post('description');
    $data['class_id'] = $this->input->post('class_id');
    $data['subject_id'] = $this->input->post('subject_id');
    $data['uploader_type'] = $this->session->userdata('login_type');
    $data['uploader_id'] = $this->session->userdata('login_user_id');
    $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
    $data['timestamp'] = strtotime(date("Y-m-d H:i:s"));
    //uploading file using codeigniter upload library
    $files = $_FILES['file_name'];
    $this->load->library('upload');
    $config['upload_path'] = 'uploads/syllabus/';
    $config['allowed_types'] = '*';
    $_FILES['file_name']['name'] = $files['name'];
    $_FILES['file_name']['type'] = $files['type'];
    $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
    $_FILES['file_name']['size'] = $files['size'];
    $this->upload->initialize($config);
    $this->upload->do_upload('file_name');

    $data['file_name'] = $_FILES['file_name']['name'];

    $this->db->insert('academic_syllabus', $data);
    $this->session->set_flashdata('flash_message', get_phrase('syllabus_uploaded'));
    redirect(base_url() . 'index.php?admin/academic_syllabus/' . $data['class_id'], 'refresh');
}

function download_academic_syllabus($academic_syllabus_code) {
    $file_name = $this->db->get_where('academic_syllabus', array(
                'academic_syllabus_code' => $academic_syllabus_code
            ))->row()->file_name;
    $this->load->helper('download');
    $data = file_get_contents("uploads/syllabus/" . $file_name);
    $name = $file_name;

    force_download($name, $data);
}

/* * **MANAGE SECTIONS**** */

function section($class_id = '') {
    $this->checkAccess();
    // detect the first class
    $where = $this->crud_model->setSplitWhere('class');


    if ($class_id == ''){
        $class_id = $this->db->get_where('class',$where)->first_row()->class_id;
    }
    $page_data['page_name'] = 'section';
    $page_data['page_title'] = get_phrase('manage_sections');
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/index', $page_data);
}

function sections($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['nick_name'] = $this->input->post('nick_name');
        $data['class_id'] = $this->input->post('class_id');
        $classData = $this->db->get_where('class',['class_id' => $data['class_id'] ])->row_array();
        $data['instructor_id'] = $classData['instructor_id'];
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('section', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/section/' . $data['class_id'], 'refresh');
    }

    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $data['nick_name'] = $this->input->post('nick_name');
        $data['class_id'] = $this->input->post('class_id');
        $classData = $this->db->get_where('class',['class_id' => $data['class_id'] ])->row_array();
        $data['instructor_id'] = $classData['instructor_id'];
        $this->db->where('section_id', $param2);
        $this->db->update('section', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/section/' . $data['class_id'], 'refresh');
    }

    if ($param1 == 'delete') {
        $this->db->where('section_id', $param2);
        $this->db->delete('section');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/section', 'refresh');
    } 
}

function get_class_section($class_id) {
    $sections = $this->db->get_where('section', array(
                'class_id' => $class_id
            ))->result_array();
    foreach ($sections as $row) {
        echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
    }
}

function get_class_subject($class_id) {
    $subjects = $this->db->get_where('subject', array(
                'class_id' => $class_id
            ))->result_array();
    foreach ($subjects as $row) {
        echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
    }
}

function get_class_students($class_id) {
    $students = $this->db->get_where('enroll', array(
                'class_id' => $class_id, 'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
            ))->result_array();
    foreach ($students as $row) {
        $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
        echo '<option value="' . $row['student_id'] . '">' . $name . '</option>';
    }
}

function get_class_students_mass($class_id) {
    $students = $this->db->get_where('enroll', array(
                'class_id' => $class_id, 'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
            ))->result_array();
    echo '<div class="form-group">
                <label class="col-sm-3 control-label">' . get_phrase('students') . '</label>
                <div class="col-sm-9">';
    foreach ($students as $row) {
        $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
        echo '<div class="checkbox">
                    <label><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name . '</label>
                </div>';
    }
    echo '<br><button type="button" class="btn btn-default" onClick="select()">' . get_phrase('select_all') . '</button>';
    echo '<button style="margin-left: 5px;" type="button" class="btn btn-default" onClick="unselect()"> ' . get_phrase('select_none') . ' </button>';
    echo '</div></div>';
}

/* * **MANAGE EXAMS**** */

function exam($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();

    $page_data['page_title'] = get_phrase('manage_exam');
    $whereexamtype = [];
    if ($param1 == 'create') {
        $data['student_id'] = $this->input->post('student_id');
        $data['exam_type_id'] = $this->input->post('exam_type_id');
        $data['date'] = $this->input->post('examDate');
        $data['venue'] = $this->input->post('venue');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['status'] = 'Slot Allocated';
        $this->db->insert('exam', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/student_profile/'.$data['student_id'], 'refresh');
    } else if ($param1 == 'do_create') {
        $data['student_id'] = $this->input->post('student_id');
        $data['exam_type_id'] = $this->input->post('exam_type_id');
        $data['date'] = $this->input->post('examDate');
        $data['venue'] = $this->input->post('venue');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['status'] = 'Slot Allocated';
        $this->db->insert('exam', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/exam', 'refresh');
    } else if ($param1 == 'edit' && $param2 == 'do_update') {
        $data['date'] = $this->input->post('date');
        $data['venue'] = $this->input->post('venue');
        $data['status'] = $this->input->post('status');
        $this->db->where('exam_id', $param3);
        $this->db->update('exam', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect($_SERVER['HTTP_REFERER']);

    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('exam', array(
                    'exam_id' => $param2
                ))->result_array();
    } else if ($param1 == 'delete') {
        $this->db->where('exam_id', $param2);
        $this->db->delete('exam');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/exam/', 'refresh');
    } else if(isset($param1)) {
        $exam_type = $this->db->get_where('exam_type',['exam_type_id' => $param1])->row();
        if(isset($exam_type) && !empty($exam_type)){
            $whereexamtype = ['exam_type_id' => $param1];
            $page_data['page_title'] = "Manage ".$exam_type->name;
        }
    }
    $page_data['page_name'] = 'exam';
    $page_data['exams'] = $this->db->get_where('exam',$whereexamtype)->result_array();
    $this->load->view('backend/index', $page_data);
}

/* * **** SEND EXAM MARKS VIA SMS ******* */

function exam_marks_sms($param1 = '', $param2 = '') {
    $this->checkAccess();

    if ($param1 == 'send_sms') {

        $exam_id = $this->input->post('exam_id');
        $class_id = $this->input->post('class_id');
        $receiver = $this->input->post('receiver');

        // get all the students of the selected class
        $students = $this->db->get_where('enroll', array(
                    'class_id' => $class_id,
                    'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                ))->result_array();
        // get the marks of the student for selected exam
        foreach ($students as $row) {
            if ($receiver == 'student')
                $receiver_phone = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->phone;
            if ($receiver == 'parent') {
                $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
                if ($parent_id != '') {
                    $receiver_phone = $this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->phone;
                }
            }


            $this->db->where('exam_id', $exam_id);
            $this->db->where('student_id', $row['student_id']);
            $marks = $this->db->get_where('mark', array('year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description))->result_array();
            $message = '';
            foreach ($marks as $row2) {
                $subject = $this->db->get_where('subject', array('subject_id' => $row2['subject_id']))->row()->name;
                $mark_obtained = $row2['mark_obtained'];
                $message .= $row2['student_id'] . $subject . ' : ' . $mark_obtained . ' , ';
            }
            // send sms
            $this->sms_model->send_sms($message, $receiver_phone);
        }
        $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
        redirect(base_url() . 'index.php?admin/exam_marks_sms', 'refresh');
    }

    $page_data['page_name'] = 'exam_marks_sms';
    $page_data['page_title'] = get_phrase('send_marks_by_sms');
    $this->load->view('backend/index', $page_data);
}

/* * **MANAGE EXAM MARKS**** */

function marks2($exam_id = '', $class_id = '', $subject_id = '') {
    $this->checkAccess();

    if ($this->input->post('operation') == 'selection') {
        $page_data['exam_id'] = $this->input->post('exam_id');
        $page_data['class_id'] = $this->input->post('class_id');
        $page_data['subject_id'] = $this->input->post('subject_id');

        if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
            redirect(base_url() . 'index.php?admin/marks2/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
        } else {
            $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
            redirect(base_url() . 'index.php?admin/marks2/', 'refresh');
        }
    }
    if ($this->input->post('operation') == 'update') {
        $students = $this->db->get_where('enroll', array('class_id' => $class_id, 'year' => $running_year))->result_array();
        foreach ($students as $row) {
            $data['mark_obtained'] = $this->input->post('mark_obtained_' . $row['student_id']);
            $data['comment'] = $this->input->post('comment_' . $row['student_id']);

            $this->db->where('mark_id', $this->input->post('mark_id_' . $row['student_id']));
            $this->db->update('mark', array('mark_obtained' => $data['mark_obtained'], 'comment' => $data['comment']));
        }
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/marks2/' . $this->input->post('exam_id') . '/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');
    }
    $page_data['exam_id'] = $exam_id;
    $page_data['class_id'] = $class_id;
    $page_data['subject_id'] = $subject_id;

    $page_data['page_info'] = 'Exam marks';

    $page_data['page_name'] = 'marks2';
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function marks_manage() {
    $this->checkAccess();
    $page_data['page_name'] = 'marks_manage';
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function marks_manage_view($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {
    $this->checkAccess();
    $page_data['exam_id'] = $exam_id;
    $page_data['class_id'] = $class_id;
    $page_data['subject_id'] = $subject_id;
    $page_data['section_id'] = $section_id;
    $page_data['page_name'] = 'marks_manage_view';
    $page_data['page_title'] = get_phrase('manage_exam_marks');
    $this->load->view('backend/index', $page_data);
}

function marks_selector() {
    $this->checkAccess();

    $data['exam_id'] = $this->input->post('exam_id');
    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['subject_id'] = $this->input->post('subject_id');
    $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
    $query = $this->db->get_where('mark', array(
        'exam_id' => $data['exam_id'],
        'class_id' => $data['class_id'],
        'section_id' => $data['section_id'],
        'subject_id' => $data['subject_id'],
        'year' => $data['year']
    ));
    if ($query->num_rows() < 1) {
        $students = $this->db->get_where('enroll', array(
                    'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']
                ))->result_array();
        foreach ($students as $row) {
            $data['student_id'] = $row['student_id'];
            $this->db->insert('mark', $data);
        }
    }
    redirect(base_url() . 'index.php?admin/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'], 'refresh');
}

function marks_update($exam_id = '', $class_id = '', $section_id = '', $subject_id = '') {
    $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
    $marks_of_students = $this->db->get_where('mark', array(
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'year' => $running_year,
                'subject_id' => $subject_id
            ))->result_array();
    foreach ($marks_of_students as $row) {
        $obtained_marks = $this->input->post('marks_obtained_' . $row['mark_id']);
        $comment = $this->input->post('comment_' . $row['mark_id']);
        $this->db->where('mark_id', $row['mark_id']);
        $this->db->update('mark', array('mark_obtained' => $obtained_marks, 'comment' => $comment));
    }
    $this->session->set_flashdata('flash_message', get_phrase('marks_updated'));
    redirect(base_url() . 'index.php?admin/marks_manage_view/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id, 'refresh');
}

function marks_get_subject($class_id) {
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/admin/marks_get_subject', $page_data);
}

// TABULATION SHEET
function tabulation_sheet($class_id = '', $exam_id = '') {
    $this->checkAccess();

    if ($this->input->post('operation') == 'selection') {
        $page_data['exam_id'] = $this->input->post('exam_id');
        $page_data['class_id'] = $this->input->post('class_id');

        if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) {
            redirect(base_url() . 'index.php?admin/tabulation_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id'], 'refresh');
        } else {
            $this->session->set_flashdata('mark_message', 'Choose class and exam');
            redirect(base_url() . 'index.php?admin/tabulation_sheet/', 'refresh');
        }
    }
    $page_data['exam_id'] = $exam_id;
    $page_data['class_id'] = $class_id;

    $page_data['page_info'] = 'Exam marks';

    $page_data['page_name'] = 'tabulation_sheet';
    $page_data['page_title'] = get_phrase('tabulation_sheet');
    $this->load->view('backend/index', $page_data);
}

function tabulation_sheet_print_view($class_id, $exam_id) {
    $this->checkAccess();
    $page_data['class_id'] = $class_id;
    $page_data['exam_id'] = $exam_id;
    $this->load->view('backend/admin/tabulation_sheet_print_view', $page_data);
}

/* * **MANAGE GRADES**** */

function grade($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['grade_point'] = $this->input->post('grade_point');
        $data['mark_from'] = $this->input->post('mark_from');
        $data['mark_upto'] = $this->input->post('mark_upto');
        $data['comment'] = $this->input->post('comment');
        $this->db->insert('grade', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/grade/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['grade_point'] = $this->input->post('grade_point');
        $data['mark_from'] = $this->input->post('mark_from');
        $data['mark_upto'] = $this->input->post('mark_upto');
        $data['comment'] = $this->input->post('comment');

        $this->db->where('grade_id', $param2);
        $this->db->update('grade', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/grade/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('grade', array(
                    'grade_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('grade_id', $param2);
        $this->db->delete('grade');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/grade/', 'refresh');
    }
    $page_data['grades'] = $this->db->get('grade')->result_array();
    $page_data['page_name'] = 'grade';
    $page_data['page_title'] = get_phrase('manage_grade');
    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGING CLASS ROUTINE***************** */

function class_routine($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['class_id'] = $this->input->post('class_id');
        if ($this->input->post('section_id') != '') {
            $data['section_id'] = $this->input->post('section_id');
        }
        $data['subject_id'] = 1;
        $data['time_start'] = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
        $data['time_end'] = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
        $data['time_start_min'] = $this->input->post('time_start_min');
        $data['time_end_min'] = $this->input->post('time_end_min');
        $data['day'] = $this->input->post('day');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');
        $this->db->insert('class_routine', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/class_routine_add/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['class_id'] = $this->input->post('class_id');
        if ($this->input->post('section_id') != '') {
            $data['section_id'] = $this->input->post('section_id');
        }
        $data['subject_id'] = $this->input->post('subject_id');
        $data['time_start'] = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
        $data['time_end'] = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
        $data['time_start_min'] = $this->input->post('time_start_min');
        $data['time_end_min'] = $this->input->post('time_end_min');
        $data['day'] = $this->input->post('day');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->where('class_routine_id', $param2);
        $this->db->update('class_routine', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/class_routine_view/' . $data['class_id'], 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('class_routine', array(
                    'class_routine_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $class_id = $this->db->get_where('class_routine', array('class_routine_id' => $param2))->row()->class_id;
        $this->db->where('class_routine_id', $param2);
        $this->db->delete('class_routine');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/class_routine_view/' . $class_id, 'refresh');
    }
}

function class_routine_add() {
    $this->checkAccess();
    $page_data['page_name'] = 'class_routine_add';
    $page_data['page_title'] = get_phrase('add_class_routine');
    $this->load->view('backend/index', $page_data);
}

function class_routine_view($class_id) {
    $this->checkAccess();
    $page_data['page_name'] = 'class_routine_view';
    $page_data['class_id'] = $class_id;
    $page_data['page_title'] = get_phrase('class_routine');
    $this->load->view('backend/index', $page_data);
}

function class_routine_print_view($class_id, $section_id) {
    $this->checkAccess();
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $this->load->view('backend/admin/class_routine_print_view', $page_data);
}

function get_class_section_subject($class_id) {
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/admin/class_routine_section_subject_selector', $page_data);
}

function section_subject_edit($class_id, $class_routine_id) {
    $page_data['class_id'] = $class_id;
    $page_data['class_routine_id'] = $class_routine_id;
    $this->load->view('backend/admin/class_routine_section_subject_edit', $page_data);
}

//instructor attendance


function manage_attendance_instructor() {
    $this->checkAccess();

    $page_data['page_name'] = 'manage_attendance_instructor';
    $page_data['page_title'] = get_phrase('manage_instructors_attendance');
    $this->load->view('backend/index', $page_data);
}

function attendance_selector_instructor() {
    $data['year'] = $this->input->post('year');
    $data['timestamp'] = strtotime($this->input->post('timestamp'));

    $my = date('M Y');
    $cmy = strtotime($my);
//     $my1 = date('d-m-Y',$data['timestamp']);

//    print_r($my1);
//    exit;
    $query = $this->db->get_where('instructor_attendance', array(
        'year' => $data['year'],
        'timestamp' => $data['timestamp']
    ));
    if ($query->num_rows() < 1) {
        $instructors = $this->db->get_where('instructor', array(
                    'tstatus' => 'active'
                ))->result_array();

        foreach ($instructors as $row) {
            $attn_data['year'] = $data['year'];
            $attn_data['timestamp'] = $data['timestamp'];
            $attn_data['instructor_id'] = $row['instructor_id'];
            $attn_data['month_year'] = $cmy;
            $this->db->insert('instructor_attendance', $attn_data);
        }
    }
    redirect(base_url() . 'index.php?admin/manage_attendance_view_instructor/' . $data['timestamp'], 'refresh');
}

function manage_attendance_view_instructor($timestamp = '') {
    $this->checkAccess();
    $page_data['timestamp'] = $timestamp;
    $page_data['page_name'] = 'manage_attendance_view_instructor';
    $page_data['page_title'] = get_phrase('manag_instructores_attendance');
    $this->load->view('backend/index', $page_data);
}

function attendance_update_instructor($timestamp = '') {
    $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
//    $attendance_of_instructors = $this->db->get_where('instructor_attendance')->result_array();
    $attendance_of_instructors = $this->db->get_where('instructor_attendance', array(
                'year' => $running_year, 'timestamp' => $timestamp
            ))->result_array();

    foreach ($attendance_of_instructors as $row) {
        $attendance_status = $this->input->post('status_' . $row['instructor_attendance_id']);
        $this->db->where('instructor_attendance_id', $row['instructor_attendance_id']);
        $this->db->update('instructor_attendance', array('status' => $attendance_status));
    }

    $this->session->set_flashdata('flash_message', get_phrase('attendance_update_instructor'));
    redirect(base_url() . 'index.php?admin/manage_attendance_view_instructor/' . $timestamp, 'refresh');
}

function manage_attendance() {
    $this->checkAccess();

    $page_data['page_name'] = 'manage_attendance';
    $page_data['page_title'] = get_phrase('manage_attendance_of_class');
    $this->load->view('backend/index', $page_data);
}

function manage_attendance_view($class_id = '', $section_id = '', $timestamp = '') {
    $this->checkAccess();
    $class_name = $this->db->get_where('class', array(
                'class_id' => $class_id
            ))->row()->name;
    $page_data['class_id'] = $class_id;
    $page_data['timestamp'] = $timestamp;
    $page_data['page_name'] = 'manage_attendance_view';
    $section_name = $this->db->get_where('section', array(
                'section_id' => $section_id
            ))->row()->name;

    $page_data['section_id'] = $section_id;
    $page_data['page_title'] = get_phrase('manage_attendance_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
    // echo "<pre>";print_r($page_data);die;
    $this->load->view('backend/index', $page_data);
}

function get_section($class_id) {
    $page_data['class_id'] = $class_id;
    $this->load->view('backend/admin/manage_attendance_section_holder', $page_data);
}

function attendance_selector() {
    $data['class_id'] = $this->input->post('class_id');
    $data['year'] = $this->input->post('year');
    $data['timestamp'] = strtotime($this->input->post('timestamp'));
    $data['section_id'] = $this->input->post('section_id');
//    print_r($data);
//    exit;
    $query = $this->db->get_where('attendance', array(
        'class_id' => $data['class_id'],
        'section_id' => $data['section_id'],
        'year' => $data['year'],
        'timestamp' => $data['timestamp']
    ));
    if ($query->num_rows() < 1) {
        $students = $this->db->get_where('enroll', array(
                    'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'year' => $data['year']
                ))->result_array();

        foreach ($students as $row) {
            $attn_data['class_id'] = $data['class_id'];
            $attn_data['year'] = $data['year'];
            $attn_data['timestamp'] = $data['timestamp'];
            $attn_data['section_id'] = $data['section_id'];
            $attn_data['student_id'] = $row['student_id'];
            $this->db->insert('attendance', $attn_data);
        }
    }
    redirect(base_url() . 'index.php?admin/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp'], 'refresh');
}

function category_wise_expense() {
    $this->checkAccess();

    $page_data['page_name'] = 'category_wise_expense';
    $page_data['page_title'] = get_phrase('category_wise_expense');
    $this->load->view('backend/index', $page_data);
}

function category_expense() {
    $data['expense_category_id'] = $this->input->post('expense_category_id');
    $data['start_date'] = $this->input->post('start_date');
    $data['end_date'] = $this->input->post('end_date');
    $cat = $data['expense_category_id'];
    $sdate = $data['start_date'];
    $edate = $data['end_date'];

    if (!empty($cat)) {
        redirect(base_url() . 'index.php?admin/expense_view/' . $cat . '/' . $sdate . '/' . $edate, 'refresh');
    } else {
        redirect(base_url() . 'index.php?admin/expense_view/' . $sdate . '/' . $edate, 'refresh');
    }
}

function expense_view($cat = '', $sdate = '', $edate = '') {
    $this->checkAccess();
    $cat_name = $this->db->get_where('expense_category', array(
                'expense_category_id' => $cat
            ))->row()->name;
    $page_data['expense_category_id'] = $cat;
    $page_data['idate'] = $sdate;
    $page_data['idate'] = $edate;
    $page_data['page_name'] = 'expense_view';

    $page_data['page_title'] = get_phrase('expense_view_category_wise : ') . ' ' . $cat_name . ' ' . $sdate . ' ' . $edate;
    $this->load->view('backend/index', $page_data);
}

function expense_report_print_view($cat = '', $sdate1 = '', $edate2 = '') {
    $this->checkAccess();

    $page_data['cat'] = $cat;
    $page_data['sdate1'] = $sdate1;
    $page_data['edate2'] = $edate2;
    $this->load->view('backend/admin/expense_report_print_view', $page_data);
}

//Income start
function category_wise_income() {
    $this->checkAccess();

    $page_data['page_name'] = 'category_wise_income';
    $page_data['page_title'] = get_phrase('category_wise_income');
    $this->load->view('backend/index', $page_data);
}

function category_income() {
    $data['income_category_id'] = $this->input->post('income_category_id');
    $data['start_date'] = $this->input->post('start_date');
    $data['end_date'] = $this->input->post('end_date');
    $cat = $data['income_category_id'];
    $sdate = $data['start_date'];
    $edate = $data['end_date'];

    if (!empty($cat)) {
        redirect(base_url() . 'index.php?admin/income_view/' . $cat . '/' . $sdate . '/' . $edate, 'refresh');
    } else {
        redirect(base_url() . 'index.php?admin/income_view/' . $sdate . '/' . $edate, 'refresh');
    }
}

function income_view($cat = '', $sdate = '', $edate = '') {
    $this->checkAccess();

    $cat_name = $this->db->get_where('income_category', array(
                'income_category_id' => $cat
            ))->row()->name;
    $page_data['income_category_id'] = $cat;
    $page_data['idate'] = $sdate;
    $page_data['idate'] = $edate;
    $page_data['page_name'] = 'income_view';

    $page_data['page_title'] = get_phrase('income_view_category_wise : ') . ' ' . $cat_name . ' ' . $sdate . ' ' . $edate;
    $this->load->view('backend/index', $page_data);
}

function income_report_print_view($cat = '', $sdate1 = '', $edate2 = '') {
    $this->checkAccess();

    $page_data['cat'] = $cat;
    $page_data['sdate1'] = $sdate1;
    $page_data['edate2'] = $edate2;
    $this->load->view('backend/admin/income_report_print_view', $page_data);
}

//Income end


function attendance_update($class_id = '', $section_id = '', $timestamp = '') {
//    print_r($class_id .'== '. $section_id .'== '. $timestamp); exit;
    $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
    $active_sms_service = $this->db->get_where('settings', array('type' => 'active_sms_service'))->row()->description;

    $attendance_of_students = $this->db->get_where('attendance', array(
                'class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'timestamp' => $timestamp
            ))->result_array();

    print_r($attendance_of_students);
    exit;
    foreach ($attendance_of_students as $row) {
        $attendance_status = $this->input->post('status_' . $row['attendance_id']);
        $this->db->where('attendance_id', $row['attendance_id']);
        $this->db->update('attendance', array('status' => $attendance_status));

        if ($attendance_status == 2) {

            if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                $student_name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
                $receiver_phone = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
                $message = 'Your child' . ' ' . $student_name . 'is absent today.';
                $this->sms_model->send_sms($message, $receiver_phone);
            }
        }
    }
    $this->session->set_flashdata('flash_message', get_phrase('attendance_updated'));
    redirect(base_url() . 'index.php?admin/manage_attendance_view/' . $class_id . '/' . $section_id . '/' . $timestamp, 'refresh');
}

/* * **** DAILY ATTENDANCE **************** */

function manage_attendance2($date = '', $month = '', $year = '', $class_id = '', $section_id = '', $session = '') {
    $this->checkAccess();

    $active_sms_service = $this->db->get_where('settings', array('type' => 'active_sms_service'))->row()->description;
    $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;


    if ($_POST) {
        // Loop all the students of $class_id
        $this->db->where('class_id', $class_id);
        if ($section_id != '') {
            $this->db->where('section_id', $section_id);
        }
        //$session = base64_decode( urldecode( $session ) );
        $this->db->where('year', $session);
        $students = $this->db->get('enroll')->result_array();
        foreach ($students as $row) {
            $attendance_status = $this->input->post('status_' . $row['student_id']);

            $this->db->where('student_id', $row['student_id']);
            $this->db->where('date', $date);
            $this->db->where('year', $year);
            $this->db->where('class_id', $row['class_id']);
            if ($row['section_id'] != '' && $row['section_id'] != 0) {
                $this->db->where('section_id', $row['section_id']);
            }
            $this->db->where('session', $session);

            $this->db->update('attendance', array('status' => $attendance_status));

            if ($attendance_status == 2) {

                if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                    $student_name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                    $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
                    $receiver_phone = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
                    $message = 'Your child' . ' ' . $student_name . 'is absent today.';
                    $this->sms_model->send_sms($message, $receiver_phone);
                }
            }
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/manage_attendance/' . $date . '/' . $month . '/' . $year . '/' . $class_id . '/' . $section_id . '/' . $session, 'refresh');
    }
    $page_data['date'] = $date;
    $page_data['month'] = $month;
    $page_data['year'] = $year;
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['session'] = $session;

    $page_data['page_name'] = 'manage_attendance';
    $page_data['page_title'] = get_phrase('manage_daily_attendance');
    $this->load->view('backend/index', $page_data);
}

function attendance_selector2() {
    //$session = $this->input->post('session');
    //$encoded_session = urlencode( base64_encode( $session ) );
    redirect(base_url() . 'index.php?admin/manage_attendance/' . $this->input->post('date') . '/' .
            $this->input->post('month') . '/' .
            $this->input->post('year') . '/' .
            $this->input->post('class_id') . '/' .
            $this->input->post('section_id') . '/' .
            $this->input->post('session'), 'refresh');
}

///////ATTENDANCE REPORT /////
function attendance_report_student() {
    $page_data['month'] = date('m');
    $page_data['page_name'] = 'attendance_report_student';
    $page_data['page_title'] = get_phrase('attendance_report_student');
    $this->load->view('backend/index', $page_data);
}

///////ATTENDANCE REPORT /////
function attendance_report() {
    $page_data['month'] = date('m');
    $page_data['page_name'] = 'attendance_report';
    $page_data['page_title'] = get_phrase('attendance_report');
    $this->load->view('backend/index', $page_data);
}

function attendance_report_view($class_id = '', $section_id = '', $month = '', $sessional_year = '') {
    $this->checkAccess();

    $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
    $section_name = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['month'] = $month;
    $page_data['sessional_year'] = $sessional_year;
    $page_data['page_name'] = 'attendance_report_view';
    $page_data['page_title'] = get_phrase('attendance_report_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
    $this->load->view('backend/index', $page_data);
}

function attendance_report_print_view($class_id = '', $section_id = '', $month = '', $sessional_year = '') {
    $this->checkAccess();

    $page_data['class_id'] = $class_id;
    $page_data['section_id'] = $section_id;
    $page_data['month'] = $month;
    $page_data['sessional_year'] = $sessional_year;
    $this->load->view('backend/admin/attendance_report_print_view', $page_data);
}

function attendance_report_selector() {
    if ($this->input->post('class_id') == '' || $this->input->post('sessional_year') == '') {
        $this->session->set_flashdata('error_message', get_phrase('please_make_sure_class_and_sessional_year_are_selected'));
        redirect(base_url() . 'index.php?admin/attendance_report', 'refresh');
    }

    $data['class_id'] = $this->input->post('class_id');
    $data['section_id'] = $this->input->post('section_id');
    $data['month'] = $this->input->post('month');
    $data['sessional_year'] = $this->input->post('sessional_year');
    redirect(base_url() . 'index.php?admin/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'] . '/' . $data['sessional_year'], 'refresh');
}

///////ATTENDANCE REPORT instructor/////
function attendance_report_instructor() {
    $page_data['month'] = date('m');
    $page_data['page_name'] = 'attendance_report_instructor';
    $page_data['page_title'] = get_phrase('attendance_report_instructor');
    $this->load->view('backend/index', $page_data);
}

function attendance_report_instructor_selector() {
    if ($this->input->post('sessional_year') == '') {
//        $this->session->set_flashdata('error_message', get_phrase('please_make_sure_class_and_sessional_year_are_selected'));
        redirect(base_url() . 'index.php?admin/attendance_report_instructor', 'refresh');
    }

//    $data['class_id'] = $this->input->post('class_id');
//    $data['section_id'] = $this->input->post('section_id');
    $data['month'] = $this->input->post('month');
    $data['sessional_year'] = $this->input->post('sessional_year');
    redirect(base_url() . 'index.php?admin/attendance_report_view_instructor/' . $data['month'] . '/' . $data['sessional_year'], 'refresh');
}

function attendance_report_view_instructor($month = '', $sessional_year = '') {
    $this->checkAccess();

    $page_data['month'] = $month;
    $page_data['sessional_year'] = $sessional_year;
    $page_data['page_name'] = 'attendance_report_view_instructor';
    $page_data['page_title'] = get_phrase('attendance_report_of_instructor');
    $this->load->view('backend/index', $page_data);
}

function attendance_report_print_view_instructor($month = '', $sessional_year = '') {
    $this->checkAccess();


    $page_data['month'] = $month;
    $page_data['sessional_year'] = $sessional_year;
    $this->load->view('backend/admin/attendance_report_print_view_instructor', $page_data);
}

/* * ****MANAGE BILLING / INVOICES WITH STATUS**** */
    public function doRewardUpdate($functionName, $payment_id, $param) {
        $paymentDet = $this->db->get_where('payment',['payment_id' => $payment_id])->row_array();

        if ((isset($paymentDet['payment_type']) === true) && ($paymentDet['payment_type'] === 'income') === true ) {

            $invoiceDet = $this->db->get_where('invoice',['invoice_id' => $paymentDet['invoice_id']])->row_array();
            if (((isset($invoiceDet['due']) === true) && ($invoiceDet['due'] <= 0) === true )) {
                $this->addReward(
                    [
                        "invoiceDet" => $invoiceDet,
                        "post" => $_POST
                    ]
                );
            }
        }
        return;
    }

    public function addReward($data = []) {        
        // error_reporting(E_ALL);
        // ini_set('display_errors', '1');
        $rewardMaster = $this->db->get('reward')->result_array();
        foreach ($rewardMaster as $reward) {
            if (
                (($reward['reward_category'] === 'student') === true) &&
                (isset($data['invoiceDet']['student_id']) === true && (!in_array( $data['invoiceDet']['student_id'],[null,"",0])) === true )
            ) {
                $student_id = $data['invoiceDet']['student_id'];
                $studentDet = $this->db->get_where('student',['student_id' => $student_id ])->row_array();
                $rewardPackage = json_decode($reward['package_id'],true);
                $studentPackage = json_decode($studentDet['package_id'],true);

                $matches = array_intersect($rewardPackage, $studentPackage);

                if( !empty($matches) === true) {
                    $push = [
                        'point' => $reward['reward_point'],
                    ];
                }
            } else if (($reward['reward_category'] === 'customer_service') === true &&
                (isset($data['invoiceDet']['customer_id']) === true)
            ) {
                $customer_id = $data['invoiceDet']['customer_id'];
                $customer_service_list_id = $_POST['customer_service_list_id'];
                $customer_service = $this->db->get_where('customer_service_list',['service_list_id' => $customer_service_list_id])->row_array();
                $rewardService = json_decode($reward['customer_service_id'],true);
                if( in_array($customer_service['customer_service_id'],$rewardService) === true) {
                    $push = [
                        'point' => $reward['reward_point'],
                    ];
                }
            } else if (($reward['reward_category'] === 'customer_task') === true && (isset($data['customer_task_list']) === true)) {
                $rewardTask = json_decode($reward['customer_task_id'],true);
                if (in_array($data['customer_task_list']->task_id, $rewardTask) === true) {
                    $push = [
                        'point' => $reward['reward_point'],
                    ];       
                }

            } else if (($reward['reward_category'] === 'customer_followup') === true && (isset($data['followup']) === true)) {
                $date1=date_create(date('d/m/y',strtotime($data['followup']->follow_up_on)));
                $date2=date_create(date('d/m/y',strtotime(date('d/m/y',time()))));
                $diff=date_diff($date1,$date2);
                if( ($diff->format("%a") == 0) === true) {
                    $push = [
                        'point' => (int)$reward['reward_point']/(int)$reward['customer_followup'],
                    ];    
                }
            }

        }
        if( !empty($push) === true) {
            $push['reward_category'] = $reward['reward_category'];
            $push['data'] = $data;
            $this->insertRewardData($push);
        }
        return;
    }

    public function insertRewardData(array $data) {
        $data['staff_id'] = $this->session->userdata('staff_id');
        $staffDet = $this->db->get_where('staff',['staff_id' => $data['staff_id']])->row_array();
        $data['branch_id'] = $staffDet['branch_id'];
        $data['data'] = json_encode($data['data']);
        $this->db->insert('reward_data', $data);
        return;
        
    }

    function invoice($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();

    $date = date('Y-m-d');

    if ($param1 == 'customer_create') {
        $customer_service = $this->db->get_where('customer_service_list',['service_list_id' => $_POST['customer_service_list_id']])->row_array();
        $data['customer_service_list_id'] = $_POST['customer_service_list_id']; 
        $data['customer_id'] = $this->input->post('customer_id');
        $data['income_category_id'] = $this->input->post('income_category_id');
        $data['title'] = $this->input->post('title');
        $data['amount'] = $customer_service['tottalFee'];
        $data['amount_paid'] = $this->input->post('amount_paid');
        $data['due'] = $customer_service['tottalFee'] - ($customer_service['paidFee'] + $this->input->post('amount_paid'));
        $data['status'] = $this->input->post('status');
        $data['idate'] = $date;
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $customerDet = $this->db->get_where('customer',['customer_id' => $data['customer_id']])->row();
        $data['description'] = $data['title'].' '.$customerDet->name.' Of amount '.$data['amount_paid'].' On '.$this->input->post('date').' Invoice Created On '.$date;
        $data['description'] .= '. Due amount is '.$data['due'];

        $this->db->insert('invoice', $data);
        $invoice_id = $this->db->insert_id();
        
        $branch = $this->crud_model->getBranch();
        $data2['branch_id'] = $branch->branch_id; 
        $data2['stream_id'] = $customerDet->stream_id;
        $data2['invoice_id'] = $invoice_id;
        $data2['customer_id'] = $this->input->post('customer_id');
        $data2['income_category_id'] = $this->input->post('income_category_id');
        $data2['title'] = $this->input->post('title');
        $data2['description'] = $data['description'];
        $data2['payment_type'] = 'income';
        $data2['method'] = $this->input->post('method');
        $data2['amount'] = $this->input->post('amount_paid');
        $data2['idate'] = date('Y-m-d');
        $data2['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data2['customer_service_list_id'] = $_POST['customer_service_list_id']; 
        $this->db->insert('payment', $data2);
        
        $check = $this->doRewardUpdate(__FUNCTION__, $this->db->insert_id(), $param1);
        $paidFee = $customer_service['paidFee'] + $this->input->post('amount_paid');

        $this->db->where('service_list_id',$customer_service['service_list_id']);
        $this->db->update('customer_service_list',['paidFee' => $paidFee]);

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/customer_profile/'.$data['customer_id'], 'refresh');
    }

    if ($param1 == 'student_create') {
        if ($_POST['paymentFor'] === 'package') {
            $data['package_id'] = $this->input->post('package_id');
            $data2['package_id'] = $this->input->post('package_id');
            $package = $this->db->get_where('package', ['package_id' => $data['package_id']])->row_array();
            $data['amount'] = $package['amount'];

        } else if ($_POST['paymentFor'] === 'service') {
            $data['customer_service_list_id'] = $this->input->post('customer_service_id');
            $data2['customer_service_list_id'] = $this->input->post('customer_service_id'); 
            $serviceList = $this->db->get_where('customer_service_list', ['service_list_id' => $data['customer_service_list_id']])->row_array();
            $data['amount'] = $serviceList['tottalFee'];

        }
        $data['student_id'] = $this->input->post('student_id');
        $data['income_category_id'] = $this->input->post('income_category_id');
        $data['title'] = $this->input->post('title');
        $data['amount_paid'] = $this->input->post('amount_paid');
        $data['due'] = $data['amount'] - $data['amount_paid'];
        $data['status'] = $this->input->post('status');
        $data['idate'] = $date;
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $studentDet = $this->db->get_where('student',['student_id' => $data['student_id']])->row();
        $data['description'] = $data['title'].' '.$studentDet->name.' Of amount '.$data['amount_paid'].' On '.$this->input->post('date').' Invoice Created On '.$date;
        $data['description'] .= '. Due amount is '.$data['due'];

        $this->db->insert('invoice', $data);
        $invoice_id = $this->db->insert_id();

        $branch = $this->crud_model->getBranch();
        $data2['branch_id'] = $branch->branch_id; 
        $data2['stream_id'] = $studentDet->stream_id;
        $data2['invoice_id'] = $invoice_id;
        $data2['student_id'] = $this->input->post('student_id');
        $data2['income_category_id'] = $this->input->post('income_category_id');
        $data2['title'] = $this->input->post('title');
        $data2['description'] = $data['description'];
        $data2['payment_type'] = 'income';
        $data2['method'] = $this->input->post('method');
        $data2['amount'] = $this->input->post('amount_paid');
        $data2['idate'] = date('Y-m-d');
        $data2['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        // echo "<pre>";print_r($data2);die;

        $this->db->insert('payment', $data2);

        $check = $this->doRewardUpdate(__FUNCTION__, $this->db->insert_id(), $param1);

        $this->db->where('student_id',$data2['student_id']);
        $this->db->set('paidFee', 'paidFee + ' . $data2['amount'], FALSE);
        $this->db->update('student');

        if (isset($data['customer_service_list_id']) && $data['customer_service_list_id'] != null) {
            $this->db->where('service_list_id', $data['customer_service_list_id']);
            $this->db->set('paidFee', 'paidFee + ' . $data2['amount'], FALSE);
            $this->db->update('customer_service_list');
        }
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/student_profile/'.$data['student_id'], 'refresh');
    }

    if ($param1 == 'create') {
        $data['student_id'] = $this->input->post('student_id');
        $data['income_category_id'] = $this->input->post('income_category_id');
        $data['title'] = $this->input->post('title');
        $data['amount'] = $this->input->post('amount');
        $data['amount_paid'] = $this->input->post('amount_paid');
        $data['due'] = $data['amount'] - $data['amount_paid'];
        $data['status'] = $this->input->post('status');
        $data['idate'] = $date;
        $data['creation_timestamp'] = strtotime($this->input->post('date'));
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $studentDet = $this->db->get_where('student',['student_id' => $data['student_id']])->row();
        $data['description'] = $data['title'].' '.$studentDet->name.' Of amount '.$data['amount_paid'].' On '.$this->input->post('date').' Invoice Created On '.$date;
        $data['description'] .= '. Due amount is '.$data['due'];
        $this->db->insert('invoice', $data);
        $invoice_id = $this->db->insert_id();

        $branch = $this->crud_model->getBranch();
        $data2['branch_id'] = $branch->branch_id; 
        $data2['stream_id'] = $this->input->post('stream_id');
        $data2['invoice_id'] = $invoice_id;
        $data2['student_id'] = $this->input->post('student_id');
        $data2['income_category_id'] = $this->input->post('income_category_id');
        $data2['title'] = $this->input->post('title');
        $data2['description'] = $data['description'];
        $data2['payment_type'] = 'income';
        $data2['method'] = $this->input->post('method');
        $data2['amount'] = $this->input->post('amount_paid');
        $data2['idate'] = date('Y-m-d');
        $data2['timestamp'] = strtotime($this->input->post('date'));
        $data2['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->insert('payment', $data2);

        $this->doRewardUpdate(__FUNCTION__, $this->db->insert_id(), $param1);

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/student_payment', 'refresh');
    }

    if ($param1 == 'create_mass_invoice') {
        foreach ($this->input->post('student_id') as $id) {

            $data['student_id'] = $id;
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['amount'] = $this->input->post('amount');
            $data['amount_paid'] = $this->input->post('amount_paid');
            $data['due'] = $data['amount'] - $data['amount_paid'];
            $data['status'] = $this->input->post('status');
            $data['idate'] = $date;
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            $data2['invoice_id'] = $invoice_id;
            $data2['student_id'] = $id;
            $data2['title'] = $this->input->post('title');
            $data2['description'] = $this->input->post('description');
            $data2['payment_type'] = 'income';
            $data2['method'] = $this->input->post('method');
            $data2['amount'] = $this->input->post('amount_paid');
            $data2['idate'] = date('Y-m-d');
            $data2['timestamp'] = strtotime($this->input->post('date'));
            $data2['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

            $this->db->insert('payment', $data2);

            $this->doRewardUpdate(__FUNCTION__, $this->db->insert_id(), $param1);
        }
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/student_payment', 'refresh');
    }

    if ($param1 == 'do_update') {
        $data['student_id'] = $this->input->post('student_id');
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['amount'] = $this->input->post('amount');
        $data['status'] = $this->input->post('status');
        $data['creation_timestamp'] = strtotime($this->input->post('date'));

        $this->db->where('invoice_id', $param2);
        $this->db->update('invoice', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/income', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('invoice', array(
                    'invoice_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'take_payment') {
        $data['invoice_id'] = $this->input->post('invoice_id');
        $data['title'] = $this->input->post('title');
        $data['payment_type'] = 'income';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        $data['idate'] = date('Y-m-d');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $branch = $this->crud_model->getBranch();
        $data['branch_id'] = $branch->branch_id;

        $invoiceDet = $this->db->get_where('invoice',['invoice_id' => $data['invoice_id']])->row_array();

        $data['student_id'] = $invoiceDet['student_id'];
        $data['customer_id'] = $invoiceDet['customer_id'];
        $data['customer_service_list_id'] = $invoiceDet['customer_service_list_id'];
        $data['package_id'] = $invoiceDet['package_id'];
        if (isset($invoiceDet['student_id']) && $invoiceDet['student_id'] != 0) {
            $studentDet = $this->db->get_where('student',['student_id' => $invoiceDet['student_id']])->row_array();
            $desc = "Payment from student ".$studentDet['name'];
            $data['stream_id'] = $studentDet['stream_id'];
        } else {
            $customerDet = $this->db->get_where('customer',['customer_id' => $invoiceDet['customer_id']])->row_array();
            $data['stream_id'] = $customerDet['stream_id'];
            $desc = "Payment from customer ".$customerDet['name'];
            $data['customer_service_list_id'] = $invoiceDet['customer_service_list_id'];

            $this->db->set('paidFee', 'paidFee + ' . $data['amount'], FALSE);
            $this->db->where('service_list_id',$data['customer_service_list_id']);
            $this->db->update('customer_service_list');

        }
        $desc .= " Of amount ".$data['amount']." On ".$data['idate']." Due amount is ".($invoiceDet['due'] - $data['amount']); 
        $data['description'] = $desc;
        $this->db->insert('payment', $data);
        
        $this->doRewardUpdate(__FUNCTION__, $this->db->insert_id(), $param1);

        $status['status'] = $this->input->post('status');
        $this->db->where('invoice_id', $param2);
        $this->db->update('invoice', array('status' => $status['status']));

        $data2['amount_paid'] = $this->input->post('amount');
        $data2['status'] = $this->input->post('status');
        $this->db->where('invoice_id', $param2);
        $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
        $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
        $this->db->update('invoice');

        if (isset($data['customer_service_list_id']) && $data['customer_service_list_id'] != null) {
            $this->db->where('service_list_id', $invoiceDet['customer_service_list_id']);
            $this->db->set('paidFee', 'paidFee + ' . $data2['amount_paid'], FALSE);
            $this->db->update('customer_service_list');
        }

        if (isset($data['student_id']) && $data['student_id'] != null) {
            $this->db->where('student_id',$data['student_id']);
            $this->db->set('paidFee', 'paidFee + ' . $data2['amount_paid'], FALSE);
            $this->db->update('student');
        }


        $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));

        redirect($_SERVER['HTTP_REFERER']);
    }

    if ($param1 == 'delete') {
        $this->db->where('invoice_id', $param2);
        $this->db->delete('invoice');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/income', 'refresh');
    }
    $page_data['page_name'] = 'invoice';
    $page_data['page_title'] = get_phrase('manage_invoice/payment');
    $this->db->order_by('creation_timestamp', 'desc');
    $page_data['invoices'] = $this->db->get('invoice')->result_array();
    $this->load->view('backend/index', $page_data);
}

/* * ********ACCOUNTING******************* */

function income($param1 = 'invoices', $param2 = '') {
    error_reporting(E_ALL);

    $this->checkAccess();

    if ($param2 == 'filter_history')
        $page_data['student_id'] = $this->input->post('student_id');
    else
        $page_data['student_id'] = 'all';

    $page_data['page_name'] = 'income';
    $page_data['page_title'] = get_phrase('student_payments');
    $this->db->order_by('creation_timestamp', 'desc');
    $page_data['invoices'] = $this->db->get('invoice')->result_array();
    $page_data['active_tab'] = $param1;
    $this->load->view('backend/index', $page_data);
}

function student_payment($param1 = '', $param2 = '', $param3 = '') {

    $this->checkAccess();
    $page_data['page_name'] = 'student_payment';
    $page_data['page_title'] = get_phrase('create_student_payment');
    $this->load->view('backend/index', $page_data);
}
/* * ******** Branch ******************* */

function branch($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {

        $system = $this->db->get_where('settings',['type'=>'system_name'])->row();
        $data['name'] = $this->input->post('name');
        $data['phone_number'] = $this->input->post('phone_number');
        $data['address'] = $this->input->post('address');

        $this->db->insert('branch', $data);
        $insert_id = $this->db->insert_id();
        $data2['branch_code'] = $system->description.'-B-'.$insert_id;
        $this->db->where('branch_id',$insert_id);
        $this->db->update('branch',$data2);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/branch');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $data['phone_number'] = $this->input->post('phone_number');
        $data['address'] = $this->input->post('address');
        $this->db->where('branch_id', $param2);
        $this->db->update('branch', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/branch');
    }
    if ($param1 == 'delete') {
        $this->db->where('branch_id', $param2);
        $this->db->delete('branch');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/branch');
    }

    $page_data['page_name'] = 'branch';
    $page_data['page_title'] = get_phrase('branch');
    $this->load->view('backend/index', $page_data);
}

/* * ******** Main Stream ******************* */

function stream($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');


        $this->db->insert('stream', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/stream');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $this->db->where('stream_id', $param2);
        $this->db->update('stream', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/stream');
    }
    if ($param1 == 'delete') {
        $this->db->where('stream_id', $param2);
        $this->db->delete('stream');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/stream');
    }

    $page_data['page_name'] = 'stream';
    $page_data['page_title'] = get_phrase('stream');
    $this->load->view('backend/index', $page_data);
}

/* * ******** Income from students ******************* */

function income_category($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');


        $this->db->insert('income_category', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/income_category');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $this->db->where('income_category_id', $param2);
        $this->db->update('income_category', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/income_category');
    }
    if ($param1 == 'delete') {
        $this->db->where('income_category_id', $param2);
        $this->db->delete('income_category');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/income_category');
    }

    $page_data['page_name'] = 'income_category';
    $page_data['page_title'] = get_phrase('income_category');
    $this->load->view('backend/index', $page_data);
}

function payment_mode($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('payment_mode', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/payment_mode');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $this->db->where('payment_mode_id', $param2);
        $this->db->update('payment_mode', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/payment_mode');
    }
    if ($param1 == 'delete') {
        $this->db->where('payment_mode_id', $param2);
        $this->db->delete('payment_mode');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/payment_mode');
    }
 
    $page_data['page_name'] = 'payment_mode';
    $page_data['page_title'] = get_phrase('payment_mode');
    $this->load->view('backend/index', $page_data);
}

function expense($param1 = '', $param2 = '') {
    $this->checkAccess();
        $date = date('Y-m-d');
    if ($param1 == 'customer_create') {
        $branch = $this->crud_model->getBranch();
        $data['branch_id'] = $branch->branch_id; 
        $data['customer_id'] = $this->input->post('customer_id');
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['payment_type'] = 'expense';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        $data['timestamp'] = strtotime($date);
        $data['idate'] = $date;
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $studentDet = $this->db->get_where('customer',['customer_id' => $data['customer_id']])->row();
        $data['stream_id'] = $studentDet->stream_id;
        $data['description'] = $data['title'].' '.$studentDet->name.' Of amount '.$data['amount'].' On '.$this->input->post('date').' Invoice Created On '.$date;
        $this->db->insert('payment', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/customer_profile/'.$data['customer_id'], 'refresh');
    }

    if ($param1 == 'student_create') {
        $branch = $this->crud_model->getBranch();
        $data['branch_id'] = $branch->branch_id; 
        $data['student_id'] = $this->input->post('student_id');
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['payment_type'] = 'expense';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        $data['timestamp'] = strtotime($date);
        $data['idate'] = $date;
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $studentDet = $this->db->get_where('student',['student_id' => $data['student_id']])->row();
        $data['stream_id'] = $studentDet->stream_id;
        $data['description'] = $data['title'].' '.$studentDet->name.' Of amount '.$data['amount'].' On '.$this->input->post('date').' Invoice Created On '.$date;
        $this->db->insert('payment', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/student_profile/'.$data['student_id'], 'refresh');
    }

    if ($param1 == 'create') {
        $branch = $this->crud_model->getBranch();
        $data['branch_id'] = $branch->branch_id; 
        $data['stream_id'] = $this->input->post('stream_id');
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['description'] = $this->input->post('description');
        $data['payment_type'] = 'expense';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        $data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $this->db->insert('payment', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/expense', 'refresh');
    }

    if ($param1 == 'edit') {
        $data['stream_id'] = $this->input->post('stream_id');
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['description'] = $this->input->post('description');
        $data['payment_type'] = 'expense';
        $data['method'] = $this->input->post('method');
        $data['amount'] = $this->input->post('amount');
        $data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $this->db->where('payment_id', $param2);
        $this->db->update('payment', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/expense', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->db->where('payment_id', $param2);
        $this->db->delete('payment');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/expense', 'refresh');
    }

    $page_data['page_name'] = 'expense';
    $page_data['page_title'] = get_phrase('expenses');
    $this->load->view('backend/index', $page_data);
}

function unpaid() {
    $this->checkAccess();


    $page_data['page_name'] = 'unpaid';
    $page_data['page_title'] = get_phrase('unpaid_students');
    $this->load->view('backend/index', $page_data);
}

function due_view() {
    $this->checkAccess();

    $this->load->view('backend/admin/due_view', $page_data);
}

//function category_expense() {
//    if ($this->session->userdata('admin_login') != 1)
//        redirect('login', 'refresh');
//    
//     $data1 = $this->input->post('expense_category_id');
//        $data2 = $this->input->post('start_date');
//   var_dump($_POST);
//exit();
//    $page_data['page_name'] = 'category_wise_expense';
//    $page_data['page_title'] = get_phrase('category_wise_expense');
//    $this->load->view('backend/index', $page_data);
//}

function expense_category($param1 = '', $param2 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $this->db->insert('expense_category', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/expense_category');
    }
    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $this->db->where('expense_category_id', $param2);
        $this->db->update('expense_category', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/expense_category');
    }
    if ($param1 == 'delete') {
        $this->db->where('expense_category_id', $param2);
        $this->db->delete('expense_category');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/expense_category');
    }

    $page_data['page_name'] = 'expense_category';
    $page_data['page_title'] = get_phrase('expense_category');
    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGE LIBRARY / BOOKS******************* */

function book($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['price'] = $this->input->post('price');
        $data['author'] = $this->input->post('author');
        $data['class_id'] = $this->input->post('class_id');
        //$data['status']      = $this->input->post('status');
        $this->db->insert('book', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/book', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['price'] = $this->input->post('price');
        $data['author'] = $this->input->post('author');
        $data['class_id'] = $this->input->post('class_id');
        //$data['status']      = $this->input->post('status');

        $this->db->where('book_id', $param2);
        $this->db->update('book', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/book', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('book', array(
                    'book_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('book_id', $param2);
        $this->db->delete('book');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/book', 'refresh');
    }
    $page_data['books'] = $this->db->get('book')->result_array();
    $page_data['page_name'] = 'book';
    $page_data['page_title'] = get_phrase('manage_library_books');
    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

function transport($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['route_name'] = $this->input->post('route_name');
        $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
        $data['description'] = $this->input->post('description');
        $data['route_fare'] = $this->input->post('route_fare');
        $this->db->insert('transport', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/transport', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['route_name'] = $this->input->post('route_name');
        $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
        $data['description'] = $this->input->post('description');
        $data['route_fare'] = $this->input->post('route_fare');

        $this->db->where('transport_id', $param2);
        $this->db->update('transport', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/transport', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('transport', array(
                    'transport_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('transport_id', $param2);
        $this->db->delete('transport');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/transport', 'refresh');
    }
    $page_data['transports'] = $this->db->get('transport')->result_array();
    $page_data['page_name'] = 'transport';
    $page_data['page_title'] = get_phrase('manage_transport');
    $this->load->view('backend/index', $page_data);
}

/* * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

function dormitory($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['number_of_room'] = $this->input->post('number_of_room');
        $data['description'] = $this->input->post('description');
        $this->db->insert('dormitory', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/dormitory', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['name'] = $this->input->post('name');
        $data['number_of_room'] = $this->input->post('number_of_room');
        $data['description'] = $this->input->post('description');

        $this->db->where('dormitory_id', $param2);
        $this->db->update('dormitory', $data);
        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/dormitory', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('dormitory', array(
                    'dormitory_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('dormitory_id', $param2);
        $this->db->delete('dormitory');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/dormitory', 'refresh');
    }
    $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
    $page_data['page_name'] = 'dormitory';
    $page_data['page_title'] = get_phrase('manage_dormitory');
    $this->load->view('backend/index', $page_data);
}

/* * *MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD* */
public function checkDate($date = '') {
    $monthyear = date("Y-m"); 
    $dateMY = date("Y-m",strtotime($date));
    if ($monthyear === $dateMY) {
       return true;
    }
    return false;
}


public function noticeboardAuto($method = null) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $check = false;
    $noticeData = [];
    if (isset($method) && $method != ''){
        switch ($method) {
            case 'vehicle':
                $vehicle = $this->db->get_where('vehicle')->result_array();
                foreach ($vehicle as $key => $value) {
                    $REGNEXPCheck = $this->checkDate($value['REGNEXP']);
                    if ($REGNEXPCheck) {
                        $data['type'] = 'auto';
                        $data['notice_title'] = 'Registration is expiring';
                        $data['notice'] = $value['vehicleClass'].' registration is expiring on '.$value['REGNEXP'];
                        
                        $data['notice'] .= '<a href="#" onclick="showAjaxModal('.base_url('index.php?modal/popup/modal_vehicle_profile/'.$value['id']).')">click</a>'; 
                        $data['create_timestamp'] = strtotime($value['REGNEXP']);
                        array_push($noticeData, $data);
                    }

                    $MVTaxDateCheck = $this->checkDate($value['MVTaxDate']);
                    if ($MVTaxDateCheck) {
                        $data['type'] = 'auto';
                        $data['notice_title'] = 'Tax is expiring';
                        $data['notice'] = $value['vehicleClass'].' registration is expiring on '.$value['MVTaxDate'];
                        
                        $data['notice'] .= '<a href="#" onclick="showAjaxModal('.base_url('index.php?modal/popup/modal_vehicle_profile/'.$value['id']).')">click</a>'; 
                        $data['create_timestamp'] = strtotime($value['MVTaxDate']);

                        array_push($noticeData, $data);
                    }

                    $validityCheck = $this->checkDate($value['validity']);
                    if ($validityCheck) {
                        $data['type'] = 'auto';
                        $data['notice_title'] = 'Insurance is expiring';
                        $data['notice'] = $value['vehicleClass'].' registration is expiring on '.$value['validity'];
                        
                        $data['notice'] .= '<a href="#" onclick="showAjaxModal("'.base_url('index.php?modal/popup/modal_vehicle_profile/'.$value['id']).'")">click</a>'; 
                        $data['create_timestamp'] = strtotime($value['validity']);

                        array_push($noticeData, $data);
                    }


                }
                break;
            case 'exam':
                $exam = $this->db->get('exam')->result_array();
                foreach ($exam as $key => $value) {
                    $dateCheck = $this->checkDate($value['date']);
                    if ($dateCheck && $value['status'] != 'Postponed') {
                        $data['type'] = 'auto';
                        $data['notice_title'] = 'Exam';
                        $student = $this->db->get_where('student',['student_id' => $value['student_id']])->row();
                        $exam_type = $this->db->get_where('exam_type',['exam_type_id' => $value['exam_type_id']])->row();

                        $data['notice'] = $student->name.' '.$exam_type->name.' exam is planned on '.$value['date'].' venue is'.$value['venue'];
                        
                        $data['notice'] .= '<a href="'.base_url('index.php?admin/student_profile/'.$value['student_id']).'">click</a>'; 
                        $data['create_timestamp'] = strtotime($value['date']);

                        array_push($noticeData, $data);
                    }
                }
                break;
            default:
                // code...
                break;
        }


    }
    if (isset($noticeData) && !empty($noticeData)) {
        foreach ($noticeData as $key => $value) {
            $notice = $this->db->get_where('noticeboard',$value)->row();
            if (empty($notice)) {
                $this->db->insert('noticeboard', $value);
                $check_sms_send = $this->input->post('check_sms');
                if ($check_sms_send == 1) {
                    // sms sending configurations

                    $parents = $this->db->get('parent')->result_array();
                    $students = $this->db->get('student')->result_array();
                    $instructors = $this->db->get('instructor')->result_array();
                    $date = $this->input->post('create_timestamp');
                    $message = $data['notice_title'] . ' ';
                    $message .= get_phrase('on') . ' ' . $date;
                    foreach ($parents as $row) {
                        $reciever_phone = $row['phone'];
                        $this->sms_model->send_sms($message, $reciever_phone);
                    }
                    foreach ($students as $row) {
                        $reciever_phone = $row['phone'];
                        $this->sms_model->send_sms($message, $reciever_phone);
                    }
                    foreach ($instructors as $row) {
                        $reciever_phone = $row['phone'];
                        $this->sms_model->send_sms($message, $reciever_phone);
                    }
                }
            }

        }
        
    }
    die('Done');
}

function noticeboard($param1 = '', $param2 = '', $param3 = '') {
    // $this->checkAccess();

    if ($param1 == 'create') {
        $data['notice_title'] = $this->input->post('notice_title');
        $data['notice'] = $this->input->post('notice');
        $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
        $this->db->insert('noticeboard', $data);

        $check_sms_send = $this->input->post('check_sms');

        if ($check_sms_send == 1) {
            // sms sending configurations

            $parents = $this->db->get('parent')->result_array();
            $students = $this->db->get('student')->result_array();
            $instructors = $this->db->get('instructor')->result_array();
            $date = $this->input->post('create_timestamp');
            $message = $data['notice_title'] . ' ';
            $message .= get_phrase('on') . ' ' . $date;
            foreach ($parents as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($students as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($instructors as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['notice_title'] = $this->input->post('notice_title');
        $data['notice'] = $this->input->post('notice');
        $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
        $this->db->where('notice_id', $param2);
        $this->db->update('noticeboard', $data);

        $check_sms_send = $this->input->post('check_sms');

        if ($check_sms_send == 1) {
            // sms sending configurations

            $parents = $this->db->get('parent')->result_array();
            $students = $this->db->get('student')->result_array();
            $instructors = $this->db->get('instructor')->result_array();
            $date = $this->input->post('create_timestamp');
            $message = $data['notice_title'] . ' ';
            $message .= get_phrase('on') . ' ' . $date;
            foreach ($parents as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($students as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($instructors as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));

        $notice = $this->db->get_where('noticeboard',['notice_id' => $param2])->row();
        if ($notice->type == 'remark') {
        redirect(base_url() . 'index.php?admin/remarks/', 'refresh');
        } else {
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                    'notice_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $notice = $this->db->get_where('noticeboard',['notice_id' => $param2])->row();
        $this->db->where('notice_id', $param2);
        $this->db->delete('noticeboard');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        if ($notice->type == 'remark') {
        redirect(base_url() . 'index.php?admin/remarks/', 'refresh');
        } else {
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
    }
    if ($param1 == 'mark_as_archive') {
        $this->db->where('notice_id', $param2);
        $this->db->update('noticeboard', array('status' => 0));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    }

    if ($param1 == 'remove_from_archived') {
        $this->db->where('notice_id', $param2);
        $this->db->update('noticeboard', array('status' => 1));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    }
    $page_data['page_name'] = 'noticeboard';
    $page_data['page_title'] = get_phrase('manage_noticeboard');
    $this->load->view('backend/index', $page_data);
}

function remarks($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    
    if ($param1 == 'create') {
        $data['notice_title'] = $this->input->post('notice_title');
        $data['notice'] = $this->input->post('notice');
        $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
        $data['type'] = 'remark';
        $this->db->insert('noticeboard', $data);

        $check_sms_send = $this->input->post('check_sms');

        if ($check_sms_send == 1) {
            // sms sending configurations

            $parents = $this->db->get('parent')->result_array();
            $students = $this->db->get('student')->result_array();
            $instructors = $this->db->get('instructor')->result_array();
            $date = $this->input->post('create_timestamp');
            $message = $data['notice_title'] . ' ';
            $message .= get_phrase('on') . ' ' . $date;
            foreach ($parents as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($students as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($instructors as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        redirect(base_url() . 'index.php?admin/remarks', 'refresh');
    }
    if ($param1 == 'do_update') {
        $data['notice_title'] = $this->input->post('notice_title');
        $data['notice'] = $this->input->post('notice');
        $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
        $this->db->where('notice_id', $param2);
        $this->db->update('noticeboard', $data);

        $check_sms_send = $this->input->post('check_sms');

        if ($check_sms_send == 1) {
            // sms sending configurations

            $parents = $this->db->get('parent')->result_array();
            $students = $this->db->get('student')->result_array();
            $instructors = $this->db->get('instructor')->result_array();
            $date = $this->input->post('create_timestamp');
            $message = $data['notice_title'] . ' ';
            $message .= get_phrase('on') . ' ' . $date;
            foreach ($parents as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($students as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
            foreach ($instructors as $row) {
                $reciever_phone = $row['phone'];
                $this->sms_model->send_sms($message, $reciever_phone);
            }
        }

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    } else if ($param1 == 'edit') {
        $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                    'notice_id' => $param2
                ))->result_array();
    }
    if ($param1 == 'delete') {
        $this->db->where('notice_id', $param2);
        $this->db->delete('noticeboard');
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    }
    if ($param1 == 'mark_as_archive') {
        $this->db->where('notice_id', $param2);
        $this->db->update('noticeboard', array('status' => 0));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    }

    if ($param1 == 'remove_from_archived') {
        $this->db->where('notice_id', $param2);
        $this->db->update('noticeboard', array('status' => 1));
        redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
    }
    $page_data['page_name'] = 'remarks';
    $page_data['page_title'] = get_phrase('manage_noticeboard');
    $this->load->view('backend/index', $page_data);
}

function reload_noticeboard() {
    $this->load->view('backend/admin/noticeboard');
}

/* private messaging */

function message($param1 = 'message_home', $param2 = '', $param3 = '') {
    // $this->checkAccess();
    if ($param1 == 'send_new') {
        $message_thread_code = $this->crud_model->send_new_private_message();
        $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
        redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
    }

    if ($param1 == 'send_reply') {
        $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
        $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
        redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
    }

    if ($param1 == 'message_read') {
        $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
        $this->crud_model->mark_thread_messages_read($param2);
    }

    $page_data['message_inner_page_name'] = $param1;
    $page_data['page_name'] = 'message';
    $page_data['page_title'] = get_phrase('private_messaging');
    $this->load->view('backend/index', $page_data);
}

/* * ***SITE/SYSTEM SETTINGS******** */

function system_settings($param1 = '', $param2 = '', $param3 = '') {
    // $this->checkAccess();

    if ($param1 == 'do_update') {

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('currency');
        $this->db->where('type', 'currency');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('running_year');
        $this->db->where('type', 'running_year');
        $this->db->update('settings', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
    }
    if ($param1 == 'upload_logo') {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
        $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
        redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
    }
    if ($param1 == 'change_skin') {
        $data['description'] = $param2;
        $this->db->where('type', 'skin_colour');
        $this->db->update('settings', $data);
        $this->session->set_flashdata('flash_message', get_phrase('theme_selected'));
        redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
    }
    $page_data['page_name'] = 'system_settings';
    $page_data['page_title'] = get_phrase('system_settings');
    $page_data['settings'] = $this->db->get('settings')->result_array();
    $this->load->view('backend/index', $page_data);
}

function get_session_changer() {
    $this->load->view('backend/admin/change_session');
}

function change_session() {
    $data['description'] = $this->input->post('running_year');
    $this->db->where('type', 'running_year');
    $this->db->update('settings', $data);
    $this->session->set_flashdata('flash_message', get_phrase('session_changed'));
    redirect(base_url() . 'index.php?admin/dashboard/', 'refresh');
}

/* * *** UPDATE PRODUCT **** */

function update($task = '', $purchase_code = '') {

    $this->checkAccess();

    // Create update directory.
    $dir = 'update';
    if (!is_dir($dir))
        mkdir($dir, 0777, true);

    $zipped_file_name = $_FILES["file_name"]["name"];
    $path = 'update/' . $zipped_file_name;

    move_uploaded_file($_FILES["file_name"]["tmp_name"], $path);

    // Unzip uploaded update file and remove zip file.
    $zip = new ZipArchive;
    $res = $zip->open($path);
    if ($res === TRUE) {
        $zip->extractTo('update');
        $zip->close();
        unlink($path);
    }

    $unzipped_file_name = substr($zipped_file_name, 0, -4);
    $str = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
    $json = json_decode($str, true);



    // Run php modifications
    require './update/' . $unzipped_file_name . '/update_script.php';

    // Create new directories.
    if (!empty($json['directory'])) {
        foreach ($json['directory'] as $directory) {
            if (!is_dir($directory['name']))
                mkdir($directory['name'], 0777, true);
        }
    }

    // Create/Replace new files.
    if (!empty($json['files'])) {
        foreach ($json['files'] as $file)
            copy($file['root_directory'], $file['update_directory']);
    }

    $this->session->set_flashdata('flash_message', get_phrase('product_updated_successfully'));
    redirect(base_url() . 'index.php?admin/system_settings');
}

/* * ***SMS SETTINGS******** */

function sms_settings($param1 = '', $param2 = '') {
    // $this->checkAccess();
    if ($param1 == 'clickatell') {

        $data['description'] = $this->input->post('clickatell_user');
        $this->db->where('type', 'clickatell_user');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('clickatell_password');
        $this->db->where('type', 'clickatell_password');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('clickatell_api_id');
        $this->db->where('type', 'clickatell_api_id');
        $this->db->update('settings', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
    }

    if ($param1 == 'twilio') {

        $data['description'] = $this->input->post('twilio_account_sid');
        $this->db->where('type', 'twilio_account_sid');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('twilio_auth_token');
        $this->db->where('type', 'twilio_auth_token');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('twilio_sender_phone_number');
        $this->db->where('type', 'twilio_sender_phone_number');
        $this->db->update('settings', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
    }

    if ($param1 == 'active_service') {

        $data['description'] = $this->input->post('active_sms_service');
        $this->db->where('type', 'active_sms_service');
        $this->db->update('settings', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
    }

    $page_data['page_name'] = 'sms_settings';
    $page_data['page_title'] = get_phrase('sms_settings');
    $page_data['settings'] = $this->db->get('settings')->result_array();
    $this->load->view('backend/index', $page_data);
}

/* * ***LANGUAGE SETTINGS******** */

function manage_language($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();

    if ($param1 == 'edit_phrase') {
        $page_data['edit_profile'] = $param2;
    }
    if ($param1 == 'update_phrase') {
        $language = $param2;
        $total_phrase = $this->input->post('total_phrase');
        for ($i = 1; $i < $total_phrase; $i++) {
            //$data[$language]	=	$this->input->post('phrase').$i;
            $this->db->where('phrase_id', $i);
            $this->db->update('language', array($language => $this->input->post('phrase' . $i)));
        }
        redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/' . $language, 'refresh');
    }
    if ($param1 == 'do_update') {
        $language = $this->input->post('language');
        $data[$language] = $this->input->post('phrase');
        $this->db->where('phrase_id', $param2);
        $this->db->update('language', $data);
        $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
        redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
    }
    if ($param1 == 'add_phrase') {
        $data['phrase'] = $this->input->post('phrase');
        $this->db->insert('language', $data);
        $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
        redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
    }
    if ($param1 == 'add_language') {
        $language = $this->input->post('language');
        $this->load->dbforge();
        $fields = array(
            $language => array(
                'type' => 'LONGTEXT'
            )
        );
        $this->dbforge->add_column('language', $fields);

        $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
        redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
    }
    if ($param1 == 'delete_language') {
        $language = $param2;
        $this->load->dbforge();
        $this->dbforge->drop_column('language', $language);
        $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));

        redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
    }
    $page_data['page_name'] = 'manage_language';
    $page_data['page_title'] = get_phrase('manage_language');
    //$page_data['language_phrases'] = $this->db->get('language')->result_array();
    $this->load->view('backend/index', $page_data);
}

/* * ***BACKUP / RESTORE / DELETE DATA PAGE********* */

function backup_restore($operation = '', $type = '') {
    $this->checkAccess();

    if ($operation == 'create') {
        $this->crud_model->create_backup($type);
    }
    if ($operation == 'restore') {
        $this->crud_model->restore_backup();
        $this->session->set_flashdata('backup_message', 'Backup Restored');
        redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
    }
    if ($operation == 'delete') {
        $this->crud_model->truncate($type);
        $this->session->set_flashdata('backup_message', 'Data removed');
        redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
    }

    $page_data['page_info'] = 'Create backup / restore from backup';
    $page_data['page_name'] = 'backup_restore';
    $page_data['page_title'] = get_phrase('manage_backup_restore');
    $this->load->view('backend/index', $page_data);
}

/* * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

function manage_profile($param1 = '', $param2 = '', $param3 = '') {
    error_reporting(E_ALL);
    if ($param1 == 'update_profile_info') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');

        $this->db->where('admin_id', $this->session->userdata('admin_id'));
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $this->session->userdata('admin_id') . '.jpg');
        $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
        redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
    }
    if ($param1 == 'change_password') {
        $data['password'] = sha1($this->input->post('password'));
        $data['new_password'] = sha1($this->input->post('new_password'));
        $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

        $current_password = $this->db->get_where('admin', array(
                    'admin_id' => $this->session->userdata('admin_id')
                ))->row()->password;
        if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
            $this->db->where('admin_id', $this->session->userdata('admin_id'));
            $this->db->update('admin', array(
                'password' => $data['new_password']
            ));
            $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
        }
        redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
    }
    
    $page_data['page_name'] = 'manage_profile';
    $page_data['page_title'] = get_phrase('manage_profile');
    if(empty($page_data['edit_data'])){
        $page_data['edit_data'] = $this->db->get_where('staff', array(
                'staff_id' => $this->session->userdata('staff_id')
            ))->result_array();
    }

    if(empty($page_data['edit_data'])){
        $page_data['edit_data'] = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->result_array();
    }

    $this->load->view('backend/index', $page_data);
}

/* * ****TEST PAGE** */

function manage_test() {
    $this->load->view('backend/admin/manage_test');
}

// VIEW QUESTION PAPERS
function question_paper($param1 = "", $param2 = "") {
    if ($this->session->userdata('admin_login') != 1) {
        $this->session->set_userdata('last_page', current_url());
        redirect(base_url(), 'refresh');
    }

    $data['page_name'] = 'question_paper';
    $data['page_title'] = get_phrase('question_paper');
    $this->load->view('backend/index', $data);
}

// MANAGE LIBRARIANS
function librarian($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();

    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));

        $this->db->insert('librarian', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        $this->email_model->account_opening_email('librarian', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?admin/librarian/', 'refresh');
    }

    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');

        $this->db->where('librarian_id', $param2);
        $this->db->update('librarian', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/librarian/', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->db->where('librarian_id', $param2);
        $this->db->delete('librarian');

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/librarian/', 'refresh');
    }

    $page_data['page_title'] = get_phrase('all_librarians');
    $page_data['page_name'] = 'librarian';
    $this->load->view('backend/index', $page_data);
}

public function checkAccess() {
    if($this->uri->segment(2) != '' && !is_numeric($this->uri->segment(2)))
        $function[] = $this->uri->segment(2);
    
    if($this->uri->segment(3) != '' && !is_numeric($this->uri->segment(3))){
        if(in_array($this->uri->segment(3),["customer_create", "student_create", "profile_create", "do_create", "direct_create"])){
            $function[] = "create";
        }elseif(in_array($this->uri->segment(3),["Active", "In-Active", "Holded", "Success"])){
            $function[] = "view";
        }elseif(in_array($this->uri->segment(3),["direct_update"])){
            $function[] = "edit";
        }else{
            $function[] = $this->uri->segment(3);
        }
    }
    
    if($this->uri->segment(4) != '' && !is_numeric($this->uri->segment(4)))
        $function[] = $this->uri->segment(4);
    // var_dump($function);die;
    if(!$this->crud_model->accessCheck($function)){
        $this->session->set_flashdata('flash_message', get_phrase('No Access Please Contact Admin'));
        redirect($_SERVER['HTTP_REFERER']);
    }
    /*if ($this->session->userdata('admin_login') != 1) {
        if($this->session->userdata('staff_login') != 1){
            redirect('login', 'refresh');
        }else{
            if(in_array($endPoint,$this->session->userdata('access'))) {

            }else{
                $uriMapping = $this->db->get_where('uriMapping',['uri' => $endPoint])->row()->mapping;
                if(in_array($uriMapping,$this->session->userdata('access'))) {
                }else{
                    redirect('login', 'refresh');
                }
            }
        }
    }else{
        $endPoint = $this->uri->segment(2);
        if(in_array($endPoint,$this->session->userdata('access'))) {

        }else{
            $uriMapping = $this->db->get_where('uriMapping',['uri' => $endPoint])->row()->mapping;
            if(in_array($uriMapping,$this->session->userdata('access'))) {
            }else{
                echo $endPoint;die();
                redirect('login', 'refresh');
            }
        }
    }*/

}

// MANAGE ACCOUNTANTS
public function reward_list(){
    $page_data['page_title'] = get_phrase('reward_list');
    $page_data['page_name'] = 'reward_list';
    $this->load->view('backend/index', $page_data);
}

function staff($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();
    if ($param1 == 'create') {

        $data['branch_id'] = $this->input->post('branch_id');
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));
        $data['access'] = json_encode($this->input->post('access'));
        $data['createdBy'] = $this->session->userdata('login_type');
        $data['createdID'] = $this->session->userdata('login_user_id');

        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();
        $filePath = 'uploads/staff_image/' . $staff_id . '.jpg';
        move_uploaded_file($_FILES['userfile']['tmp_name'], $filePath);

        $updateData = [
            'image' => $filePath
        ];
        
        $this->db->where('staff_id', $staff_id);
        $this->db->update('staff', $updateData);
        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        $this->email_model->account_opening_email('staff', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?admin/staff', 'refresh');
    }

    if ($param1 == 'edit') {
        $data['branch_id'] = $this->input->post('branch_id');
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['status'] = $this->input->post('status');
        $data['access'] = json_encode($this->input->post('access'));
        if(isset($_FILES['userfile']) && !empty($_FILES['userfile'])){
        $filePath = 'uploads/staff_image/' . $param2 . '.jpg';
            unlink($filePath);
            move_uploaded_file($_FILES['userfile']['tmp_name'], $filePath);
            $data['image'] = $filePath;
        }
        $this->db->where('staff_id', $param2);
        $this->db->update('staff', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/staff', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->db->where('staff_id', $param2);
        $this->db->delete('staff');

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/staff', 'refresh');
    }

    $page_data['page_title'] = get_phrase('all_staff');
    $page_data['page_name'] = 'staff';
    $this->load->view('backend/index', $page_data);
}

// MANAGE ACCOUNTANTS
function accountant($param1 = '', $param2 = '', $param3 = '') {
    $this->checkAccess();

    if ($param1 == 'create') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));

        $this->db->insert('accountant', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
        $this->email_model->account_opening_email('accountant', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
        redirect(base_url() . 'index.php?admin/accountant', 'refresh');
    }

    if ($param1 == 'edit') {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');

        $this->db->where('accountant_id', $param2);
        $this->db->update('accountant', $data);

        $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
        redirect(base_url() . 'index.php?admin/accountant', 'refresh');
    }

    if ($param1 == 'delete') {
        $this->db->where('accountant_id', $param2);
        $this->db->delete('accountant');

        $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        redirect(base_url() . 'index.php?admin/accountant', 'refresh');
    }

    $page_data['page_title'] = get_phrase('all_accountants');
    $page_data['page_name'] = 'accountant';
    $this->load->view('backend/index', $page_data);
}

//total income expense

function total() {
    $this->checkAccess();

    $page_data['page_name'] = 'total';
    $page_data['page_title'] = get_phrase('total_income_&_expense');
    $this->load->view('backend/index', $page_data);
}

function income_expense() {

    $data['start_date'] = $this->input->post('start_date');
    $data['end_date'] = $this->input->post('end_date');

    $sdate = $data['start_date'];
    $edate = $data['end_date'];

    redirect(base_url() . 'index.php?admin/income_expense_view/' . $sdate . '/' . $edate, 'refresh');
}

function income_expense_view($sdate = '', $edate = '') {
    $this->checkAccess();

    $page_data['idate'] = $sdate;
    $page_data['idate'] = $edate;
    $page_data['page_name'] = 'income_expense_view';

    $page_data['page_title'] = get_phrase('total_income_&_expense : ') . ' ' . $sdate . ' ' . $edate;
    $this->load->view('backend/index', $page_data);
}

function income_expense_report_print_view($sdate = '', $edate = '') {
    $this->checkAccess();


    $page_data['sdate1'] = $sdate1;
    $page_data['edate2'] = $edate2;
    $this->load->view('backend/admin/income_expense_report_print_view', $page_data);
}

}
