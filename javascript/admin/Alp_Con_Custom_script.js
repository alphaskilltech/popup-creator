
$( document ).ready(function() {	
    $("#alpBackgroundColorSet"). find("input[type='color']").val("#ffffff");

});
$(window).ready(function ()  {

   $("#js-popup-only-once").change(function(){        
       if($(this).is(":checked")){
           $("#js-popup-only-once-content").find("input[type='number']").val("10");
           $("#js-popup-only-once-content").show();
       } else{       
         $("#js-popup-only-once-content").find("input[type='number']").val("");
             $("#js-popup-only-once-content").hide(); 
       }
   });
        
    var repetitivePopup = $('.before-scroling-percent').val(); 
        if(repetitivePopup == ''){
             $("#js-popup-only-once-content").hide();
            } else {
             $("#js-popup-only-once-content").show();
        }
   // intervel time
    $("#js-popup-delay").change(function(){        
       if($(this).is(":checked")){        
           $("#popup-delay-content").find("input[type='number']").val("10");
           $("#popup-delay-content").show();
       } else{       
            $("#popup-delay-content").find("input[type='number']").val("");
            $("#popup-delay-content").hide(); 
       }
        });		 
        var interveltime = $('.popup-delay-value').val(); 
            if(interveltime == ''){
           $("#popup-delay-content").hide();
             } else {
          $("#popup-delay-content").show();
       }
   // close popup button delay
   // $("#close_button_dealy_value").find("input[type='number']").val("3");
   // $("#close_button_dealy_value").show();

   $("#close_button_delay").change(function(){ 
       
       if($(this).is(":checked"))
       {
           $("#close_button_dealy_value").find("input[type='number']").val('');
           $("#close_button_dealy_value").show();
       }
       else{
         $("#close_button_dealy_value").find("input[type='number']").val("");
             $("#close_button_dealy_value").hide(); 
            }
        });		 
        var interveltime = $('.delay_button_value').val(); 
            if(interveltime == ''){
           $("#close_button_dealy_value").hide();
             } else {
          $("#close_button_dealy_value").show();
       }
       // Events on Popup

       // Pro Features
       
       // Date Range 
      $('#start_date').datetimepicker({
          format: 'YYYY/MM/DD',
           minDate: new Date(),
          useCurrent: true
        });
     $('#end_date').datetimepicker({
          format: 'YYYY/MM/DD',
         });   
               
       var From_dates = $("#From_date").val();
       var To_dates = $("#To_date").val();       
       if (From_dates != '' && To_dates !='' ){
           $("#popup_date_filed").find("input[type='text']");
           $("#popup_date_filed").show();         
       }
       if(From_dates == '' && To_dates =='' ){
           $("#popup_date_filed").find("input[type='text']");            
           $("#popup_date_filed").hide();         
       }
       $("#Date_Range_Change").change(function(){        
       if($(this).is(":checked"))
       {
           $("#popup_date_filed").find("input[type='text']");
           $("#popup_date_filed").show();              
       }
       else{
           $("#popup_date_filed").find("input[type='text']").val("");
           $("#popup_date_filed").hide();         
            }
        });  
       //  Schedule Date Time 
        $('#datetimepicker1').datetimepicker({
           format: 'YYYY/MM/DD'
           // format: 'YYYY/MM/DD h:mm A'
        });
        
        var select_date = $("#select_date").val();
        if (select_date != ''){
           $("#popup_schedule_date").find("input[type='text']");
           $("#popup_schedule_date").show(); 
        }else{
           $("#popup_schedule_date").find("input[type='text']");
           $("#popup_schedule_date").hide();
        }
      
        $("#Schedule_PopUp").change(function(){        
       if($(this).is(":checked"))
       {
           $("#popup_schedule_date").find("input[type='text']");
           $("#popup_schedule_date").show();              
       }
       else{
           $("#popup_schedule_date").find("input[type='text']").val("");
           $("#popup_schedule_date").hide();         
            }
        }); 

        //  MobileDevice Options enable device or disable device
        $("#Disable_toggle").click(function(){
           $("#Enable_toggle").attr('checked', false);
         });
         $("#Enable_toggle").click(function(){
           $("#Disable_toggle").attr('checked', false);
         });
         //  Scrolling  Options while scrolling or disable scrolling
         $("#WhileSrolling").click(function(){
            $("#DisableScrolling").attr('checked', false);
         });
         $("#DisableScrolling").click(function(){
           $("#WhileSrolling").attr('checked', false);
         }); 
        
       // inactivity time
       $("#inactive").change(function(){        
       if($(this).is(":checked"))
       {
           $("#popup-inactivitytime").find("input[type='number']").val("10");
           $("#popup-inactivitytime").show();
       }
       else{
         $("#popup-inactivitytime").find("input[type='number']").val("");
             $("#popup-inactivitytime").hide(); 
            }
        });		 
        var interveltime = $('.popup-inactivity-value').val(); 
            if(interveltime == ''){
           $("#popup-inactivitytime").hide();
             } else {
          $("#popup-inactivitytime").show();
       }
       $('#multi-select-page').multiselect();

       // close popup
      $("#js-auto-close").change(function(){        
           if($(this).is(":checked"))
              {
                 $("#popup_close_time").val("10");
              }
             else{
                $("#popup_close_time").val("");
             }
       });
          
       // SelectePages          
          $("#select_all_page").change(function() {
             if($(this).is(":checked"))
               $("#popup_select_page").hide();
          });      
          $("#select_custom_page").change(function() {
           if($(this).is(":checked"))
               $("#popup_select_page").show();
          });     
        
           if($("#select_custom_page").is(":checked")){
               $("#popup_select_page").show();}
               
               $("#multi-select-page").change(function(){                
               var id = $("#multi-select-page").val(); 
               $('#showcustoid').val(id);                  
               });               
               var hidValue = $("#showcustoid").val();
               

               if(hidValue != ''){
               var selectedOptions = hidValue.split(",");
               for(var i in selectedOptions) {
               var optionVal = selectedOptions[i];
               $("#multi-select-page").find("option[value="+optionVal+"]").prop("selected", "selected");
                   }     
                   $("#multi-select-page").multiselect('refresh'); 
                }  

               // SelectePosts                                                                     
               $("#select_all_post").change(function() {                  
                   if($(this).is(":checked"))
                       $("#popup_select_post").hide();
               });      

               $("#select_custom_post").change(function() {
                   if($(this).is(":checked"))
                       $("#popup_select_post").show();
               });  
               if($("#select_all_post").is(":checked")){
                   $("#popup_select_post").hide();                   
                   }                    
                   $("#multi-select-post").change(function(){ 
                   var postdata = $("#multi-select-post").val();
                   $('#showcustpostid').val(postdata);  
                   // alert("ok");
                   }); 
               
               var postid = $("#showcustpostid").val();
               if(postid ==  ''){
                   postid = "000";
               }
               // if(postid != ''){
               var selectedid = postid.split(",");
               for(var i in selectedid) {
               var optionVal = selectedid[i];
               $("#multi-select-post").find("option[value="+optionVal+"]").prop("selected", "selected");
                   }
               $("#multi-select-post").multiselect('refresh'); 
               // }else{
                   // alert("fgh");
               // }
       });