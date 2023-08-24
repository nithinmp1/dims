<!-- Attendence from enrol table -->

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

            <table class="table table-bordered datatable">

                <thead>

                    <tr>

                        <th width="80"><div><?php echo get_phrase('SI NO'); ?></div></th>

                        <th><div><?php echo get_phrase('Name'); ?></div></th>

                        <th hidden class="span3"><div><?php echo get_phrase('Attended Hours'); ?></div></th>
                        <th class="span3"><div><?php echo get_phrase('Attended Classes'); ?></div></th>

                        <th hidden><div><?php echo get_phrase('Remaining Hours'); ?></div></th>
                        <th><div><?php echo get_phrase('Remaining Classes'); ?></div></th>

                        <th><div><?php echo get_phrase('options'); ?></div></th>

                    </tr>

                </thead>

                <tbody>

                <?php 

                foreach($enroll_data as $enroll_dataK => $enroll_dataV){

                    $key = array_search($enroll_dataV['class_id'], array_column($class_data, 'class_id'));

                ?>

                    <tr>

                        <td><?=$enroll_dataK+1?></td>

                        <td><?=$class_data[$key]['name']?></td>

                        <td><?=$enroll_dataV['class_count_status']?></td>
                        <td><?=$enroll_dataV['class_count'] - $enroll_dataV['class_count_status']?></td>
                        <td>

                            <div class="btn-group">

                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">

                                    Action <span class="caret"></span>

                                </button>

                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">



                                    <!-- STUDENT MARKSHEET LINK  -->

                                    <li>

                                        <a href="<?php echo base_url(); ?>index.php?admin/student_marksheet/<?php echo $row['student_id']; ?>">

                                            <i class="entypo-chart-bar"></i>

                                            <?php echo get_phrase('Close'); ?>

                                        </a>

                                    </li>



                                    <!-- STUDENT PROFILE LINK -->

                                    <li>

                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_enroll_edit/<?=$enroll_dataV['enroll_id'] ?>');">

                                            <i class="entypo-user"></i>

                                            <?php echo get_phrase('Add'); ?>

                                        </a>

                                    </li>



                                    <!-- STUDENT EDITING LINK -->

                                    <li>

                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_student_edit/<?php echo $row['student_id']; ?>');">

                                            <i class="entypo-pencil"></i>

                                            <?php echo get_phrase('Delete'); ?>

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </td>

                    </tr>

                <?php    

                }

                ?>

                </tbody>

            </table>

            </div>

        </section>

    </div>