<hr />

<?php echo form_open(base_url() . 'index.php?instructor/attendance_selector/');?>
<div class="row">
	<?php
			$instructor_attendance = $this->db->get_where('instructor_attendance',['status' => 1, 'instructor_id' => $this->session->userdata('instructor_id')])->result_array();
			if(!empty($instructor_attendance)):
				$section_id = array_column($instructor_attendance,'section_id');
	?>
	<div class="col-md-3 col-sm-offset-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date');?></label>
			<input type="text" class="form-control datepicker" name="timestamp" data-format="dd-mm-yyyy"
				value="<?php echo date("d-m-Y");?>"/>
		</div>
	</div>

	<?php
		$this->db->where_in('section_id',$section_id);
		$query = $this->db->get_where('section');
		$sections = $query->result_array();
	?>

	<div class="col-md-3">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
			<select class="form-control selectboxit" name="section_id">
				<?php foreach($sections as $key => $row):?>
					<option value="<?php echo $row['section_id'];?>" <?=($key > 0)?'disabled':''?> ><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<input type="hidden" name="class_id" value="<?php echo $class_id;?>">
	<input type="hidden" name="year" value="<?php echo $running_year;?>">
	<input type="hidden" name="instructor_att" value="<?php echo $running_year;?>">

	<div class="col-md-3" style="margin-top: 20px;">
		<button type="submit" class="btn btn-info"><?php echo get_phrase('manage_attendance');?></button>
	</div>
	<?php else:
		echo "Please Clock In";
		?>
	<?php endif;?>
	
</div>
<?php echo form_close();?>