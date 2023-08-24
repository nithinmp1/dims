            <div class="col-sm-3" style="width: 6%">
                <a href="#" class="profile-picture">
                    <img src="<?php echo $this->crud_model->get_image_url('customer', $customer_data['customer_id']); ?>" 
                         class="img-responsive img-circle" />
                </a>
            </div>

            <div class="col-sm-9">
                <ul class="profile-info-sections">
                    <li style="padding:0px; margin:0px;">
                        <div class="profile-name">
                            <h3>
                                <?php echo $this->db->get_where('customer', array('customer_id' => $customer_id))->row()->name;
                                 ?>                     
                            </h3>
                        </div>
                    </li>
                </ul>
            </div>