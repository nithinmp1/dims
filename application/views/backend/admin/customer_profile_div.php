<div class="profile-env">
        <header class="row">
            <?php $this->load->view('backend/admin/customer_profile_pic') ?>
        </header>

        <section class="profile-info-tabs">
            <div class="row">
                <div class="">
                    <br>
                    <table class="table table-bordered">
                        <?php
                         // echo "<pre>";print_r($customer_data);die;
                            foreach($customer_data as $studentK => $studentV){
                                if (
                                    (($studentV != '') === true) &&
                                    (!in_array($studentK,['customer_id', 'customer_code', 'sex', 'package_id','createdID']))
                                ){
                                    ?>
                                        <tr>
                                            <td><?php echo get_phrase($studentK); ?></td>
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
                                            }else if ($studentK === 'stream_id'){
                                                $stream = $this->db->get_where('stream',['stream_id' => $studentV])->row();
                                                if( isset($stream->name)){
                                                    echo $stream->name;
                                                }
                                            } else if ($studentK === 'blood_group'){
                                                $blood_group = $this->db->get_where('blood_group',['blood_id ' => $studentV])->row();
                                                if( isset($blood_group->name)){
                                                    echo $blood_group->name;
                                                }
                                            }  else if ($studentK === 'branch_id'){
                                                $branch = $this->db->get_where('branch',['branch_id ' => $studentV])->row();
                                                if( isset($branch->name)){
                                                    echo $branch->name;
                                                }
                                            } else {
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