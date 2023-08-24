<?php
if($this->crud_model->accessCheck('student')) {
?>
<li>
    <a href="<?php echo base_url(); ?>index.php?admin/student_add">
        <span><i class="entypo-plus"></i> <?php echo get_phrase('admit_student'); ?></span>
    </a>
</li>
<?php } ?>

<?php
if($this->crud_model->accessCheck('customer')) {
?>
<li >
    <a href="<?php echo base_url(); ?>index.php?admin/customer_enquiry_add">
        <span><i class="entypo-plus"></i> <?php echo get_phrase('admit_customer_enquiry'); ?></span>
    </a>
</li>
<li >
    <a href="<?php echo base_url(); ?>index.php?admin/customer_follow_up">
    <span><i class="entypo-plus"></i><?=get_phrase('customer_follow_up');?></span>
    </a>
</li>
<li>
    <a href="<?php echo base_url(); ?>index.php?admin/customer_add">
        <span><i class="entypo-plus"></i> <?php echo get_phrase('admit_customer'); ?></span>
    </a>
</li>
<?php } ?>

<?php 
if($this->crud_model->accessCheck('vehicle') === true) {
?>
	<li>
        <a href="<?php echo base_url(); ?>index.php?admin/vehicle_add">
            <span>
            	<i class="entypo-plus"></i>
			 	<?php echo get_phrase('admit_vehicle'); ?>
			</span>
        </a>
    </li>
    <li>
        <a href="<?php echo base_url(); ?>index.php?admin/vehicle_information">
            <span><i class="entypo-plus"></i> <?php echo get_phrase('vehicle_information'); ?></span>
        </a>
    </li>
<?php } ?>