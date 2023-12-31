<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_instructor'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/customer/do_update/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'),['param2' => $param2]);

                $customer = $this->db->get_where('customer',['customer_id' => $param2])->row();
                // echo "<pre>";print_r($customer);die;

                ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                    
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$customer->name?>" autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                    
                    <div class="col-sm-5">
                        <input type="text" class="form-control datepicker" name="birthday" value="<?=$customer->birthday?>" data-start-view="2">
                    </div> 
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('blood_group');?></label>
                    
                    <div class="col-sm-5">
                        <select name="blood_group" class="form-control selectboxit">
                          <option value=""><?php echo get_phrase('select');?></option>
                          <?php 
                            $bloodGroups = $this->db->get('blood_group')->result();
                            foreach($bloodGroups as $key => $val){ 
                          ?>
                          <option value="<?=$val->blood_id?>"
                            <?=($val->blood_id == $customer->blood_group)?'selected':'' ?>
                            ><?=$val->name?></option>
                          <?php } ?>
                      </select>
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                    
                    <div class="col-sm-5">
                        <select name="sex" class="form-control selectboxit">
                          <option value=""><?php echo get_phrase('select');?></option>
                          <option value="male" <?=('male' == $customer->sex)?'selected':''?>><?php echo get_phrase('male');?></option>
                          <option value="female" <?=('female' == $customer->sex)?'selected':''?>><?php echo get_phrase('female');?></option>
                          <option value="other" <?=('other' == $customer->sex)?'selected':''?>><?php echo get_phrase('other');?></option>
                      </select>
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                    
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="address" value="<?=$customer->address?>" >
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                    
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="phone" value="<?=$customer->phone?>" >
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('whatsapp');?></label>
                    
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="whatsapp" value="<?=$customer->whatsapp?>" >
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email" value="<?=$customer->email?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                    
                    <div class="col-sm-5">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                <img src="http://placehold.it/200x200" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="userfile" accept="image/*">
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_customer'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>