    <div class="form-group multiselect-div">
      <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('package');?></label>
      <div class="col-sm-5">
        <select class="form-control" name="package_id[]" id="field2" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
          <?php
          $where = $this->crud_model->setSplitWhere('package');
          if (isset($stream_id) === false) {
            $firstStream = $this->crud_model->firstStream();
            $stream_id = $firstStream['stream_id'];
          }
          $where['stream_id'] = $stream_id;
          $package = $this->db->get_where('package',$where)->result_array();
          // echo "<pre>";print_r($package);die;  
          foreach($package as $key => $val) { 
          ?>
              <option value="<?=$val['package_id']?>"><?=$val['name']?></option>
          <?php
          }
          ?>
        </select>
      </div>
    </div>
    <script type="text/javascript">
      $(".selectboxit").change(function(){
        let value = $(this).val();
        $.post("<?=site_url('index.php?admin/multiselect')?>",
          {
            "stream_id": value
          },
          function(data){
            $(".multiselect-div").html(data);
            MultiselectDropdown(window.MultiselectDropdownOptions);
          });
      });
    </script>