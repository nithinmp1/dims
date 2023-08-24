<?php 
    $invoices = $this->db->get_where('invoice', array('student_id' => $param2))->result_array();

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
                    <h5><?php echo get_phrase('creation_date'); ?> : <?php echo $invoices[0]['creation_timestamp'];?></h5>
                    <h5><?php echo get_phrase('title'); ?> : <?php echo $invoices[0]['title'];?></h5>
                    <h5><?php echo get_phrase('description'); ?> : <?php echo $invoices[0]['description'];?></h5>
                    <h5><?php echo get_phrase('status'); ?> : <?php echo $invoices[0]['status']; ?></h5>
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
                    <?php echo $this->db->get_where('student', array('student_id' => $invoices[0]['student_id']))->row()->name; ?><br>
                    <?php 
                        $class_id = $this->db->get_where('enroll' , array(
                            'student_id' => $invoices[0]['student_id'],
                                'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                        ))->row()->class_id;
                        echo get_phrase('class') . ' ' . $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                    ?><br>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" border="0">    
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('total_amount'); ?> :</td>
                <td align="right">
                <?php 
                echo array_sum(array_column($invoices,'amount'));
                ?>
                </td>
            </tr>
            <tr>
                <td align="right" width="80%"><h4><?php echo get_phrase('paid_amount'); ?> :</h4></td>
                <td align="right"><h4>
                <?php
                echo array_sum(array_column($invoices,'amount_paid')); 
                ?>    
                </h4></td>
            </tr>
            <?php if ($row['due'] != 0):?>
            <tr>
                <td align="right" width="80%"><h4><?php echo get_phrase('due'); ?> :</h4></td>
                <td align="right"><h4>
                <?php 
                echo array_sum(array_column($invoices,'due')); 
                ?>
                </h4></td>
            </tr>
            <?php endif;?>
        </table>

        <hr>
        

        <!-- payment history -->
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
                foreach ($invoices as $row):
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
                <?php endforeach; ?>
            </tbody>
            <tbody>
        </table>
    </div>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>