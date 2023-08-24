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



        <section class="profile-info-tabs">

            <div class="row">

                <div class="">

                    <br>

                    <table class="table table-bordered">

                        <?php

                        //  echo "<pre>";print_r($student_data);die;

                            foreach($student_data as $studentK => $studentV){

                                if (

                                    (($studentV != '') === true) &&

                                    (!in_array($studentK,['student_id', 'student_code']))

                                    ){

                                    ?>

                                        <tr>

                                            <td>
                                            <?php
                                            if ($studentK === 'package_id') {
                                                $studentK = 'package';
                                            } else if ($studentK === 'stream_id') {
                                                $studentK = 'stream';
                                            } else if ($studentK === 'blood_group') {
                                                $studentK = 'blood_group';
                                            } else if ($studentK === 'branch_id') {
                                                $studentK = 'branch';
                                            }

                                            echo get_phrase($studentK);
                                                 
                                            ?>
                                            </td>

                                            <td><b><?php

                                            if($studentK === 'identification_mark'){

                                                $studentIdMark = json_decode($studentV);

                                            ?>

                                            <ul>

                                                <?php

                                                foreach($studentIdMark as $studentIdMarkK => $studentIdMarkV){

                                                 ?><li><?php   

                                                    echo $studentIdMarkV."<br>";

                                                    ?></li><?php

                                                }

                                                ?>

                                            </ul>

                                            <?php

                                            } else if ($studentK === 'package') {
                                                $package_id = json_decode($studentV, true);
                                            ?>
                                            <ul>
                                            <?php
                                                foreach ($package_id as $packageId) {
                                                ?>
                                                <li>
                                                <?php
                                                    $package = $this->db->get_where('package', ['package_id' => $packageId])->row_array();
                                                    echo $package['name']
                                                ?>
                                                </li>
                                                <?php 
                                                }
                                            ?>
                                            </ul>
                                            <?php
                                            } else if ($studentK === 'stream') {
                                                $stream = $this->db->get_where('stream',['stream_id' => $studentV])->row_array();
                                                echo $stream['name'];
                                            } else if ($studentK === 'blood_group') {
                                                $blood_group = $this->db->get_where('blood_group',['blood_id' => $studentV])->row_array();
                                                echo $blood_group['name'];
                                            } else if ($studentK === 'branch') {
                                                $branch = $this->db->get_where('branch',['branch_id' => $studentV])->row_array();
                                                echo $branch['name'];
                                            } else{

                                                echo $studentV;

                                            }

                                            

                                            

                                            ?></b></td>

                                        </tr>

                                    <?php

                                }



                            }

                        ?>

                    </table>

                </div>

            </div>		

        </section>

    </div>