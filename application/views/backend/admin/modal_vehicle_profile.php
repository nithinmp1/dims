<?php
$instructor_info = $this->db->get_where('vehicle',['id' => $param2])->result_array();
foreach ($instructor_info as $row):
    ?>

    <div class="profile-env">
        <header class="row">
            <div class="col-sm-3">
                <a href="#" class="profile-picture">
                    <img src="<?php echo base_url($row['image']); ?>" 
                         class="img-responsive img-circle" />
                </a>
            </div>

            <div class="col-sm-9">
                <ul class="profile-info-sections">
                    <li style="padding:0px; margin:0px;">
                        <div class="profile-name">
                            <h3>
                                <?php echo $row['REGNO']; ?>                     
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
                        <?php if ($row['vehicleClass'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('Vehicle Class'); ?></td>
                                <td><b><?php echo $row['vehicleClass']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['fuel'] != '' && $row['fuel'] != 0): ?>
                            <tr>
                                <td><?php echo get_phrase('Fuel'); ?></td>
                                <td><b><?=$row['fuel']?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['modelName'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('Model Name'); ?></td>
                                <td><b><?php echo $row['modelName']; ?></b></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?php echo get_phrase('manufacturer'); ?></td>
                            <td><b><?php echo $row['manufacturer']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Registering Authority'); ?></td>
                            <td><b><?php echo $row['registeringAuthority']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Owner Name'); ?></td>
                            <td><b><?php echo $row['ownerName']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Registration Date'); ?></td>
                            <td><b><?php echo $row['registrationDate']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('REGN EXP'); ?></td>
                            <td><b><?php echo $row['REGNEXP']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('MV Tax Date EXP'); ?></td>
                            <td><b><?php echo $row['MVTaxDate']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Insurance Company'); ?></td>
                            <td><b><?php echo $row['insuranceCompany']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Policy No'); ?></td>
                            <td><b><?php echo $row['policyNo']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('validity'); ?></td>
                            <td><b><?php echo $row['validity']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('created On'); ?></td>
                            <td><b><?php echo $row['createdOn']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('updated On'); ?></td>
                            <td><b><?php echo $row['updatedOn']; ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>		
        </section>
    </div>
<?php endforeach; ?>