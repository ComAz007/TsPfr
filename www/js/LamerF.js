 //источник http://tazsingh.github.io/will_pickdate/
 //русский источникhttp://ittricks.ru/verstka/jquery/238
 //Begin функция для поля с календарем и временем
// $(function(){
//          $('#SetKalendar').will_pickdate({ 
//              timePicker: true, 
//              inputOutputFormat: 'Y-m-d H:i:s', 
//              format: 'm-d-Y H:i:s', 
//              startDay: 1, 
//              militaryTime: true, 
//              inputOutputFormat: 'U',
//              days: ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
//              months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май','Июнь','Июль', 'Август', 'Сентябрь', 'Октябрь','Ноябрь', 'Декабрь']
//     });
//      });
      
//          $(function(){ $('.SetKalendar').will_pickdate({ 
//              timePicker: true, 
//              inputOutputFormat: 'Y-m-d H:i:s', 
//              format: 'm-d-Y H:i:s', 
//              startDay: 1, 
//              militaryTime: true, 
//              //inputOutputFormat: 'U',
//              days: ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
//              months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май','Июнь','Июль', 'Август', 'Сентябрь', 'Октябрь','Ноябрь', 'Декабрь']
//     });});        
//END функция для поля с календарем и временем
$(function(){$('.KalDates').will_pickdate({ 
              timePicker: true, 
              inputOutputFormat: 'Y-m-d', 
              format: 'd-m-Y', 
              startDay: 1, 
              militaryTime: true, 
              timePicker: false,
              //inputOutputFormat: 'U',
              days: ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
              months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май','Июнь','Июль', 'Август', 'Сентябрь', 'Октябрь','Ноябрь', 'Декабрь']
     }); 
             //}
         
        //);

        //$(function(){
$('.KalDatesTimes').will_pickdate({ 
              timePicker: true, 
              inputOutputFormat: 'Y-m-d H:i:s', 
              format: 'm-d-Y H:i:s', 
              startDay: 1, 
              militaryTime: true, 
              //inputOutputFormat: 'U',
              days: ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
              months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май','Июнь','Июль', 'Август', 'Сентябрь', 'Октябрь','Ноябрь', 'Декабрь']
     }); });


//$(function(){
//
//    $('.sqlReq').autocomplete('mode=sql', {
//        width: 200,
//        max: 5
//    });
//
//});

