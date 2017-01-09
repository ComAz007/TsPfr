   //Сия чудная функция получает Value Инпутов с типом Чекид
    function DataChekedSet(){
    //alert("XeraSebe");
     var arr = [];
 //$('input[name="NCheked"]').click(function(){
   $('input[name="NCheked"]:checked').each(function() {
        arr.push($(this).val());
    }); 
   
                //сonsole.log(arr);
return arr;
 //      });
    //document.getElementById('PathFileCL').value=peremen;
    }

//var countChecked = function() {
//  var n = $( "input:checked" ).length;
//  $( "div" ).text( n + (n === 1 ? " is" : " are") + " checked!" );
//};
//countChecked();
//
//$( "input[type=checkbox]" ).on( "click", countChecked );
//
// $('input:cCheked:checked').each(function(){
//alert($(this).val());
//});

//var dann =  $($(":checkbox:checked"), function(el){ return $(el).val(); });
//alert(dann);



//var flag = 0;
//$('#iCheked :checkbox').click(clickCheckbox);
// 
// 
// function clickCheckbox(){
//      var num = new Array(check_ch);
// 
//   var j = 0;
//   $('#iCheked :checkbox:checked').each(function() {
//       num[j] = $(this).attr('value');
//       j++;
//   });
//  
//    if(num.length > 1){
//           flag  = 1; 
//    }else{
//           flag =  0;  
//   }
// }



function SendGet(Files,PathTmp) {
	//отправляю GET запрос и получаю ответ

$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'http://localhost:3573/CS-UPD/initModule',//url адрес файла обработчика
		data:{'transDir':'',
                      'keyDir':'',
                      'password':'',
                      'flag':'0',
                      'serialNumbers':'',
                      'serialsNumbersCA':'',
                      'keyUsage':'',
                      'extension':'.p7s'
                      },//параметры запроса
		response:'xml',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('result',$('result').innerHTML+'<br />'+data);
		}
	});

for(var i=2; i<Files.length; i++) {
  

	$.ajax({
		type:'get',//тип запроса: get,post либо head
		url:'http://localhost:3573/CS-UPD/signFile',//url адрес файла обработчика
                //data:{'fileName':"W:/_elArx/_ts/"+path[i],'isSaveEP':'true'},//параметры запроса
		data:{'fileName':PathTmp+Files[i],'isSaveEP':'true'},//параметры запроса
		response:'xml',//тип возвращаемого ответа text либо xml
		success:function (data) {//возвращаемый результат от сервера
			$('result',$('result').innerHTML+'<br />'+data);
		}
	});
  }
}

  $(function() {


    function log( arr ) {
        $('[name="KodRegion"]').val(arr[2]);
        $('[name="KodUrL"]').val(arr[3]);
        $('[name="KodUPFR"]').val(arr[4]);
    }
 
    $( ".searchUPFR" ).autocomplete({
        
    source: function( request, response ) {
        $.ajax({
               url: "?option=CreateZapros",
               dataType: "json",
          data: {
            SearchSTR: request.term
          },
          success: function( data ) {
            response(data);
              
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
          var arr = ui.item.label.split('|');
          log(arr);
      },
      open: function() {
        $(this).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
  });
  

 var requestSent = false;
    $(document).ready(function() {	
            $("#dialog").dialog(
            {modal:true,
            resizable:false,
            minWidth: 700,
            //minHeight: 300
            close: function(event, ui) {}
            }
             
            );
$('.ui-button-text').click(function(){
    console.log("?option="+opti);
     location.replace("?option="+opti);
    });


        $('#CreateBut').click(function(){
           // if(!requestSent) {
	      requestSent = true;
                $.ajax({  
                    url: "?option=viewJurEsia&Act=Update",  
                    cache: false,
                    success: function(html){  
                        $("#content").html(html);  
                    }
//                    complete: function() {
//                     location.replace("?option=viewJurEsia");
//	  //           requestSent = false;
//	         }
                });  
            //}
            });  
            
            
            
        $('#Create').click(function(){  
//            myfunc();
                $.ajax({
                    //type: "POST",
                    //url: "?option=viewJurEsia&Act=Create", 
                    
                    //url: "?option=viewJurEsia",  
                    url: "?option="+opti,
                    cache: false,
                    data: {"Act" : "Create"},
                    success: function(html){  
                        $("body").append(html);
                                //html(html);  
                    }  
                });  
            });  
 
                $('#Historym').click(function(){  
//            myfunc();
                $.ajax({
                    //type: "POST",
                    //url: "?option=viewJurEsia&Act=Create", 
                    
                    //url: "?option=viewJurEsia",  
                    url: "?option="+opti,
                    cache: false,
                    data: {"Act" : "Historym"},
                    success: function(html){  
                        $("body").append(html);
                                //html(html);  
                    }  
                });  
            }); 





            $('#Action1').click(function(){  
            //myfunc();
                $.ajax({
                    //type: "POST",
                    //url: "?option=viewJurEsia&Act=Create", 
                    //url: "?option=viewJurEsia",  
                    url: "?option="+opti,
                    cache: false,
                    data: {"Act" : "Action1", sl: DataChekedSet()},
                    success: function(html){  
                        $("body").append(html);
                                //html(html);  
                    }  
                });  
            });  

            $('#Action2').click(function(){  
            //myfunc();
                $.ajax({
                    //type: "POST",
                    //url: "?option=viewJurEsia&Act=Create", 
                    //url: "?option=viewJurEsia",  
                    url: "?option="+opti,
                    cache: false,
                    data: {"Act" : "Action2", sl: DataChekedSet()},
                    success: function(html){  
                        $("body").append(html);
                                //html(html);  
                    }  
                });  
            });  


            
            $('#PrintM').click(function(){  
            //myfunc();
                $.ajax({
                    //type: "POST",
                    //url: "?option=viewJurEsia&Act=Create", 
                    
                    //url: "?option=viewJurEsia",  
                    url: "?option="+opti,
                    cache: false,
                    data: {"Act" : "PrintM", sl: DataChekedSet()},
                    success: function(data){  
                        $("body").html(data);
                    }  
                }); 
               
            });  
            
   
          



     });
        