   //Сия чудная функция получает Value Инпутов с типом Чекид
    function GetDataCheked(){
        var CheckedArray = [];
        $('input[name="NCheked"]:checked').each(function() {
            CheckedArray.push($(this).val());
        }); 
        return CheckedArray;
    }

//function CreateButton(module, action){
//    $.ajax({  
//                    url: "?option="+module,
//                    cache: false,
//                    data: {"Act" : action},
//                    success: function(html){  
//                        $(".MainContent").html(html);  
//                    }  
//                });  
//}

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

//$('.CreateForm').submit(function(e){
////отменяем стандартное действие при отправке формы
////alert(module);
//e.preventDefault();
////берем из формы метод передачи данных
//var m_method=$(this).attr('method');
////получаем адрес скрипта на сервере, куда нужно отправить форму
//var m_action=$(this).attr('action');
////получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
////то есть в стандартном формате передачи данных формы
//var m_data=$(this).serialize();
//
//$.ajax({
//type: m_method,
//url: "?option="+module,
////url: "?option="+m_action,
//data: m_data+"&Action=Create",
//success: function(result){
//$("#dialog").dialog('destroy');
//$('.MainContent').html(result);
//
//}
//});
//});




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
  
  function modalwindow(){
      
        
         $("#dialog").dialog(
            {modal: true,
            resizable:false,
            minWidth: 700,
            position: ['center','center'],
            //position: ['top','center'],
            //minHeight: 300
            close: function(event, ui) {
               $('div.ui-dialog').remove();
               $('div.ui-widget-overlay').remove();
               $("#dialog").remove();
               $( this ).removeClass("ui-widget-overlay ui-front");
            }
            }
             
            );
    }
  
  function UpdContentMainTable()  
            {  
                $.ajax({  
                    url: "?option="+module,
                    cache: false,
                    data: {"Act" : "UCMT"},
                    success: function(html){  
                        $("#ContentMainTable").html(html);
                    }  
                });  
            }  
            
   
    function UpdMainContent(module)  
            { 
                $.ajax({  
                    url: "?option="+module,
                    cache: false,
                    data: {"Act" : "UMC"},
                    success: function(html){  
                        $(".MainContent").html(html);
                           //console.log(steck);
                    }  
                });  
            }  
            
     

function obrabotka(){
$('.UIForm').unbind('submit');
$('.UIForm').submit(function(e){
//отменяем стандартное действие при отправке формы
//alert(module);
e.preventDefault();
//берем из формы метод передачи данных
var m_method=$(this).attr('method');
//получаем адрес скрипта на сервере, куда нужно отправить форму
var m_action=$(this).attr('action');
//получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
//то есть в стандартном формате передачи данных формы
var m_data=$(this).serialize();
//alert(m_action+" "+module);

    $.ajax({
type: m_method,
url: "?option="+module,
//url: "?option="+m_action,
data: m_data+"&Action="+m_action,
success: function(result){
//$("#dialog").dialog('destroy');
$('div.ui-dialog').remove();
$('div.ui-widget-overlay').remove();
$("#dialog").remove();
$('.MainContent').html(result);

}
});
});
    
}

//function Back(module){
//      location.replace("/");
//      UpdMainContent(module);
//}

//$(document).on'click','input[type="submit"]',function(){
 var requestSent = false;
    $(document).ready(function() {
        
$('.NoPrint').on('click', function(e){
    //$('.NoPrint').click(function(e){
      e.preventDefault();
      var  Module = $(this).attr('Module');
      UpdMainContent(Module);
    });
    
    $('.PrintRecord').on('click', function(e){
    //$('.NoPrint').click(function(e){
    $(".PrintRecord").unbind('click');
      e.preventDefault();
      var Record=$(this).attr('RecId');
      //alert(module);
      $.ajax({
                    url: "?option="+module,
                    cache: false,
                    data: {"Action" : "PrintForm",
                           "RecordId" : Record,
                    },
                    success: function(html){
                        $(".MainContent").html(html);
                                //html(html);  
                    }  
                });  
      
      return false;
//      var  Module = $(this).attr('Module');
//      UpdMainContent(Module);
    });
        
        
$('.CopyRecord').click(function(e){
     $(".CopyRecord").unbind('click');
    //e.preventDefault();
    //var Record=$(this).attr('RecId');
    var Record=$(this).parent().attr('RecId');
    
    //var Module=$(this).attr('Module');
    //var Table=$(this).attr('Table');
    //alert(Record+" "+Module);
            $.ajax({
                    url: "?option="+module,
                    cache: false,
                    data: {"Action" : "CopyRecord",
                           "RecordId" : Record
                           //"Table" : Table
                    },
                    success: function(html){
                        $(".MainContent").append(html);
                        modalwindow();
                        obrabotka();
                                //html(html);  
                    }  
                });  
    
    
});

$('.EditRecord').click(function(e){
    //e.preventDefault();
    $(".EditRecord").unbind('click');
    var Record=$(this).parent().attr('RecId');
//    var Record=$(this).attr('RecId');
//    var Module=$(this).attr('Module');
//    var Table=$(this).attr('Table');
    //alert(Record+" "+Module);
            $.ajax({
                    url: "?option="+module,
                    cache: false,
                    data: {"Action" : "EditRecord",
                           "RecordId" : Record
                          // "Table" : Table
                    },
                    success: function(html){
                        $(".MainContent").append(html);
                        modalwindow();
                        obrabotka();
                                //html(html);  
                    }  
                });  
    
    
});

$('.ButtonActionAjax').click(function(){
    //e.preventDefault();
    var Action=$(this).attr('Action');
    //var Module=$(this).attr('Module');
    //var Table=$(this).attr('Table');
    //alert(Action+" "+module);
            $.ajax({
                    url: "?option="+module,
                    cache: false,
                    data: {"Action" : Action, sl: GetDataCheked()
                    },
                    success: function(html){
                        $(".MainContent").append(html);
                        modalwindow();
                        obrabotka();
                                //html(html);  
                    }  
                });  
    
    
});

//$('input[type="submit"]').submit(function(e){
////$('.CreateForm').submit(function(e){
////отменяем стандартное действие при отправке формы
//alert(module);
//e.preventDefault();
////берем из формы метод передачи данных
//var m_method=$(this).attr('method');
////получаем адрес скрипта на сервере, куда нужно отправить форму
//var m_action=$(this).attr('action');
////получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
////то есть в стандартном формате передачи данных формы
//var m_data=$(this).serialize();
//
//$.ajax({
//type: m_method,
////url: "?option="+module,
//url: "?option="+m_action,
//data: m_data+"&Action=Create",
//success: function(result){
//$('.MainContent').html(result);
////$("#dialog").dialog('destroy');
//}
//});
//});
      
      
      
        //Есть проблема наростание(в геометр прогрессии) кол-ва запросов Ажакс
            //Авто апдейт страниц но пробелма выше
           // setInterval('UpdContentMainTable()',20000);
            //
//        $(".menu").each(function() {
//        var menu = this;
//        $(menu).find('a').click(function() {
//           сonsole.log('working');
//        });
//    });
        
        
    //$("body").on("click",".menu li a",function(event){ 
    
    //$("a[href^='#']").unbind('click');
    $(".menu li a").one("click",function(event){
    $(".menu li a").unbind('click'); //"Убиваем" размножение AJAX запроса связано с тем, что
                                    //$(document).ready выполняется при загрузке ажаксом и этим снимаем клик
    event.preventDefault();
    var  toLoad = $(this).attr('href').substr(9,$(this).attr('href').length);
    UpdMainContent(toLoad);
           
    return false;
    });
        
        
        
        
        
           
    
$('.ui-button-text').click(function(){
    console.log("?option="+opti);
     location.replace("?option="+opti);
    });
    
    //Щелкнули по крестику в диалоге модальном! Похронили на всегда
    
    $('.ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close').click(function(){
         //xhr.abort();
        $('div.ui-widget-overlay ui-front').remove(); 
        //$('div.ui-widget-overlay').remove();
        $('div.ui-dialog').remove();
        $("#dialog").remove();
//        $("#dialog").dialog('destroy');
//        });
//    $('#dialog').bind('dialogclose', function(event) {
//    //$.xhrPool.abortAll();
//    $("#dialog").remove();
    
    });
    
//    $('#tabr1').click(function(){
//      UpdContentMainTable();
//    });
    
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
        
        //$("body").on("click","#Create",function(){
//alert(1);
//})
            
//        $('body').on('click' 
        $('#Create').unbind('click');
        $('#Create').click(function(){   
            $.ajax({
                    url: "?option="+opti,
                    cache: false,
                    data: {"Act" : "Create"},
                    success: function(html){
                        $(".MainContent").append(html);
                        modalwindow();
                        obrabotka();
                                //html(html);  
                    }  
                }); 
              //  xhr.abort();
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
                        $("body").html(html);
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
                    url: "?option="+module,
                    cache: false,
                    data: {"Act" : "Action1", sl: GetDataCheked()},
                    success: function(html){  
                        $(".MainContent").append(html);
                        modalwindow();
                        obrabotka();
                        UpdMainContent(module);
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
                    url: "?option="+module,
                    cache: false,
                    data: {"Act" : "Action2", sl: GetDataCheked()},
                    success: function(html){ 
                        UpdMainContent(module);
                        //$("body").append(html);
                                //html(html);  
                    }  
                });  
            });  

            $('#ObrabotkaEnd').click(function(){  
            //myfunc();
                $.ajax({
                    //type: "POST",
                    //url: "?option=viewJurEsia&Act=Create", 
                    //url: "?option=viewJurEsia",  
                    url: "?option="+module,
                    cache: false,
                    data: {"Action" : "OBE", sl: GetDataCheked()},
                    success: function(html){ 
                        UpdMainContent(module);
                        //$("body").append(html);
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
                    url: "?option="+module,
                    cache: false,
                    data: {"Action" : "PrintM", sl: GetDataCheked()},
                    success: function(data){  
                        $(".MainContent").html(data);
                        //$("body").html(data);
                    }  
                }); 
               
            });  
            
   
          



     });
        