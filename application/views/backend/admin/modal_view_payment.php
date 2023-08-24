<?php
$edit_data = $this->db->get_where('payment', array('payment_id' => $param2))->result_array();
$invoice = $this->db->get_where('invoice', array('invoice_id' => $edit_data[0]['invoice_id']))->row_array();
foreach ($edit_data as $row):
?>
<center>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print Invoice
        <i class="entypo-print"></i>
    </a>
</center>

    <br><br>

    <div id="invoice_print">
        <table width="100%" border="0">
            <tr>
                <td align="right">
                    <h5><?php echo get_phrase('creation_date'); ?> : <?php echo $row['timestamp'];?></h5>
                    <h5><?php echo get_phrase('title'); ?> : <?php echo $row['title'];?></h5>
                    <h5><?php echo get_phrase('description'); ?> : <?php echo $row['description'];?></h5>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" border="0">    
            <tr>
                <td align="left"><h4><?php echo get_phrase('payment_to'); ?> </h4></td>
                <td align="right"><h4><?php echo get_phrase('bill_to'); ?> </h4></td>
            </tr>

            <tr>
                <td align="left" valign="top">
                    <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>            
                </td>
                <td align="right" valign="top">
                    <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?><br>
                    <?php 
                        // $class_id = $this->db->get_where('enroll' , array(
                        //     'student_id' => $row['student_id'],
                        //         'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                        // ))->row()->class_id;
                        // echo get_phrase('package') . ' ' . $this->db->get_where('class', array('class_id' => $class_id))->row()->name;

                        $package = $this->db->get_where('package',['package_id' => $row['package_id']])->row_array();
                        echo get_phrase('package') . ': ' . $package['name'];
                    ?><br>
                </td>
            </tr>
        </table>
        <hr>

        <table width="100%" border="0">    
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('total_amount'); ?> :</td>
                <td align="right"><?php echo $invoice['amount']; ?></td>
            </tr>
            <tr>
                <td align="right" width="80%"><h4><?php echo get_phrase('paid_amount'); ?> :</h4></td>
                <td align="right"><h4><?php echo $invoice['amount_paid']; ?></h4></td>
            </tr>
            <?php if ($invoice['due'] != 0):?>
            <tr>
                <td align="right" width="80%"><h4><?php echo get_phrase('due'); ?> :</h4></td>
                <td align="right"><h4><?php echo $invoice['due']; ?></h4></td>
            </tr>
            <?php endif;?>
        </table>

        <!-- payment history -->
        <?php
        /* 
        <h4><?php echo get_phrase('payment_history'); ?></h4>
        <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th><?php echo get_phrase('date'); ?></th>
                    <th><?php echo get_phrase('amount'); ?></th>
                    <th><?php echo get_phrase('method'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $payment_history = $this->db->get_where('payment', array('invoice_id' => $row['invoice_id']))->result_array();
                foreach ($payment_history as $row2):
                    ?>
                    <tr>
                        <td><?php echo $row2['timestamp']; ?></td>
                        <td><?php echo $row2['amount']; ?></td>
                        <td>
                            <?php 
                                $payment_mode = $this->db->get_where('payment_mode',['payment_mode_id' => $row2['method']])->row();
                                    echo $payment_mode->name;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tbody>
        </table>
        */
        ?>
    </div>
<?php endforeach; ?>