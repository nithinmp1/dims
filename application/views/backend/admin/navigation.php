<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="uploads/logo.png"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>
        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>
    <ul id="ul" class="main-menu">

        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
         <!-- reward_masterS -->
        <?php
        if($this->crud_model->accessCheck('reward_master')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('reward_master')?>"data-menu="reward_master" class="listLi <?php
        if ($page_name == 'reward_master' ||
                $page_name == 'section' ||
                $page_name == 'academic_syllabus')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-box"></i>
                <span><?php echo get_phrase('reward_master'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'reward_master') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/reward_masters">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('manage_reward_points'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'reward_master_data') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/reward_list">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('reward_list'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <!-- STREAM -->
        <?php
        if($this->crud_model->accessCheck('branch') === true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('branch')?>" data-menu="stream" class="listLi <?php if ($page_name == 'branch') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/branch">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('branch'); ?></span>
            </a>
        </li>
        <?php } ?>

        <?php
        if($this->crud_model->accessCheck('branch') === true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('branch_report')?>" data-menu="stream" class="listLi <?php if ($page_name == 'branch_report') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/branch_report">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('branch_report'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- STREAM -->
        <?php
        if($this->crud_model->accessCheck('main_stream') === true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('main_stream')?>" data-menu="stream" class="listLi <?php if ($page_name == 'stream') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/stream">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('main_stream'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- ACCESS -->
        <?php
        if($this->crud_model->accessCheck('access_management') === true) {
        // echo $this->crud_model->getOrder('access_management');die;

        ?>
        <li data-order="<?=$this->crud_model->getOrder('access_management')?>"data-menu="access_management" class="listLi <?php if ($page_name == 'stream') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/access_management">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('access_management'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- STAFF -->
        <?php
        if($this->crud_model->accessCheck('staff') === true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('staff')?>"data-menu="staff" class="listLi <?php if ($page_name == 'staff') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/staff">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('staff'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- vehicle -->
        <?php
        if($this->crud_model->accessCheck('vehicle') === true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('vehicle')?>"data-menu="vehicle" class="listLi <?php
        if ($page_name == 'vehicle_add' ||
                $page_name == 'vehicle_information'
                )
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-plus"></i>
                <span><?php echo get_phrase('vehicle'); ?></span>
            </a>
            <ul >
                <!-- vehicle ADMISSION -->
                <li class="<?php if ($page_name == 'vehicle_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/vehicle_add">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('admit_vehicle'); ?></span>
                    </a>
                </li>

                <!-- vehicle INFORMATION -->
                <li class="<?php if ($page_name == 'vehicle_information') echo 'opened active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/vehicle_information">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('vehicle_information'); ?></span>
                    </a>
                </li>

            </ul>
        </li>
        <?php } ?>

        <!-- instructor -->
        <?php
        if($this->crud_model->accessCheck('instructor')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('instructor')?>" data-menu="instructor" class="listLi <?php if ($page_name == 'instructor') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/instructor">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('instructor'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- CLASS -->
        <?php
        if($this->crud_model->accessCheck('class')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('class')?>"data-menu="class" class="listLi <?php
        if ($page_name == 'class' ||
                $page_name == 'section' ||
                $page_name == 'academic_syllabus')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span><?php echo get_phrase('class'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'class') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/classes">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('manage_classes'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'section') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/section">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('manage_sections'); ?></span>
                    </a>
                </li>
                <!-- <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/academic_syllabus">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('academic_syllabus'); ?></span>
                    </a>
                </li> -->
            </ul>
        </li>
        <?php } ?>
        
        <!-- PACKAGES -->
        <?php
        if($this->crud_model->accessCheck('package')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('package')?>"data-menu="package" class="listLi <?php
        if ($page_name == 'package' ||
                $page_name == 'section' ||
                $page_name == 'academic_syllabus')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-box"></i>
                <span><?php echo get_phrase('package'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'package') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/packages">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('manage_packages'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>

        
        <!-- STUDENT -->
        <?php
        if($this->crud_model->accessCheck('student')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('student')?>"data-menu="student" class=" <?php
        if ($page_name == 'student_add' ||
                $page_name == 'student_bulk_add' ||
                $page_name == 'student_information' ||
                $page_name == 'student_marksheet' ||
                $page_name == 'student_list' ||
                $page_name == 'student_promotion')
            echo 'opened active has-sub';
        ?> listLi">
            <a href="#">
                <i class="fa fa-group"></i>
                <span><?php echo get_phrase('student'); ?></span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_add">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li>
                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                    <ul>
                        <li class="<?php if ($page_name == 'student_information') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/student_list">
                                <span><?=get_phrase('student_information');?></span>
                            </a>
                        </li>
                        <?php 
                        $status = $this->db->get('status_table')->result();
                        foreach($status as $statusK => $statusV){ ?>
                        <li class="<?php if ($page_name == strtolower($statusV->name).'_student_information') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/student_list/<?=$statusV->name?>">
                                <span><?=get_phrase(strtolower($statusV->name).'_student_information');?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </li>
        <?php } ?>
        
        <!-- Customer Service -->
        <?php
        if($this->crud_model->accessCheck('customer_service')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('customer_service')?>"data-menu="customer_service" class="listLi <?php if ($page_name == 'customer_service') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/customer_service">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('customer_service'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- Customer Task -->
        <?php
        /*(
         */
        if($this->crud_model->accessCheck('customer_task')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('customer_task')?>"data-menu="customer_task" class="listLi <?php if ($page_name == 'customer_task') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/customer_task">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('customer_task'); ?></span>
            </a>
        </li>
        <?php } ?>
        
        <!-- customer -->
        <?php
        if($this->crud_model->accessCheck('customer')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('customer')?>" data-menu="customer" class="listLi <?php
        if ($page_name == 'customer_add' ||
                $page_name == 'customer_bulk_add' ||
                $page_name == 'customer_information' ||
                $page_name == 'customer_task_list' ||
                $page_name == 'customer_follow_up' ||
                $page_name == 'customer_enquiry')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span><?php echo get_phrase('customer'); ?></span>
            </a>
            <ul>
                <!-- customer ADMISSION -->
                <li class="<?php if ($page_name == 'customer_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/customer_add">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('admit_customer'); ?></span>
                    </a>
                </li>
                <!-- customer ADMISSION -->
                <li class="<?php if ($page_name == 'customer_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/customer_enquiry_add">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('admit_customer_enquiry'); ?></span>
                    </a>
                </li>
                <!-- customer INFORMATION -->
                <li class="<?php if ($page_name == 'customer_information' || $page_name == 'customer_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('customer_information'); ?></span>
                    </a>
                    <ul>
                        <li class="<?php if ($page_name == 'customer_information') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/customer_list">
                                <span><?=get_phrase('customer_information');?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- customer task -->
                <li class="<?php if ($page_name == 'customer_task_list' || $page_name == 'customer_task_list') echo 'opened active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/customer_task_list">
                    <span><i class="entypo-list-add"></i><?=get_phrase('customer_task_list');?></span>
                    </a>
                </li>
                <!-- customer enquery -->
                <li class="<?php if ($page_name == 'customer_enquiry' || $page_name == 'customer_enquiry') echo 'opened active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/customer_enquiry">
                    <span><i class="entypo-list-add"></i><?=get_phrase('customer_enquiry');?></span>
                    </a>
                </li>
                <!-- customer followup -->
                <li class="<?php if ($page_name == 'customer_follow_up' || $page_name == 'customer_follow_up') echo 'opened active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/customer_follow_up">
                    <span><i class="entypo-list-add"></i><?=get_phrase('customer_follow_up');?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>

        <!-- ACCOUNTANT -->
        <?php
        /*
        if($this->crud_model->accessCheck('accountant')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('accountant')?>"data-menu="accountant" class="listLi <?php if ($page_name == 'accountant') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/accountant">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('accountant'); ?></span>
            </a>
        </li>
        <?php }
        */ ?>

        <!-- DAILY ATTENDANCE -->
        <?php
        
        if($this->crud_model->accessCheck('daily_attandance')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('daily_attandance')?>" data-menu="daily_attandance" class="listLi <?php
        if ($page_name == 'manage_attendance' ||
                $page_name == 'manage_attendance_view' || $page_name == 'attendance_report' || $page_name == 'attendance_report_view'
                || $page_name == 'manage_attendance_instructor'|| $page_name == 'manage_attendance_view_instructor'
                || $page_name == 'attendance_report_instructor'|| $page_name == 'attendance_report_view_instructor'
                || $page_name == 'attendance_report_student'|| $page_name == 'attendance_report_view_student'
                )
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('daily_attendance'); ?></span>
            </a>
            <ul>

                <li class="<?php if (($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view')) echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_attendance">
                        <span><i class="entypo-list-add"></i><?php echo get_phrase('daily_atendance'); ?></span>
                    </a>
                </li>

            </ul>
            <ul>
                <li class="<?php if (( $page_name == 'attendance_report' || $page_name == 'attendance_report_view')) echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/attendance_report">
                        <span><i class="entypo-list-add"></i><?php echo get_phrase('attendance_report_student'); ?></span>
                    </a>
                </li>

            </ul>
            <ul>
                <li class="<?php if (( $page_name == 'attendance_report_student' || $page_name == 'attendance_report_view_student')) echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/attendance_report_student">
                        <span><i class="entypo-list-add"></i><?php echo get_phrase('attendance_report_student'); ?></span>
                    </a>
                </li>

            </ul>

            <ul>
                <li class="<?php if (($page_name == 'manage_attendance_instructor' || $page_name == 'manage_attendance_instructor_view')) echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_attendance_instructor">
                        <span><i class="entypo-list-add"></i><?php echo get_phrase('daily_atendance_instructor'); ?></span>
                    </a>
                </li>

            </ul>
            
              <ul>
                <li class="<?php if (( $page_name == 'attendance_report_instructor' || $page_name == 'attendance_report_view_instructor')) echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/attendance_report_instructor">
                        <span><i class="entypo-list-add"></i><?php echo get_phrase('attendance_report_instructor'); ?></span>
                    </a>
                </li>

            </ul>
        </li>
        <?php } 
        
        ?>

        <!-- EXAMS -->
        <?php
        if($this->crud_model->accessCheck('test')) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('test')?>" data-menu="test" class="listLi <?php
        if ($page_name == 'exam' ||
                $page_name == 'grade' ||
                $page_name == 'marks_manage' ||
                $page_name == 'exam_marks_sms' ||
                $page_name == 'tabulation_sheet' ||
                $page_name == 'marks_manage_view' || $page_name == 'question_paper')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('Test'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/exam">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('test_list'); ?></span>
                    </a>
                </li>
                <?php 
                $examtype = $this->db->get_where('exam_type')->result_array();
                foreach ($examtype as $examtypekey => $examtypevalue) { ?>
                <li class="<?php if ($page_name == $examtypevalue['name']) echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/exam/<?=(int) $examtypevalue['exam_type_id']?>">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('test_list'); ?> (<?=$examtypevalue['name']?>)</span>
                    </a>
                </li>
                <?php }


                /*
                <li class="<?php if ($page_name == 'grade') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/grade">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('exam_grades'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'marks_manage' || $page_name == 'marks_manage_view') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/marks_manage">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('manage_marks'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'exam_marks_sms') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/exam_marks_sms">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('send_marks_by_sms'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'tabulation_sheet') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/tabulation_sheet">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('tabulation_sheet'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'question_paper') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/question_paper">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('question_paper'); ?></span>
                    </a>
                </li>
                */ ?>
            </ul>
        </li>
        <?php } ?>

        <!-- ACCOUNTING -->
        <?php
        if(
            $this->crud_model->accessCheck('student_payment') ||
            $this->crud_model->accessCheck('income_category') ||
            $this->crud_model->accessCheck('payment_mode') ||
            $this->crud_model->accessCheck('expense') ||
            $this->crud_model->accessCheck('expense_category')
        ) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('accounting')?>" data-menu="accounting" class="listLi <?php
        if ($page_name == 'income' ||
                $page_name == 'expense' ||
                $page_name == 'expense_category' ||
                $page_name == 'category_wise_expense' ||
                $page_name == 'category_wise_income' ||
                $page_name == 'unpaid' ||
                $page_name == 'total' || 
                $page_name == 'student_payment' ||
                $page_name == 'income_category' ||
                $page_name == 'payment_mode'
                )
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-suitcase"></i>
                <span><?php echo get_phrase('accounting'); ?></span>
            </a>
            <ul>
                <?php if($this->crud_model->accessCheck('student_payment') && false) { ?>
                <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_payment">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('create_student_payment'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('student_payment')) { ?>
                <li class="<?php if ($page_name == 'income') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/income">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('payments'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('income')) { ?>
                <li class="<?php if ($page_name == 'income_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/income_category">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('income_category'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('payment_mode')) { ?>
                <li class="<?php if ($page_name == 'payment_mode') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/payment_mode">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('payment_mode'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('expense')) { ?>
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/expense">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('expense'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('expense')) { ?>
                <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/expense_category">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('expense_category'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('expense')) { ?>
                <li class="<?php if ($page_name == 'category_wise_expense') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/category_wise_expense">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('category_wise_expense'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('income')) { ?>
                <li class="<?php if ($page_name == 'category_wise_income') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/category_wise_income">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('category_wise_income'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('income')) { ?>
                <li class="<?php if ($page_name == 'unpaid') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/unpaid">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('unpaid'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if($this->crud_model->accessCheck('expense')) { ?>
                <li class="<?php if ($page_name == 'total' || $page_name == 'income_expense_view') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/total">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('total'); ?></span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php }
        ?>

        <!-- NOTICEBOARD -->
        <?php
        if((in_array('remarks', $this->session->userdata('access')) === true) ) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('remarks')?>" data-menu="remarks" class="listLi <?php if ($page_name == 'remarks') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/remarks">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('remarks'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- NOTICEBOARD -->
        <?php
        if((in_array('noticeboard', $this->session->userdata('access')) === true) || true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('noticeboard')?>" data-menu="noticeboard" class="listLi <?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/noticeboard">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- MESSAGE -->
        <?php
        if((in_array('message', $this->session->userdata('access')) === true) || true) {
        ?>
        <li data-order="<?=$this->crud_model->getOrder('message')?>" data-menu="message" class="listLi <?php if ($page_name == 'message') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/message">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
        </li>
        <?php } ?>

        <!-- SETTINGS -->
        <li data-order="<?=$this->crud_model->getOrder('settings')?>" data-menu="settings" class="listLi <?php
        if ($page_name == 'system_settings' ||
                $page_name == 'manage_language' ||
                $page_name == 'sms_settings')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('general_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/sms_settings">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('sms_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_language">
                        <span><i class="entypo-list-add"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li data-order="<?=$this->crud_model->getOrder('account')?>" class="listLi <?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>

<script type="text/javascript">
    var result = $('.listLi').sort(function (a, b) {

      var contentA =parseInt( $(a).data('order'));
      var contentB =parseInt( $(b).data('order'));
      return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
   });
   $('#ul').html(result);

   var index = $(".listLi .active").index();
    $(".listLi ul").each(function() {
        $(this).children("ul").addClass("visible");
    });
    // $('li.menu').hasClass('active');
</script>