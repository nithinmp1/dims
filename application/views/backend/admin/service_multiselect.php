    <div class="form-group multiselect-div">
      <label class="col-sm-3 control-label"><?php echo get_phrase('select_service_article');?></label>
      <div class="col-sm-5">
          <select name="service" class="form-control ">

          <?php
          $where = $this->crud_model->setSplitWhere('customer_service');
          if (isset($stream_id) === false) {
            $firstStream = $this->crud_model->firstStream();
            $stream_id = $firstStream['stream_id'];
          }
          $where['stream_id'] = $stream_id;  
          $package = $this->db->get_where('customer_service',$where)->result_array();
          if(!empty($package)) {
          foreach($package as $key => $val) { 
          ?>
            <option value="<?=$val['customer_service_id']?>"><?=$val['name']?></option>
          <?php
          }
          } else{ ?>
            <option >No Service Found</option>
          <?php
          }
          ?>
        </select>
      </div>
    </div>
    <script type="text/javascript">
      $(".selectboxit").change(function(){
        let value = $(this).val();
        $.post("<?=site_url('index.php?admin/multiselect/service')?>",
          {
            "stream_id": value
          },
          function(data){
            $(".multiselect-div").html(data);
            $(".multiselect-div").show();
            // MultiselectDropdown(window.MultiselectDropdownOptions);
          });
      });
    </script>