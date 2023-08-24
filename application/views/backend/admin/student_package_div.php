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

        <?php 



        $where_in = json_decode($student_data['package_id'],true);

        $this->db->where_in('package_id',$where_in);

        $where = $this->crud_model->setSplitWhere('package');
        $packages = $this->db->get_where('package',$where)->result_array();

        $packagesChunk = array_chunk($packages,2);

        foreach($packagesChunk as $packagesChunkK => $packagesChunkV) {

        ?>

        <div class="row">

            <?php 

            foreach($packagesChunkV as $packagesChunkVK => $row){

            ?>

            <div class="col-sm-6">

                <div class="card">

                <div class="card-body">

                    <h5 class="card-title"><?=$row['name']?> (<?=$row['amount']?>)</h5>

                    <p class="card-text">Includes : 

                        <?php  

                        $allocatedTiem = json_decode($row['allocatedTiem'],true);

                        foreach($allocatedTiem as $alloK => $alloV){

                            $class = $this->db->get_where('class',['class_id' => $alloK])->row();

                            $instructor = $this->db->get_where('instructor',['instructor_id' => $class->instructor_id])->row();

                            echo $class->name.' by instructor '.$instructor->name."<br>" ;

                        }

                        ?>

                    </p>

                    <a href="#" class="btn btn-success">Added</a>

                </div>

                </div>

            </div>

            <?php } ?>

        </div>

        <?php } ?>    

    </section>

</div>