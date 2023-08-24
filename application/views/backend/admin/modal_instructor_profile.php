<?php
$instructor_info		=	$this->db->get_where('instructor' , array('instructor_id' => $param2) )->result_array();

foreach ($instructor_info as $row):
    ?>

    <div class="profile-env">
        <header class="row">
            <div class="col-sm-3">
                <a href="#" class="profile-picture">
                    <img src="<?php echo $this->crud_model->get_image_url('instructor', $row['instructor_id']); ?>" 
                         class="img-responsive img-circle" />
                </a>
            </div>

            <div class="col-sm-9">
                <ul class="profile-info-sections">
                    <li style="padding:0px; margin:0px;">
                        <div class="profile-name">
                            <h3>
                                <?=$row['name']?>               
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
                        <?php if ($row['class_id'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('class'); ?></td>
                                <td><b><?php echo $this->crud_model->get_class_name($row['class_id']); ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['section_id'] != '' && $row['section_id'] != 0): ?>
                            <tr>
                                <td><?php echo get_phrase('section'); ?></td>
                                <td><b><?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['roll'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('roll'); ?></td>
                                <td><b><?php echo $row['roll']; ?></b></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?php echo get_phrase('birthday'); ?></td>
                            <td><b><?=$row['birthday']?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('gender'); ?></td>
                            <td><b>
                            <?=$row['sex']?>
                            </b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('phone'); ?></td>
                            <td><b>
                                <?=$row['phone']?>
                            </b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('email'); ?></td>
                            <td><b>
                                <?=$row['email']?>
                            </b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('address'); ?></td>
                            <td><b>
                                <?=$row['address']?>
                            </b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>		
        </section>
    </div>
<?php endforeach; ?>