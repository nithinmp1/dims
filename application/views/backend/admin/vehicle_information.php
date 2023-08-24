<hr />

<a href="<?php echo base_url(); ?>index.php?admin/vehicle_add"

   class="btn btn-primary pull-right">

    <i class="entypo-plus-circled"></i>

    <?php echo get_phrase('add_new_vehicle'); ?>

</a> 

<br>



<div class="row">

    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">

            <li class="active">

                <a href="#home" data-toggle="tab">

                    <span class="visible-xs"><i class="entypo-users"></i></span>

                    <span class="hidden-xs"><?php echo get_phrase('all_vehicle'); ?></span>

                </a>

            </li>

        </ul>



        <div class="tab-content">

            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">

                    <thead>

                        <tr>

                            <th width="80"><div><?php echo get_phrase('REG NO'); ?></div></th>

                            <th width="80"><div><?php echo get_phrase('photo'); ?></div></th>

                            <th><div><?php echo get_phrase('vehicle Class'); ?></div></th>

                            <th class="span3"><div><?php echo get_phrase('Owner Name'); ?></div></th>

                            <th><div><?php echo get_phrase('MV Tax Date'); ?></div></th>

                            <th><div><?php echo get_phrase('options'); ?></div></th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $where = $this->crud_model->setSplitWhere('vehicle');

                        $vehicle = $this->db->get_where('vehicle',$where)->result_array();

                        foreach ($vehicle as $row):

                            ?>

                            <tr>

                                <td><?php echo $row['REGNO']; ?></td>

                                <td><img src="<?php echo base_url($row['image']) ?>" class="img-circle" width="30" /></td>

                                <td><?php echo $row['vehicleClass']; ?></td>

                                <td><?php echo $row['ownerName']; ?></td>

                                <td><?php echo $row['MVTaxDate']; ?></td>

                                <td>

                                    <div class="btn-group">

                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">

                                            Action <span class="caret"></span>

                                        </button>

                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                            <!-- vehicle MARKSHEET LINK  -->

                                            <li>

                                                <a href="<?php echo base_url(); ?>index.php?admin/vehicle_classsheet/<?php echo $row['id']; ?>">

                                                    <i class="entypo-chart-bar"></i>

                                                    <?php echo get_phrase('class_sheet'); ?>

                                                </a>

                                            </li>



                                            <!-- vehicle PROFILE LINK -->

                                            <li>

                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_vehicle_profile/<?php echo $row['id']; ?>');">

                                                    <i class="entypo-user"></i>

                                                    <?php echo get_phrase('profile'); ?>

                                                </a>

                                            </li>



                                            <!-- vehicle EDITING LINK -->

                                            <li>

                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_vehicle_edit/<?php echo $row['id']; ?>');">

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