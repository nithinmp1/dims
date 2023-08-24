<div style="text-align:center;">
    <h2 style="font-weight:200; margin:0px;color: green;">
    Student Per Branch Table
    </h2>
</div>
<footer class="main"></footer>
                <table class="table table-bordered datatable" id="table_student_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll'); ?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo'); ?></div></th>
                            <th ><div><?php echo get_phrase('stream'); ?></div></th>
                            <th><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase('phone'); ?></div></th>
                            <th class="span3"><div><?php echo get_phrase('payable'); ?></div></th>
                            <th><div><?php echo get_phrase('pending'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = [];
                        
                        if (isset($branch_id) && $branch_id != ''){
                            $branch = $this->db->get_where('branch',['branch_id' => $branch_id])->row();
                        }else{
                            $branch = $this->db->select('*')->from('branch')->limit('1')->get()->row();
                        }
                        $where['branch_id'] = $branch->branch_id;                        
                        
                        $students = $this->db->order_by('student_id','desc')->get_where('student', $where)->result_array();
                        $i = 0;
                        foreach ($students as $keyRow => $row):
                            ?>
                            <tr>
                                <td><?php echo $keyRow+1; ?></td>
                                <td><img src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']); ?>" class="img-circle" width="30" /></td>
                                <td>
                                    <?=$this->crud_model->get_stream($row['stream_id']);?>
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
                                    echo $this->db->get_where('student', array(
                                        'student_id' => $row['student_id']
                                    ))->row()->phone;
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    echo $this->db->get_where('student', array(
                                        'student_id' => $row['student_id']
                                    ))->row()->tottalFee;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['tottalFee'] - $row['paidFee'];
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
                                                <a href="<?=base_url('index.php?admin/student_profile/'.$row["student_id"])?>" >
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

                                            <!-- STUDENT EDITING LINK -->
                                            <li>
                                                <a href="<?=base_url('index.php?admin/studentsDocuments/'.$row["student_id"].'/student')?>">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('Documents'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {


        var datatable = $("#table_student_export").dataTable({
            "sPaginationType": "bootstrap",
            "iDisplayLength" : "4",
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