                <div class="box-content">
                	<?php echo form_open(base_url() . 'index.php?admin/access_management/do_update/'.$data['id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" value="<?=$data['name']?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo get_phrase('access');?></label>
                                <div class="col-sm-6">
                                
                                  <?php 
                                  $accessJson = $this->crud_model->accessJson();
                                  $access = json_decode($accessJson,true);
                                  $incl = json_decode($data['access'],true);
                                  foreach ($access as $key => $value) {
                                   ?>
                                    <div id="faq" role="tablist" aria-multiselectable="true">
                                       <div class="panel panel-default">
                                          <div class="panel-heading" role="tab" id="questionOne">
                                             <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#faq" href="#<?=$key?>" aria-expanded="false" aria-controls="<?=$key?>">
                                              <label class="form-check-label" for="flexCheckIndeterminate">
                                                <?=get_phrase($key)?>
                                              </label>
                                                </a>
                                             </h5>
                                          </div>
                                          <div id="<?=$key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="questionOne">
                                             <div class="panel-body">
                                                <?php 
                                                foreach ($value as $val) { ?>
                                                    <input class="form-check-input" type="checkbox" value="<?=$val?>" id="flexCheckIndeterminate" name="access[<?=$key?>][]"
                                                    <?=(in_array($val, $incl[$key]))?'checked':''?>
                                                    >
                                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                                        <?=get_phrase($val)?>
                                                    </label>
                                                    <br/>
                                                <?php }
                                                ?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                  <?php }
                                  ?>  
                            </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_access');?></button>
                              </div>
							</div>
                    </form>                
                </div>