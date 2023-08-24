<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function firstStream() {
        $firstStream = $this->db->get('stream')->row_array();

        return $firstStream;
    }
    public function getOrder($name)
    {
        $where = [];
        if($this->session->userdata('login_type') == 'admin'){
            $where['admin_id'] = $this->session->userdata('login_user_id');
        }else if($this->session->userdata('login_type') == 'staff'){
            $where['staff_id'] = $this->session->userdata('login_user_id');
        }
        $where['name'] = $name;
        $this->db->where($where);
        $navigation = $this->db->get('navigation')->row();
        if(isset($navigation) && !empty($navigation)) {
            return $navigation->order_number;
        }else{
            return $this->defualtOrder($name);
        }
    }

    public function getBranch($value='')
    {
        if($this->session->userdata('login_type') == 'admin'){
            $branch = $this->db->order_by('branch_id','inc')->get('branch')->row();
        }else{
            $staff = $this->db->get_where('staff',['staff_id' =>$this->session->userdata('login_user_id')])->row();
            $branch = $this->db->get_where('branch',['branch_id' => $staff->branch_id])->row();
        }
            return $branch; 

    }

    public function messageCount($value='')
    {
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        $this->db->where('sender', $current_user);
        $this->db->or_where('reciever', $current_user);
        $message_threads = $this->db->get('message_thread')->result_array();
        $totalCount = 0;
        foreach ($message_threads as $row):
            $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
            $totalCount += $unread_message_number;
        endforeach;

        return $totalCount;
    }

    public function defualtOrder($name){
        $navigation = $this->db->get_where('navigation',['admin_id' =>1,'name' => $name])->row();
        return $navigation->order_number;
    }
    public function addNavigation(){
        $navigations = $this->db->get_where('navigation',['admin_id' =>1])->result_array();
        $newNavigation= [];
        foreach($navigations as $navigation){
            unset($navigation['id']);
            unset($navigation['admin_id']);
            $navigation['staff_id'] = $this->session->userdata('login_user_id');
            array_push( $newNavigation,$navigation);

        }
        $this->db->insert_batch('navigation',$newNavigation);
    }
    public function setSplitWhere($table)
    {
        $condtionTable = ['customer','staff','follow_up','customer_enquiry_list','customer_task_list'];
        if(in_array($table,$condtionTable) && $this->session->userdata('login_type') != 'admin') {
            if($table == 'customer') {
                $customer_id = [];
                $customer_enquiry_list = $this->db->get_where('customer_enquiry_list',['assign_to' => $this->session->userdata('login_user_id')])->result_array();
                $customer_idArray[] = array_column($customer_enquiry_list,'customer_id');

                $customer_task_list = $this->db->get_where('customer_task_list',['assign_to' => $this->session->userdata('login_user_id')])->result_array();
                $customer_idArray[] = array_column($customer_task_list,'customer_id');

                $follow_up = $this->db->get_where('follow_up',['assign_to' => $this->session->userdata('login_user_id')])->result_array();

                $customer_idArray[] = array_column($follow_up,'customer_id');
                
                foreach ($customer_idArray as $key => $value) {
                    if(!empty($value)){
                        foreach($value as $val){
                            array_push($customer_id, $val);
                        }
                    }
                }
            }
            // $where['createdBy'] = $this->session->userdata('login_type');
            // $where['createdID'] = $this->session->userdata('login_user_id');

            $this->db->where('createdBy', $this->session->userdata('login_type'));
            $this->db->where('createdID', $this->session->userdata('login_user_id'));

            $condtionTableOrWhere = ['follow_up','customer_enquiry_list','customer_task_list'];

            if(in_array($table,$condtionTableOrWhere)) {
                $this->db->or_where('assign_to', $this->session->userdata('login_user_id'));
            }

            if( !empty($customer_id)){
                $this->db->or_where_in('customer_id',$customer_id);
            }
        }
        return [];
    }
    public function accessCheck($functionName)
    {
        if ($this->session->userdata('admin_login') == 1) {
            return true;
        }
        if ($this->session->userdata('staff_login') == 1) {
        // echo $functionName;die;
            $accessArray = $this->session->userdata('access');
            $accessControl = $this->db->get_where('access_controller',['name' => $accessArray[0]])->row_array();
            $controllers = json_decode($accessControl['access'],true);
            // echo $functionName;
            // echo "<pre>";print_r($controllers);die;
            
            $fn = $functionName;
            if(is_array($functionName)){
                $fn = $functionName[0];
                $action = $functionName[1];
                $accessMapping = $this->db->get_where('uriMapping',['uri' => $fn])->row_array();
                if(!array_key_exists($accessMapping['mapping'],$controllers)){
                    return false;
                }else{
                    $allowed = $controllers[$accessMapping['mapping']];
                    
                    if(in_array('add', $allowed)){
                        array_push($allowed,'create');
                    }
                    if(in_array('edit', $allowed)){
                        array_push($allowed,'do_update');
                    }
                    if($action == ''){
                        if(array_key_exists($accessMapping['mapping'],$controllers)){
                            return true;
                        }

                    }
                    if($action != '' && !in_array($action, $allowed)) {
                        return false;
                    }
                    return true;                    
                }

            }else{
                
                if(array_key_exists($fn,$controllers) || in_array($fn,['message','settings','account','noticeboard'])){
                    return true;
                }else{
                    $accessMapping = $this->db->get_where('uriMapping',['uri' => $functionName])->row_array();
                    // echo "<pre>";print_r($accessMapping);die;
                    if (isset($accessMapping) && !empty($accessMapping)){
                    // var_dump($accessMapping['mapping']);
                    // echo "<pre>";print_r($controllers);die;
                    // die;
                        if(array_key_exists($accessMapping['mapping'],$controllers)){
                            return true;
                        }
                    }else{
                        return false;

                        // die($functionName);
                    }
                    return false;
                }
            }        
        }
    }
    public function accessJson()
    {
        return '{
            "branch" : ["add", "edit", "delete", "view"],
            "main_stream": ["add", "edit", "delete", "view"],
            "access_management": ["add", "edit", "delete", "view"],
            "staff": ["add", "edit", "delete", "view"],
            "vehicle": ["add", "edit", "delete", "view"],
            "instructor": ["add", "edit", "delete", "view"],
            "class": ["add", "edit", "delete", "view"],
            "package": ["add", "edit", "delete", "view"],
            "student": ["add", "edit", "delete", "view"],
            "customer_service": ["add", "edit", "delete", "view"],
            "customer_task": ["add", "edit", "delete", "view"],
            "customer": ["add", "edit", "delete", "view"],
            "daily_attandance": ["add", "edit", "delete", "view"],
            "test": ["add", "edit", "delete", "view"],
            "student_payment": ["add", "edit", "delete", "view"],
            "income_category": ["add", "edit", "delete", "view"],
            "payment_mode": ["add", "edit", "delete", "view"],
            "expense": ["add", "edit", "delete", "view"],
            "expense_category": ["add", "edit", "delete", "view"],
            "remark": ["add", "edit", "delete", "view"],
            "notice": ["add", "edit", "delete", "view"],
            "message": ["add", "edit", "delete", "view"],
            "dashboard": ["student_report", "customer_report", "payment_report"]
        }';
    }
    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function rand_color() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    public function getAllStream()
    {
        return $this->db->get('stream')->result_array();
        // code...
    }

    public function get_stream($streamId)
    {
        $stream = $this->db->get_where('stream',['stream_id' => $streamId])->row();
        if(isset($stream)) {
            return $stream->name;
        }else{
            return 'Nill';
        }

    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
    }

    ////////STUDENT/////////////
    function get_students($class_id) {
        $query = $this->db->get_where('student', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_student_info($student_id) {
        $query = $this->db->get_where('student', array('student_id' => $student_id));
        return $query->result_array();
    }

    /////////instructor/////////////
    function get_instructors() {
        $query = $this->db->get('instructor');
        return $query->result_array();
    }

    function get_instructor_name($instructor_id) {
        $query = $this->db->get_where('instructor', array('instructor_id' => $instructor_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_instructor_info($instructor_id) {
        $query = $this->db->get_where('instructor', array('instructor_id' => $instructor_id));
        return $query->result_array();
    }

    //////////SUBJECT/////////////
    function get_subjects() {
        $query = $this->db->get('subject');
        return $query->result_array();
    }

    function get_subject_info($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    function get_subjects_by_class($class_id) {
        $query = $this->db->get_where('subject', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_subject_name_by_id($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
        return $query->name;
    }

    ////////////CLASS///////////
    function get_class_name($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_class_name_numeric($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name_numeric'];
    }

    function get_classes() {
        $query = $this->db->get('class');
        return $query->result_array();
    }

    function get_class_info($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        return $query->result_array();
    }

    //////////EXAMS/////////////
    function get_exams() {
        $query = $this->db->get_where('exam', array(
            'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
        ));
        return $query->result_array();
    }

    function get_exam_info($exam_id) {
        $query = $this->db->get_where('exam', array('exam_id' => $exam_id));
        return $query->result_array();
    }

    //////////GRADES/////////////
    function get_grades() {
        $query = $this->db->get('grade');
        return $query->result_array();
    }

    function get_grade_info($grade_id) {
        $query = $this->db->get_where('grade', array('grade_id' => $grade_id));
        return $query->result_array();
    }

    function get_obtained_marks($exam_id, $class_id, $subject_id, $student_id) {
        $marks = $this->db->get_where('mark', array(
                    'subject_id' => $subject_id,
                    'exam_id' => $exam_id,
                    'class_id' => $class_id,
                    'student_id' => $student_id))->result_array();

        foreach ($marks as $row) {
            echo $row['mark_obtained'];
        }
    }

    function get_highest_marks($exam_id, $class_id, $subject_id) {
        $this->db->where('exam_id', $exam_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->select_max('mark_obtained');
        $highest_marks = $this->db->get('mark')->result_array();
        foreach ($highest_marks as $row) {
            echo $row['mark_obtained'];
        }
    }

    function get_grade($mark_obtained) {
        $query = $this->db->get('grade');
        $grades = $query->result_array();
        foreach ($grades as $row) {
            if ($mark_obtained >= $row['mark_from'] && $mark_obtained <= $row['mark_upto'])
                return $row;
        }
    }

    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    function get_system_settings() {
        $query = $this->db->get('settings');
        return $query->result_array();
    }

    ////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

    /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    /////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('instructor');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        // echo 'uploads/' . $type . '_image/' . $id . '.jpg';die;
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }

    ////////STUDY MATERIAL//////////
    function save_study_material_info() {
        $data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['file_name'] = $_FILES["file_name"]["name"];
        $data['file_type'] = $this->input->post('file_type');
        $data['class_id'] = $this->input->post('class_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $this->db->insert('document', $data);

        $document_id = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" . $_FILES["file_name"]["name"]);
    }

    function select_study_material_info() {
        $this->db->order_by("timestamp", "desc");
        return $this->db->get('document')->result_array();
    }

    function select_study_material_info_for_student() {
        $student_id = $this->session->userdata('student_id');
        $class_id = $this->db->get_where('enroll', array(
                    'student_id' => $student_id,
                    'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                ))->row()->class_id;
        $this->db->order_by("timestamp", "desc");
        return $this->db->get_where('document', array('class_id' => $class_id))->result_array();
    }

    function update_study_material_info($document_id) {
        $data['timestamp'] = strtotime($this->input->post('timestamp'));
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['class_id'] = $this->input->post('class_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $this->db->where('document_id', $document_id);
        $this->db->update('document', $data);
    }

    function delete_study_material_info($document_id) {
        $this->db->where('document_id', $document_id);
        $this->db->delete('document');
    }

    ////////Automatic Message/////
    function send_new_automatic_message($data) {
        $message = $data['message'];
        $timestamp = strtotime(date("Y-m-d H:i:s"));

        $reciever = $data['reciever'];
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender'] = $sender;
            $data_message_thread['reciever'] = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

        return $message_thread_code;
    }

    ////////private message//////
    function send_new_private_message() {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));

        $reciever = $this->input->post('reciever');
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender'] = $sender;
            $data_message_thread['reciever'] = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    // QUESTION PAPER
    function create_question_paper() {
        $data['title'] = $this->input->post('title');
        $data['class_id'] = $this->input->post('class_id');
        $data['exam_id'] = $this->input->post('exam_id');
        $data['question_paper'] = $this->input->post('question_paper');
        $data['instructor_id'] = $this->session->userdata('login_user_id');

        $this->db->insert('question_paper', $data);
    }

    function update_question_paper($question_paper_id = '') {
        $data['title'] = $this->input->post('title');
        $data['class_id'] = $this->input->post('class_id');
        $data['exam_id'] = $this->input->post('exam_id');
        $data['question_paper'] = $this->input->post('question_paper');

        $this->db->update('question_paper', $data, array('question_paper_id' => $question_paper_id));
    }

    function delete_question_paper($question_paper_id = '') {
        $this->db->where('question_paper_id', $question_paper_id);
        $this->db->delete('question_paper');
    }

    // BOOK REQUEST
    function create_book_request() {
        $data['book_id'] = $this->input->post('book_id');
        $data['student_id'] = $this->session->userdata('login_user_id');
        $data['issue_start_date'] = strtotime($this->input->post('issue_start_date'));
        $data['issue_end_date'] = strtotime($this->input->post('issue_end_date'));

        $this->db->insert('book_request', $data);
    }

    public function vehicleStatus(int $instructor_attendance_id) {
        $clockinData = $this->db->get_where('instructor_attendance',['instructor_attendance_id' => $instructor_attendance_id])->row_array();
        $vehicleStatus = $this->db->get_where('vehicle_status',['instructor_attendance_id' => $clockinData['instructor_attendance_id']])->num_rows();
        if ($clockinData['status'] == 1) {
            if( $vehicleStatus == 0 ){
                $data = [
                    'instructor_attendance_id' => $clockinData['instructor_attendance_id'],
                    'vehicle_id' => $clockinData['vehicle_id'],
                    'instructor_id' => $clockinData['instructor_id'],
                    'section_id' => $clockinData['section_id'],
                    'year' => $clockinData['year'],
                    'vehicle_status' => 'in_use',
                    'clockin_time' => date('m/d/Y h:i:s a', time()),
                ];
                $this->db->insert('vehicle_status',$data);
            }
        } else {
            $data = [
                'vehicle_status' => 'not_in_use',
                'clockout_time' => date('m/d/Y h:i:s a', time())
            ];

            $this->db->where('instructor_attendance_id',$clockinData['instructor_attendance_id']);
            $this->db->update('vehicle_status',$data);
        }
        // echo $instructor_attendance_id;die;
    }
}
