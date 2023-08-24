<div class="profile-env">

    <header class="row">

        <div class="col-sm-3">

            <a href="#" class="profile-picture">

                <img src="<?php echo $this->crud_model->get_image_url('student', $student_data['student_id']); ?>" 

                        class="img-responsive img-circle" />

            </a>

        </div>



        <div class="col-sm-9">

            <ul class="profile-info-sections">

                <li style="padding:0px; margin:0px;">

                    <div class="profile-name">

                        <h3>

                            <?php echo $this->db->get_where('student', array('student_id' => $param2))->row()->name; ?>                     

                        </h3>
                    </div>

                </li>

            </ul>

        </div>

    </header>

    <br/>

    <section class="profile-info-tabs">
        <div class="row" style="
		    padding-bottom: 20px;
		    padding-top: 0px;
		">>
            <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_document_add/<?php echo $param2; ?>');" class="btn btn-primary pull-right">
			<i class="entypo-plus-circled"></i>
    		Add Document</a>
    	</div>
        <?php 
        $packagesChunk = array_chunk($files,2);
        foreach($packagesChunk as $packagesChunkK => $packagesChunkV) {
        ?>
        <div class="row">
            <?php 
            foreach($packagesChunkV as $packagesChunkVK => $row){
            ?>
            <div class="col-sm-6">
                <div class="card">
	                <div class="card-body">
	                	<?php
	                	 $path = $directory.'/'.$row; 
	                	 ?>
	                	<img src="<?=$path?>" height="500px" width="500px">
	                </div>
	                <?php 
		            echo form_open(base_url() . 'index.php?admin/studentsDocRemove' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),['path' => $path]);
		            ?>
	                <button type="submit"  class="btn btn-primary">Remove</button>
		            </form>
                </div>
            </div>
            <?php 
            }
            ?>
        </div>

        <?php 
    	}
        ?>    

    </section>

</div>