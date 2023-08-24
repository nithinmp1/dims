<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#profile" data-toggle="tab" aria-expanded="true"><i class="entypo-user"></i> 
					<?php echo get_phrase('profile');?>
                </a>
            </li>
            <li>
            	<a href="#attandance" data-toggle="tab"><i class="entypo-back-in-time"></i> 
					<?php echo get_phrase('attandance');?>
                </a>
            </li>
            <li>
            	<a href="#package" data-toggle="tab"><i class="entypo-basket"></i> 
					<?php echo get_phrase('package');?>
                </a>
            </li>
            <li>
                <a href="#package2" data-toggle="tab"><i class="entypo-basket"></i> 
                    <?php echo get_phrase('package_list');?>
                </a>
            </li>
            <li>
                <a href="#service_list" data-toggle="tab"><i class="entypo-basket"></i> 
                    <?php echo get_phrase('service_list');?>
                </a>
            </li>
            <li>
            	<a href="#exam" data-toggle="tab"><i class="entypo-vcard"></i> 
					<?php echo get_phrase('add_LL/DL');?>
                </a>
            </li>
            <li>
            	<a href="#payment" data-toggle="tab"><i class="entypo-plus"></i> 
					<?php echo get_phrase('add_payment');?>
                </a>
            </li>
            <li>
            	<a href="#expence" data-toggle="tab"><i class="entypo-plus"></i> 
					<?php echo get_phrase('add_expence');?>
                </a>
            </li>
		</ul>
    	<!------CONTROL TABS END------>
        
	
		<div class="tab-content">
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="profile" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_profile_div.php'); ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->
            
            <!----EDITING FORM STARTS---->
			<div class="tab-pane box" id="attandance" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_attandance_div.php'); ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->
            
            <!----EDITING FORM STARTS---->
			<div class="tab-pane box" id="package" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_package_div.php'); ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->

            <!----EDITING FORM STARTS---->
            <div class="tab-pane box" id="package2" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_package_list_div.php'); ?>
                </div>
            </div>
            <!----EDITING FORM ENDS-->

            <!----EDITING FORM STARTS---->
            <div class="tab-pane box" id="service_list" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_service_list_div.php'); ?>
                </div>
            </div>
            <!----EDITING FORM ENDS-->
            
            <!----EDITING FORM STARTS---->
			<div class="tab-pane box" id="exam" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_exam_div.php'); ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->
            
            <!----EDITING FORM STARTS---->
			<div class="tab-pane box" id="payment" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_payment_div.php'); ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->

            <!----EDITING FORM STARTS---->
			<div class="tab-pane box" id="expence" style="padding: 5px">
                <div class="box-content">
                    <?php $this->load->view('backend/admin/student_expence_div.php'); ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->
		</div>
	</div>
</div>

<br>
