<hr />
 
<br>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php 
                    echo get_phrase('attendance'); ?></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('si_no'); ?></div></th>
                            <th width="80"><div><?php echo get_phrase('vehicle'); ?></div></th>
                            <th><div><?php echo get_phrase('instructor'); ?></div></th>
                            <th><div><?php echo get_phrase('student'); ?></div></th>
                            <th><div><?php echo get_phrase('date'); ?></div></th>
                            <th><div><?php echo get_phrase('section'); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = [];
                        $student_attandance = $this->db->get_where('attendance',$where)->result_array();
                        $i = 0;
                        foreach ($student_attandance as $key => $row):
                            ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><img src="<?php echo $this->crud_model->get_image_url('vehicle', $row['vehicle_id']); ?>" class="img-circle" width="30" /></td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('instructor', array(
                                        'instructor_id' => $row['instructor_id']
                                    ))->row()->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('student', array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo date('m/d/y',$row['timestamp']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('section', array(
                                        'section_id' => $row['section_id']
                                    ))->row()->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('class', array(
                                        'class_id' => $row['class_id']
                                    ))->row()->name;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php
            $query = $this->db->get_where('section', array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
                    ?>
                    <div class="tab-pane" id="<?php echo $row['section_id']; ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="80"><div><?php echo get_phrase('roll'); ?></div></th>
                                    <th width="80"><div><?php echo get_phrase('photo'); ?></div></th>
                                    <th><div><?php echo get_phrase('name'); ?></div></th>
                                    <th class="span3"><div><?php echo get_phrase('address'); ?></div></th>
                                    <th><div><?php echo get_phrase('email'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $students = $this->db->get_where('enroll', array(
                                            'class_id' => $class_id, 'section_id' => $row['section_id'], 'year' => $running_year
                                        ))->result_array();
                                foreach ($students as $row):
                                    ?>
                                    <tr>
                                        <td><?php echo $row['roll']; ?></td>
                                        <td><img src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']); ?>" class="img-circle" width="30" /></td>
                                        <td>
                                            <?php
                                            echo $this->db->get_where('student', array(
                                                'student_id' => $row['student_id']
                                            ))->row()->name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->db->get_where('student', array(
                                                'student_id' => $row['student_id']
                                            ))->row()->address;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->db->get_where('student', array(
                                                'student_id' => $row['student_id']
                                            ))->row()->email;
                                            ?>
                                        </td>
                                        <td>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                    <!-- STUDENT PROFILE LINK -->
                                                    <li>
                                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id']; ?>');">
                                                            <i class="entypo-user"></i>
                                                            <?php echo get_phrase('profile'); ?>
                                                        </a>
                                                    </li>

                                                    <!-- STUDENT EDITING LINK -->
                                                    <li>
                                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_student_edit/<?php echo $row['student_id']; ?>');">
                                                            <i class="entypo-pencil"></i>
                                                            <?php echo get_phrase('edit'); ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {


        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [

                    {
                        "sExtends": "xls",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText": "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(1, false);
                            datatable.fnSetColumnVis(5, false);

                            this.fnPrint(true, oConfig);

                            window.print();

                            $(window).keyup(function (e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(1, true);
                                    datatable.fnSetColumnVis(5, true);
                                }
                            });
                        },

                    },
                ]
            },

        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>