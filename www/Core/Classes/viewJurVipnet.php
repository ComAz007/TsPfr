﻿<?php
    
//http://blog.sklazer.com/865.html почитать для просветления!
//DYB

class viewJurVipnet extends Jurnals {
    
    public function __construct() {
        $this->class='viewJurVipnet';
        $this->table='jurvipnetzapros';
        $this->StatusEnd=7;
        $this->TableHead=Array(
        "Napravl"=>"Направ ление",
        "SpNap"=>"Способ  запроса",
        "Id"=>"Рег №",
	"DataReg"=>"Дата",
	"KodReg"=>"Регион",
	"KodUrLic"=>"Юр Лицо",
        "KodUpfr"=>"УПФР",
        "FIOZL"=>"На кого запрос",
        "IdUserCreate"=>"Отправил/ Принял",
        "TypeZapros"=>"Тип запроса",
        "TypeDeistv"=>"Уточнение",
        "ZR"=>"Заблаговременный",
        "Otvetstv"=>"ответственный",
        "Povtor"=>"Повтор",
        "DatePovtor"=>"Дата Повтора",
        "DateOtveta"=>"Дата Ответа");
         //``, ``, ``, ``, ``, ``, `TypeZaprosId`, ``, `FileZapr`, `PathFileToArchiv`, ``, ``, ``, `FileOtv`, `ZR`, ``, ``, `SpNap`, `Kontrol`
        
        
        
        parent::__construct();
        //$this->MainContent();
    }


    function sqldate2time($date) {
        list($y, $m, $d) = explode('-', $date);
        $res = mktime(3,0,0,$m,$d,$y);
        return($res);
    }//function
     
    //Добавляем к дате указанное кол-во дней
    function add_days($date, $days = 15) {
        $t = $this->sqldate2time($date);
        $t += (86400*$days);
     
        return(date('Y-m-d', $t));
    }//function
    
    private function Table($Res,$Regim=0){
    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
     $str='';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
	//echo $col;
	$str=$str. '<thead><tr class="alt first last">';
        $str=$str. '<th value="Napr" rel="13">Направ ление</th>';
        $str=$str. '<th value="SposNapr" rel="15">Способ  запроса</th>';
        $str=$str. '<th value="SN" rel="0">Рег №</th>';
	$str=$str. '<th value="DC" rel="1">Дата</th>';
	$str=$str. '<th value="R" rel="2">Регион</th>';
	$str=$str. '<th value="UL" rel="3">Юр Лицо</th>';
        $str=$str. '<th value="UP" rel="4">УПФР</th>';
        $str=$str. '<th value="FZL" rel="5">На кого запрос </th>';
        $str=$str. '<th value="cr" rel="6">Отправил/ Принял</th>';
        $str=$str. '<th value="TZ" rel="7">Тип запроса</th>';
        $str=$str. '<th value="TZU" rel="7">Уточнение</th>';
        $str=$str. '<th value="ZP" rel="9">Заблаговременный</th>';
        $str=$str. '<th value="ZP" rel="14">ответственный</th>';
        $str=$str. '<th value="Pv" rel="10">Повтор</th>';
        $str=$str. '<th value="Dpv" rel="11">Дата Повтора</th>';
        $str=$str. '<th value="DO" rel="12">Дата Ответа</th>';
        
        //echo '<th>Завершена</th>';
	$str=$str. '</thead></tr>';
	//echo '</thead>';
	//echo '<tbody>';
	$str=$str.'<tbody>';
        
        
        while($data = $Res->fetch_row()){ 
                $col--;
                //echo $COL.'</Br>';
                //echo $col.'</Br>';
                $D=date('Y-m-d');
                $D1=  $this->add_days($data['1']);
                If ($data['11']<>0) {
                $D2= $this->add_days($data['11']);}
                ELSE $D2=0;
               
                
                iF ($col1==1) {
                
                
                if ($data['16']==1 and $Regim==0){ //If kontrol=1 выделяем строку вот так
                $str=$str. '<tr class="alt" style="background: rgb(191, 215, 255) none repeat scroll 0% 0%;">';}
                else {
                        If ($D>$D1 and $data['11']==0 and $Regim==0) //если не пришел ответ в течении 15 дней
                            {$str=$str. '<tr class="alt" style="background: rgb(176, 63, 63) none repeat scroll 0% 0%;">';}
                        Else
                            {
                            If ($D2<$D and $data['11']<>0 and $Regim==0) //если после повтора прошло 15 дней
                            {$str=$str. '<tr class="alt" style="background: rgb(170, 176, 219) none repeat scroll 0% 0%;">';}
                            else{
                                If ($D2>$D and $data['11']<>0 and $Regim==0)  //если повтор
                            {$str=$str. '<tr class="alt" style="background: rgb(255, 248, 169) none repeat scroll 0% 0%;">';}
                            else{
                             $str=$str. '<tr class="alt">';}
                            }
                   
                            
                } }$col1--;}
                Else
                {
                    
                    if ($data['16']==1 and $Regim==0){ //If kontrol=1 выделяем строку вот так
                $str=$str. '<tr class="" style="background: rgb(191, 215, 255) none repeat scroll 0% 0%;">';}
                else {
                        If ($D>$D1 and $data['11']==0 and $Regim==0) //если не пришел ответ в течении 15 дней
                            {$str=$str. '<tr class=""style="background: rgb(176, 63, 63) none repeat scroll 0% 0%;">';}
                        Else
                            {
                            If ($D2<$D and $data['11']<>0 and $Regim==0) //если после повтора прошло 15 дней
                            {$str=$str. '<tr class="" style="background: rgb(170, 176, 219) none repeat scroll 0% 0%;">';}
                            else{
                                If ($D2>$D and $data['11']<>0 and $Regim==0)  //если повтор
                            {$str=$str. '<tr class="" style="background: rgb(255, 248, 169) none repeat scroll 0% 0%;">';}
                            else{
                             $str=$str. '<tr class="">';}
                            }
                   
                
                } }$col1++;};
                
                
                //Формирование ВХДИ-ИСХД
                $Type=$this->getTypeZ($data['13']);
                $str=$str. '<td value="'.$Type.'">' .$Type.'</td> ';
                
                //Формирование ВипНет-ПОЧТА
                $str=$str. '<td value="'.$this->getTypeZ4($data['15']).'" >' . $this->getTypeZ4($data['15']) . '</td>'; 
                
                //Начали формировать функционал столбца Рег №
                $str=$str. '<td value="'.$data['0'].'">' .$data['0'];
                
                $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=history&id='.$data['0'].' ">История</a> ';
                //Если дата ответа не стоит то выводим такую возможность
                IF ($data['12']==0) {
                
                //Если ИСДИ
                If ($data['13']==0) {
                    
                    
                           $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=PovtISXD&id='.$data['0'].' ">Повтор</a> ';
                    
                    
                    
                    $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=3&id='.$data['0'].' ">Принять ответ</a>  ';
                    if ($data['16']==0){
                    $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=kontrols&id='.$data['0'].' ">КОНТРОЛЬ</a> ';
                    }
                }
                
                //Если ВХДИ
                If ($data['13']==1) {
                        
                        //Если ответственного нет то функционал доступен
                        IF ($data['14']==0) {
                        $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=2&id='.$data['0'].' ">Ответственный</a>  ';
                        };
                        
                        //$str=$str.'</BR> <a href="?option=viewJurVipnet&Act=Peres&id='.$data['0'].' ">Переслать</a>  ';   
                        $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=Peres&id='.$data['0'].' ">Переслать</a>  ';   
                        
                        //Если роль не 22 то доступна возможность ответа.
                        If ($_SESSION['Status']<>22){
                                $str=$str.'</BR> <a href="?option=viewJurVipnet&Act=Msg&id='.$data['0'].' ">Послать ответ</a>  ';
                            }
                        }                       
                }
                        $str=$str.'</td>';                
                
                //Окончили формировать функционал столбца Рег №
                        
                       
		$str=$str. '<td value="'.$data['1'].'" >' . date("d.m.Y",strtotime($data['1']))  . '</td>';
                $str=$str. '<td value="'.$data['2'].'" >' .$data['2']. '</td>';
                $str=$str. '<td value="'.$data['3'].'" >' . $data['3'] . '</td>';
                $str=$str. '<td value="'.$data['4'].'" >' . $data['4']. '</td>';
                $str=$str. '<td value="'.$data['5'].'" >' . $data['5'] . '</td>';
                $str=$str. '<td value="'.$this->GetUserName($data['6']).'" >' . $this->GetUserName($data['6']). '</td>';
                $str=$str. '<td value="'.$data['7'].'" >' . $data['7']. '</td>';
                $str=$str. '<td value="'.$this->getTypeZ3($data['8']).'" >' . $this->getTypeZ3($data['8']) . '</td>';
                $str=$str. '<td value="'.$data['9'].'" >' . $this->getYesNo($data['9']) . '</td>';
                $str=$str. '<td value="'.$data['14'].'" >'. $this->GetUserName( $data['14'] ). '</td>';
                $str=$str. '<td value="'.$data['10'].'" >' . $this->getYesNo($data['10']) . '</td>';
                $str=$str. '<td value="'.$data['11'].'" >' . $data['11'] . '</td>';
                $str=$str. '<td value="'.$data['12'].'" >' . date("d.m.Y",strtotime($data['12'])) . '</td>';
                $str=$str. '</tr>';
                 

	}
        
      $str=$str.'</tbody></table>';
        //return $str;
        echo $str;
        echo "<div class='col_2 visible center' style='height: 25px; background: rgb(176, 63, 63) none repeat scroll 0% 0%;'>С даты запроса >15 дней </div>";
        echo "<div class='col_2 visible center' style='height: 25px; background: rgb(255, 248, 169) none repeat scroll 0% 0%;'>Направлен повтор</div>";
        echo "<div class='col_2 visible center' style='height: 25px; background: rgb(170, 176, 219) none repeat scroll 0% 0%;'>С даты повтора >15 дней </div>";
        echo "<div class='col_2 visible center' style='height: 25px; background: rgb(191, 215, 255) none repeat scroll 0% 0%;'>На контроле</div>";
        
        
}

private function TableHistory($Res){
    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
     $str='';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
	//echo $col;
	$str=$str. '<thead><tr class="alt User">';
        $str=$str. '<th value="User" rel="1">Пользователь</th>';
        $str=$str. '<th value="Action" rel="2">Действие</th>';
        $str=$str. '<th value="DateTime" rel="3">Дата/время</th>';

        
        //echo '<th>Завершена</th>';
	$str=$str. '</thead></tr>';
	//echo '</thead>';
	//echo '<tbody>';
	$str=$str.'<tbody> <tr class="alt">';
        
        
        while($data = $Res->fetch_row()){ 
                
                $str=$str. '<td value="'.$this->GetUserName($data['0']).'" >' . $this->GetUserName($data['0']). '</td>';
		If($data['4']==6){
	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1'].': '. $this->GetUserName($data['3']). '</td>';}
		else
{
	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1']. '</td>';}

                $str=$str. '<td value="'.$data['2'].'" >' . $data['2'] . '</td>';
                
               
                $str=$str. '</tr>';
                 

	}
        
      $str=$str.'</tbody></table>';
        //return $str;
        echo $str;
}


//private function TablePrototype($Res,$Head,$AllEdit=1,$delete=0){
//    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
//     $str='';
//        // выводим на страницу сайта заголовки HTML-таблицы
//        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
//	//echo $col;
//	$str=$str. '<thead><tr class="alt User">';
//        
//        $ii=0;
//        foreach ( $Head as $value ) {
//        $str=$str. '<th value="User" rel="'.$ii.'">'.$value.'</th>';
//            $ii++;
//        }       
//        //echo '<th>Завершена</th>';
//	$str=$str. '</thead></tr>';
//	//echo '</thead>';
//	//echo '<tbody>';
//	$str=$str.'<tbody> <tr class="alt">';
//        
//        
//        while($data = $Res->fetch_row()){ 
//                
//                $str=$str. '<td value="'.GetUserName($data['0']).'" >' . GetUserName($data['0']). '</td>';
//		If($data['4']==6){
//	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1'].': '. GetUserName($data['3']). '</td>';}
//		else
//{
//	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1']. '</td>';}
//
//                $str=$str. '<td value="'.$data['2'].'" >' . $data['2'] . '</td>';
//                
//               
//                $str=$str. '</tr>';
//                 
//
//	}
//        
//      $str=$str.'</tbody></table>';
//        //return $str;
//        echo $str;
//}
//




    public function MainContent()
  {
        //ЖУДЧАЙШИЙ КАСТЫЛЬ!!! НУЖНО ПЕРЕДЕЛЫВАТЬ!!!
        echo "<script language='javascript'>var module='".$this->class."' </script>";
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        echo "<Center> <H6> Журнал регистрации направления поступления и исполнения запросов (Распоряжение Правления ПФР 463Р от 06.10.2015) </Center> </H6>";
//        echo '<ul class="tabs left">
//<li><a href="#tabr2">Запросы в обработке</a></li>';
//If ($_SESSION['Status']==20) 
//{
//echo '<li><a href="#tabr3">Запросы Отдела(в работе)</a></li>';
//}
//echo '<li><a href="#tabr1">Запросы обработанные</a></li>
//    </ul>';
//        Echo ('<div id="tabr2" class="tab-content">');
//        $IDU = $_SESSION['Id_user'];
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a id='Create' title='Создать запрос'>Создать запрос</a></div>";
        echo '<ul class="tabs left">
                <li><a href="#tabr1">Запросы в обработке</a></li>';
        echo '</ul>';
        Echo ('<div id="tabr1" class="tab-content">');
        echo $this->uiButtonAjax('Create', 'Создать запрос');
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet&Act=Create' title='Создать запрос'>Создать запрос</a></div>";
        
        //echo "<div class='col_3 visible center ' style='height: 25px;'> <a class='FormMini fancybox.ajax' href='?option=viewJurVipnet&Act=PZ'>Принять запрос</a></div>";
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet&Act=PZ'>Принять запрос</a></div>";
        echo $this->uiButtonActionAjax('PZ', 'Принять запрос');
       // echo $this->UIButtonAjax('PoslatOtvet', 'Послать ответ');
        echo $this->uiButtonActionAjax('Stat', 'Статистика');
        
        echo $this->uiButtonActionAjax('PoslatOtvet', 'Послать ответ');
        echo $this->uiButtonActionAjax('Otvetstv', 'Ответственный');
        echo $this->uiButtonActionAjax('Povtor', 'Повтор');
        echo $this->uiButtonActionAjax('Pereslat', 'Переслать');
        
        echo '<div id="ContentMainTable">';
       Echo $this->MainTabelA();
        echo '</div>';
//        If (($_SESSION['Admin']==1) or ($_SESSION['Status']==21))
//         {
//            $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap,Kontrol FROM jurvipnetzapros Where DateOtveta is NULL Order By Id DESC LIMIT 20";             
//         }
//         
//        If ($_SESSION['Status']==20) 
//         {
//           $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap,Kontrol FROM jurvipnetzapros Where ( (IdUserCreate='$IDU')  or  (Otvetstv='$IDU') ) and (DateOtveta is NULL)  Order By Id DESC LIMIT 40";             
//         }
//
//
//         If ($_SESSION['Status']==0)
//         {
//            $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where (IdUserCreate='$IDU') and (DateOtveta is NULL) Order By Id DESC LIMIT 20";
//         }
//
//         If ($_SESSION['Status']==22)
//         {
//            $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where (IdUserCreate='$IDU') and (Otvetstv=0) Order By Id DESC LIMIT 40"; 
//         }
//        $Res= $this->query($query);
//        
//        
//        If ($Res<>NULL){
//        echo '<div id="ContentMainTable">';
//        $this->Table($Res,0);
//        echo '</div>';
//         }
//   Echo '</div>';
//   
//   If ($_SESSION['Status']==20) 
//         {
//   Echo ('<div id="tabr3" class="tab-content">');
//$Otd=$_SESSION['IdOtd'];
//   $query="SELECT jurvipnetzapros.Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap,Kontrol FROM jurvipnetzapros, user Where  (DateOtveta is NULL)  and (user.Id_Otdel='$Otd') and (jurvipnetzapros.IdUserCreate=user.id) Order By Id DESC LIMIT 100";             
//   //$query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where DateOtveta is NOT NULL Order By DateOtveta DESC";             
//   $Res=$this->query($query);
//   
//    
//   $this->Table($Res,0);
//       
//   Echo '</div>';
//   }
//   
//   Echo ('<div id="tabr1" class="tab-content">');
//   $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where DateOtveta is NOT NULL Order By DateOtveta DESC LIMIT 100";             
//   $Res=$this->query($query);
//   $this->Table($Res,1);
//   Echo '</div>';
   
        
     
  }
  
    private function MainTabelA() {
          //If (($_SESSION['Admin']==1) or ($_SESSION['Status']==20)){
              return $this->TablePrototypeNew(array('Copy','Checked'),'status','status<7');
              //return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));
              //}
          //Else{return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));}
  }
  
  

//    public function __construct() {
//        include 'Header.php';
//        parent::__construct();
//        
//    }
    
    private function MainRekviz()
    {
        Echo '<p> Поиск УПФР по классификатору: </BR> <input name="SearchField" placeholder="Поиск УПФР по справочнику" style="width: 100%" class="searchUPFR"></p>';
        Echo '    <p>Код Региона: <input name="KodRegion" value="071" maxlength=3 size="5" placeholder="000" required>';
        Echo '    Код Юрлица: <input name="KodUrL" value="001"  maxlength=3 size="5" placeholder="000" required>'; 
        Echo '    Код У(О)ПФР: <input name="KodUPFR" value="001" maxlength=3 size="5" placeholder="000" required></p>';
    } 

    
    private function MainRekviz2()
    {
        return '<p> Поиск УПФР по классификатору: </BR> <input name="SearchField" placeholder="Поиск УПФР по справочнику" style="width: 100%" class="searchUPFR"></p>'
        .'    <p>Код Региона: <input name="KodRegion" value="071" maxlength=3 size="5" placeholder="000" required>'
        .'    Код Юрлица: <input name="KodUrL" value="001"  maxlength=3 size="5" placeholder="000" required>'
        .'    Код У(О)ПФР: <input name="KodUPFR" value="001" maxlength=3 size="5" placeholder="000" required></p>';
    } 
    
     private function MainRekviz1()
    {
        return '<p> Поиск УПФР по классификатору: </BR> <input name="SearchField" placeholder="Поиск УПФР по справочнику" style="width: 100%" class="searchUPFR"></p>'
        .'    <p>Код Региона: <input name="KodRegion" value="071" maxlength=3 size="5" placeholder="000" required>'
        .'    Код Юрлица: <input name="KodUrL" value="001"  maxlength=3 size="5" placeholder="000" required>'
        .'    Код У(О)ПФР: <input name="KodUPFR" value="001" maxlength=3 size="5" placeholder="000" required></p>';
    }
    
    
    private function getExtens($filename) {
        $path_info = pathinfo($filename);
        return $path_info;
    }

    private function Otvetstv() {
        $data='';
        //Echo '<div id="dialog" title="Назначение ответственного">';
        //Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $data .='<p>Назначить ответственного </p>';
        $data .=selected(SetSpisok("Select Id, FIO From User Where status=20"), 'UserId', 'Style="width:  200px"', 0);
        $data .="<p><input type='submit' name='OTV' value='Назначить ответственного' >";
        //Echo "</form>";
        //Echo '</div>';
        
        $this->CreateForm('Назначение ответственного',$data,'OtvetstvN');
    }
    
    private function Kontrols() {

        Echo '<div id="dialog" title="На контроль">';
        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        echo '<p>Причина постановки</p>';
        Echo '<textarea name="KontrolsText" cols="155" rows="5"></textarea>';
        Echo "<p><input type='submit' name='KontrolsBut' value='Поставить на контроль' >";
        Echo "</form>";
        Echo '</div>';
 
    }
     private function history($id) {

        Echo "<div id='dialog' title='История обработки Запроса # $id'>";
        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $query="SELECT Id_User,Action,Times,Id_rezerv,id_action FROM logged WHERE Id_Record=$id and Id_Razdela=1 order by Times desc";
        $Res= $this->query($query);
        $Head=array("Пользователь","Действие","Дата/время");
        //$this->TablePrototype($Res, $Head, 1, 0);
        $this->TableHistory($Res);
      
        Echo "<p><input type='submit' name='HistoryClose' value='Закрыть' >";
        Echo "</form>";
        Echo '</div>';
 
    }
    

    private function VxodZapros() {
        $this->TableHeadLocal=Array("False");
        $data='';
        
        
        //Echo '<div id="dialog" title="Обработка входящего запроса">';
        //Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $this->PrintMsg($_SESSION['$Message']);
                $data.= ' Способ запроса:
            <select name="SposNapr" required>
                   <option value="1"  >Почта</option>
                <option value="0" selected>VipNet</option>
                </select> </p></BR>';
        
        $data.= 'Выбрать файл: </BR>';
        $data.=' <input id="filez" type="file" name="FileZ" required></p></BR>';
        $data.= "<p><input id='VxdZ' type='submit' value='Принять запрос' >";
        $this->CreateForm('Регистрация входящего запроса',$data,'VxdZ');
        //Echo "</form>";
        //Echo '</div>';
    }
    
    private function VxodOtvet() {
       
        Echo '<div id="dialog" title="Обработка ответа на запрос">';
        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $this->PrintMsg($_SESSION['$Message']);
        echo 'Выбрать файл: </BR>';
        Echo ' <input type="file" name="FileZ" required></p></BR>';
        Echo "<p><input type='submit' name='VxdO' value='Принять ответ' >";
        Echo "</form>";
        Echo '</div>';
    }
    
    private function Msg() {
        $this->TableHeadLocal=Array("False");
        $data='';
        
        //Echo '<div id="dialog" title="Отправка ответа на запрос">';
$data .='<div  class="col_12 center" style="font-size:18px; color: Red;  text-align:center; ">ВНИМАНИЕ ПРЕЖДЕ ЧЕМ НАЖАТЬ КНОПКУ положите ОТПРАВЛЯЕМЫЕ файлы по пути '.PathVremFiles.' Затем открывайте это ОКНО. Если положить файлы когда окно открыто ФАЙЛЫ не ПОДПИШУТЬСЯ</div>';
$this->EPCreate();

//        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $data .=$this->MainRekviz2();
        $IdRec =  $_SESSION['param'][0];
        //$IdRec = $_SESSION['IdRec'];
        $query="SELECT TypeZaprosId FROM jurvipnetzapros WHERE Id='$IdRec'";
            $IdTypeZapr= (int)$this->resultOne($query);
            
            $TZI = $IdTypeZapr+1;
            $TZ = $this->getTypeZ2($TZI);
	$data .= '<div class="col_6 visible center">';
             $data .= 'Тип ответа на запрос: <b style="font-size:18px; color: Red; "> </BR> '.$TZ.'</B></p></div>';
        //Echo ' Файл для отправки: <input type="file" name="FileZ" required></BR>';
//        Echo '<p>Тип запроса: <select name="TypeZapr">
//                <option value="2">ОСИД</option>
//                <option value="4">ОИЛС</option>
//                <option value="6">ОП</option>
//                <option value="8">ООС</option>
//                </select>  </BR>';

$data .= '<div class="col_6 visible center">Тип действия(примечание): </BR>';
$data .= ' 
	    <select name="TypeDeistv" required>
                <option value="0">СТАЖ</option>
                <option value="1">З/ПЛ</option>
                <option value="2">СТАЖ И З/ПЛ</option>
                <option value="3">АКТ ПРОВЕРКИ</option>
                <option value="4">ДРУГОЕ</option>
                </select>';
$data .= '</div>';
        $data .= "<p><input type='submit' name='SendAs' value='Послать ответ' >";
//        Echo "</form>";
//
//        Echo '</div>';
        $this->CreateForm('Отправка ответа на запрос',$data,'SendAs');
        //parent::Edit('Отправка ответа на запрос', $data);
    }
    
   
    private function Stat() {
        $this->TableHeadLocal=Array("False");
        $data='';
        
        $data.="<Center> <H6> Статистика обработки входящих/исходящих Журнал регистрации направления поступления и исполнения запросов (Распоряжение Правления ПФР 463Р от 06.10.2015) </Center> </H6>";
         $data.='ИСХОДЯЩИЕ всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0").'</BR>';
$data.='из них: '.'</BR>';
$data.='Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=1")."</BR>";
$data.='З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=2")."</BR>";
$data.='Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=3")."</BR>";
$data.='Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=4")."</BR>";
$data.='Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";


$data.='обработанные всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL")."</BR>"; 
$data.='из них: ';
$data.='Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=1")."</BR>";
$data.='З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=2")."</BR>";
$data.='Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=3")."</BR>";
$data.='Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=4")."</BR>";
$data.='Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";

//SELECT jurvipnetzapros.Id, FIO FROM jurvipnetzapros, user WHERE IdUserCreate = User.id AND NapRavl =0 AND DateOtveta IS NULL 



$data.= " </BR> </BR>".'ВХОДЯЩИЕ'."</BR>";
$data.= 'Входящие всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1")."</BR>";
$data.= 'из них: ';
$data.= 'Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=1")."</BR>";
$data.= 'З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=2")."</BR>";
$data.= 'Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=3")."</BR>";
$data.='Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=4")."</BR>";
$data.='Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";


$data.='Входящие обработанные всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL")."</BR>"; 
$data.= 'из них: ';
$data.= 'Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=1")."</BR>";
$data.='З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=2")."</BR>";
$data.='Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=3")."</BR>";
$data.='Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=4")."</BR>";
$data.='Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";
        
        $this->CreateForm('Статистика запросов',$data,'');
        //parent::Edit('Отправка ответа на запрос', $data);
    }
    
    
    
     private function Peres() {
        $data='';
        $data .=$this->MainRekviz2();
        //Echo '<div id="dialog" title="Пересылка запроса">';
        //Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        //$this->MainRekviz();
        $data.="</BR> <p><input type='submit' name='ReSend' value='Переслать запрос' >";
        //Echo "</form>";
        //Echo "</div>";
        $this->CreateForm('Пересылка запроса',$data,'ReSend');
    }

    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, PathFileToArchiv `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
    //
    protected function obr() {
        
        $DC = date('Y-m-d');
        If ($_REQUEST['Action'] == 'Otvetstv') {
            $_SESSION['IdRec'] = $_SESSION['param'][0];
            $this->Otvetstv();
        }
        
        If ($_REQUEST['Act'] == 'Create') {
           //unset($_SESSION['NotAjax']);
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $_SESSION['Class']=$this->class;
            $this->Create('Создание запроса', $data);
        }

        If ($_REQUEST['Action'] == 'OtvetstvN') {
        //IF (isset($_POST['OTV'])) {
            $IdRec = $_SESSION['IdRec'];
            $IdUserSet = $_POST['UserId'];
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$IdRec,6,$IdUserSet,'Назначен ответственный');
            $query = "UPDATE jurvipnetzapros SET Otvetstv='$IdUserSet' Where Id=$IdRec";
            $this->query($query);
            unset($_SESSION['IdRec']);
            header("location: /?option=viewJurVipnet");
        }

        If ($_REQUEST['Action'] == PZ) {
            $this->VxodZapros();
            
            unset($_SESSION['$Message']);
            //exit();
        }
       
        If ($_REQUEST['Act'] == history) {
           // $this->VxodZapros();
          
          $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$_REQUEST['id'],1000,0,'Просмотр истории');
          $this->history($_REQUEST['id']);
               //Logging($Id_User, $Id_Razdela=1,$Id_Record,$id_Action,$Id_rezerv=0,$Action)
           // unset($_SESSION['$Message']);
           
           //exit();
        }
        IF (isset($_POST['HistoryClose'])) {
          header("location: /?option=viewJurVipnet");   
        }
        If ($_REQUEST['Action'] == 'VxdZ'){
            var_dump($_FILES);
        var_dump($_REQUEST);
//        //IF (isset($_POST['VxdZ'])) {
//            //IF (isset($_POST['VxdZ'])) {
//            //$DC = date('Y-m-d');
//            $IDU = $_SESSION['Id_user'];
//            
//            var_dump($_FILES);
//            exit();
//            $Ext = $this->getExtens($_FILES['FileZ']['name']);  
//            $PS = PATHINVipnet;
//            $SpNap = $_POST['SposNapr'];
//            
//            $file=$_FILES['FileZ']['name'];
//            
//            $FileMas = explode("_", $file);
//            
//            //$FileMas[0] - КОД ОПФР ЮРЛИЦА УПФР
//            If ($FileMas[0]=='') 
//            {
//                
//                //exit('Ошибка выбора файла. Файл уже обработан. Выберите другой');
//                $_SESSION['$Message']='Ошибка выбора файла. Файл уже обработан. Выберите другой';
//                //TO-DOжестокий костыль нужно что бы выводило окно как в оригинале!
//               //header("location: /?option=viewJurVipnet&Act=PZ");
//                //$this->VxodZapros();
//            }
//            
//            Else {
//                $Zapr1=$FileMas[1];
//
//                $napominanie=stripos($Zapr1, '(н)' );
//                $Zapr=$Zapr1;
//
//                If ($napominanie!==FALSE){
//                    $Zapr=substr($Zapr1,$napominanie+4);
//                    $napominanie=1;
//                }
//                else {$napominanie=0;}
//
//
//                $Zapr1=$Zapr;
//                $zablagRab=stripos($Zapr1, '(зр)' );
//
//                If ($zablagRab!==FALSE){
//                    $Zapr=substr($Zapr1,0,$zablagRab);
//                    $zablagRab=1;
//
//                }
//                else {$zablagRab=0;}
//
//                $Zapr1=mb_strtoupper($Zapr);
//
//                $FIO=substr($FileMas[2],0,strlen($FileMas[2])-4);
//
//                $TZI = $this->getTypeZ1($Zapr1);
//
//                $Flname='_'.$file;
//
//
//
//                $query = "INSERT INTO jurvipnetzapros (DataReg, FIOZL,IdUserCreate,TypeZapros,TypeZaprosId,FileZapr,PathFileToArchiv,Napravl,Povtor,ZR,SpNap)
//                   VALUES('$DC','$FIO','$IDU','$Zapr1','$TZI','$Flname','$PS','1','$napominanie','$zablagRab','$SpNap')";
//                var_dump($query);
//                exit();
//                $this->query($query);
//                
//                $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$this->linkId,2,0,'Принят входящий запрос');
//                
//                $P=$PS.iconv('utf-8', 'windows-1251', $file);
//                $P1=$PS.'_'.iconv('utf-8', 'windows-1251', $file);
//                rename($P,$P1);
//                //header("location: /?option=viewJurVipnet");
//            } //If ($FileMas[0]=='') else
        }        
        
        $data = array();

if( isset( $_GET['uploadfiles'] ) ){  
    $error = false;
    $files = array();

    $uploaddir = './uploads/'; // . - текущая папка где находится submit.php
	
	// Создадим папку если её нет
	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

	// переместим файлы из временной директории в указанную
	foreach( $_FILES as $file ){
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
            $files[] = realpath( $uploaddir . $file['name'] );
        }
        else{
            $error = true;
        }
    }
	
    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
	
	echo json_encode( $data );
}
        
        
        
        If ($_REQUEST['Act'] == 3) {
            //TO-DO добавить проверку на соответсвие ЗИЛС-ОИЛС И возможно на фамилию если не совпадает то предупреждать ;
            $this->VxodOtvet();
            $_SESSION['IdRec']=$_REQUEST['id'];
            //exit();
        }
        
         IF (isset($_POST['VxdO'])) {
            //$DC = date('Y-m-d');
            $IDU = $_SESSION['Id_user'];
            
            $Ext = $this->getExtens($_FILES['FileZ']['name']);  
            $PS = PATHINVipnet;
            
            $file=$_FILES['FileZ']['name'];
            $FileMas = explode("_", $file);
            $IdRec = $_SESSION['IdRec'];
            //$FileMas[0] - КОД ОПФР ЮРЛИЦА УПФР
            If ($FileMas[0]=='') 
            {
              $_SESSION['$Message']='Ошибка выбора файла. Файл уже обработан. Выберите другой';
              //header("location: /?option=viewJurVipnet&Act=3");
              $this->VxodOtvet();
                
            }
            
            Else {
                $F='_'.$file;
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', FileOtv='$F' , Status=".$this->StatusEnd." Where Id=$IdRec";
                $this->query($query);
                $P=$PS.iconv('utf-8', 'windows-1251', $file);
                $P1=$PS.'_'.iconv('utf-8', 'windows-1251', $file);
                rename($P,$P1);
                $this->Logging($_SESSION['Id_user'],$Id_Razdela=1,$IdRec,8,0,'Загружен ответ');
                header("location: /?option=viewJurVipnet");
            }
        }
         
         If ($_REQUEST['Action'] == 'Pereslat') {
             
            $_SESSION['IdRec'] = $_SESSION['param'][0];
            $Id= $_SESSION['IdRec'];
            $query = "Select FileZapr from jurvipnetzapros Where Id=$Id";
            $rez=$this->query($query,1);
            $_SESSION['FileZapr']=$rez['FileZapr'];
             
            
             $this->Peres();
            //exit();
//            $D = date('Y-m-d');
//            $Id = $_REQUEST['id'];
//            $query = "UPDATE jurvipnetzapros SET DateOtveta='$D' Where Id=$Id";
//            $this->query($query);
//            header("location: /?option=viewJurVipnet");
        }
        
        If ($_REQUEST['Act'] == 'kontrols') {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $Id= $_REQUEST['id'];
            $query = "UPDATE jurvipnetzapros SET Kontrol='1' Where Id=$Id"; 
            $rez=$this->query($query);
            $this->Kontrols();
          
        }
        
        IF (isset($_POST['KontrolsBut']))
        {
           $Action=$_POST['KontrolsText']; 
           $IdRec = $_SESSION['IdRec'];
           $this->Logging($_SESSION['Id_user'],1,$IdRec,5,0,$Action);
           header("location: /?option=viewJurVipnet");
        }
                
         
        
        IF ($_REQUEST['Action'] == 'ReSend'){
            $IdRec = $_SESSION['IdRec'];
            $IDUs=$_SESSION['Id_user'];
            //$DC = $_POST['DateC'];
            $KR = $_POST['KodRegion'];
            $KU = $_POST['KodUrL'];
            $KP = $_POST['KodUPFR'];
            $PS = PATHINVipnet;
            $PS1 = PathServerArxivPeres;         
            $PS2 = PATHOUTVipnet;
            $FileZapr=$_SESSION['FileZapr'];
            $FileMas = explode("_", $FileZapr);
            $NewFile=$KR.$KU.$KP.'_'.$FileMas[2].'_'.$FileMas[3];
            $P=$PS.iconv('utf-8', 'windows-1251', $FileZapr);
            $P1=$PS1.iconv('utf-8', 'windows-1251', $NewFile);
            $P2=$PS2.iconv('utf-8', 'windows-1251', $NewFile);
            rename($P,$P1);
            copy($P1, $P2);
            If ($_SESSION['Status']=22)
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', KodReg='$KR',KodUrLic='$KU',KodUpfr='$KP', FileOtv='$Flname', Otvetstv='$IDUs' , Napravl='2' , Status=".$this->StatusEnd."Where Id=$IdRec";    
            else 
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', KodReg='$KR',KodUrLic='$KU',KodUpfr='$KP', FileOtv='$Flname', Napravl='2', Status=".$this->StatusEnd." Where Id=$IdRec";    
            $this->query($query);
            $this->Logging($_SESSION['Id_user'],$Id_Razdela=1,$IdRec,4,$KR.$KU.$KP,'Пересылка запроса на '.$KR.$KU.$KP);
            
                };
                
        
           If ($_REQUEST['Act'] == 'PovtISXD') {
            $Path=PathServerArxiv;
            $D = date('Y-m-d');
            $Id= $_REQUEST['id'];
            $query = "Select FileZapr from jurvipnetzapros Where Id=$Id";
            $rez=$this->query($query,1);
            //$rez=mysqli_fetch_assoc($rez);
            $FileName=$rez['FileZapr'];
            
            $FileMas = explode("_", $rez['FileZapr']);
            If ($FileMas[3]=='') {
            $NewFileName=$FileMas[0].'_(н)'.$FileMas[1].'_'.$FileMas[2];
            }
            else {
                $NewFileName=$FileMas[0].'_(н)'.$FileMas[1].'_'.$FileMas[2].'_'.$FileMas[3];
                }
            //$Pt=$Path.$FileName;
            $P=$Path.iconv('utf-8', 'windows-1251',$FileName).'.zip';
            $P1=$Path.iconv('utf-8', 'windows-1251',$NewFileName).'.zip';
            $P2=PATHOUTVipnet.iconv('utf-8', 'windows-1251', $NewFileName).'.zip';
            
//            $P=$Path.$FileName.'.zip';
//            //$P=iconv('utf-8', 'windows-1251', $Pt);
//            //$Pt=
//            $P1=$Path.$NewFileName.'.zip';
//            //$P1=iconv('utf-8', 'windows-1251', $Pt);
//            //$Pt=
//            $P2=PATHOUTVipnet.$NewFileName.'.zip';
            //$P2=iconv('utf-8', 'windows-1251', $Pt); 
//            echo $FileName;
//            echo '<BR>';
////            echo $NewFileName;
////            echo '<BR>';
////            echo $Pt;
////            echo '<BR>';
//            echo $P;
//            echo '<BR>';
//            echo $P1;
//            echo '<BR>';
//            echo $P2;
//            echo '<BR>';
//           exit();
            $query = "UPDATE jurvipnetzapros SET Povtor='1', DatePovtor='$D',FileZapr='$NewFileName' Where Id=$Id";
            
            $this->query($query);
            rename($P,$P1);
            copy($P1, $P2);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$Id,7,0,'Направлен повторный запрос');
            header("location: /?option=viewJurVipnet");
        }
        
        If ($_REQUEST['Action'] == 'Stat') {
           $this->Stat(); 
        }
        
        If ($_REQUEST['Action'] == 'PoslatOtvet') {
        //If ($_REQUEST['Act'] == 'Msg') {
            
            $_SESSION['IdRec'] = $_SESSION['param'][0];
            $Id= $_SESSION['param'][0];
            $query = "Select FIOZL from jurvipnetzapros Where Id=$Id";
            $rez=$this->query($query,1);
            //$rez=mysqli_fetch_assoc($rez);            
            $_SESSION['FIOZL']=$rez['FIOZL'];
            $this->Msg();
            
            //exit();
//            $D = date('Y-m-d');
//            $Id = $_REQUEST['id'];
//            $query = "UPDATE jurvipnetzapros SET DateOtveta='$D' Where Id=$Id";
//            $this->query($query);
//            header("location: /?option=viewJurVipnet");
        }
        
        
        

        if (isset($_GET['SearchSTR'])) {

//        var_dump($_REQUEST);
            $qu = "SELECT * FROM SPR_UPFR WHERE UPFR LIKE '%" . strval($_GET['SearchSTR']) . "%' ORDER BY KOP, KUP  LIMIT 30";
            $fetch = $this->query($qu);
            while ($row = mysqli_fetch_assoc($fetch)) {
                //$return_arr[] = array('FIO' => $row['FIO'],'Id' => $row['Id'],'Id_Otdel' =>$row['Id_Otdel']);}
                $return_arr[] = $row['Region'] . '|' . $row['UPFR']. '|' . $row['KOP']. '|' . $row['KUL'] . '|' . $row['KUP'] . '|';
            }
            echo json_encode($return_arr);
            exit();
        }

        

//      $data = array('bla', 'bla', 'bla');
////header('Content-Type: application/javascript');
//      echo (isset($_GET['callback']) ? $_GET['callback'] : '').'(' . json_encode($data) . ')';
//IF () {
    IF (($_REQUEST['Action'] == 'Create')||($_REQUEST['Action'] == 'SendAs')) {
    //IF (($_REQUEST['Action'] == 'Create')||isset($_POST['SendAs'])) {
        //IF (isset($_POST['CreateButton'])||isset($_POST['SendAs'])) {
            $this->GLflagCreate=0;
            //$this->EPCreate();
            $IdRec = $_SESSION['IdRec'];
            //$DC = $_POST['DateC'];
            $KR = $_POST['KodRegion'];
            
            $KU = $_POST['KodUrL'];
            $KP = $_POST['KodUPFR'];
            //IF (isset($_POST['CreateButton']))
            IF (($_REQUEST['Action'] == 'Create'))
                {
                    $FL = $_POST['FIOZL'];
                    $SpNap = $_POST['SposNapr'];
                }
                else {
                    $FL=$_SESSION['FIOZL'];
            }
            
            If ($_REQUEST['Action'] == 'SendAs') {
            //If (isset($_POST['SendAs'])){
            
            $query="SELECT TypeZaprosId FROM jurvipnetzapros WHERE Id='$IdRec'";
            $IdTypeZapr= $this->resultOne($query);
            $TZI = $IdTypeZapr+1;
            }
            else $TZI=$_POST['TypeZapr'];
            
            //$TZI = $_POST['TypeZapr'];
            $TZ = $this->getTypeZ2($TZI);
            $TDe = $_POST['TypeDeistv'];
            $TZR = $_POST['ZR'];
            $PS = PathServerArxiv;
            $IDU = $_SESSION['Id_user'];

            $Ext = $this->getExtens($_FILES['FileZ']['name']);
            $Flname = $KR . $KU . $KP . '_';
            If ($_POST['NP'] == 1) {
                $Flname = $Flname . '(н)';
            };
            $Flname = $Flname . $TZ;
            If ($_POST['ZR'] == 1) {
                $Flname = $Flname . '(зр)';
            };
            
            $Flname = $Flname . '_' . $FL;
           
//            IF (isset($_POST['SaveAs']))
//                {
//            $Flname = $Flname . '.' . $Ext['extension'];
//                }
            //$Flname = $Flname ;
            
            
            $img_src = PathServerArxiv.iconv('utf-8', 'windows-1251', $Flname);
            $img_src1 = PATHOUTVipnet.iconv('utf-8', 'windows-1251', $Flname);
            
           	    
            
            If ($_REQUEST['Action'] == 'Create') {
                $query = "INSERT INTO jurvipnetzapros (DataReg, KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeZaprosId,TypeDeistv,FileZapr,PathFileToArchiv,ZR,Napravl,SpNap)
                VALUES('$DC','$KR','$KU','$KP','$FL','$IDU','$TZ','$TZI','$TDe','$Flname','$PS','$TZR','0',$SpNap)";
                $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$this->linkId,1,0,'Создан запрос');
                
                
            }
            else {
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', KodReg='$KR',KodUrLic='$KU',KodUpfr='$KP', FileOtv='$Flname', TypeDeistv='$TDe', Status='".$this->StatusEnd."' Where Id=$IdRec";
                
            }
            //var_dump($query);
            //exit();
            $this->query($query);
            
            
            
            If ($_REQUEST['Action'] == 'Create') {
            
            $img_src=$img_src.'_'.$this->linkId;
            $img_src1=$img_src1.'_'.$this->linkId;
            
            $IdRecL=$this->linkId;
            $Flname=$Flname.'_'.$IdRecL;
            If ($_REQUEST['Action'] == 'Create') {
                $query = "UPDATE jurvipnetzapros SET FileZapr='$Flname' Where Id=$IdRecL";    
                $this->query($query);
            }
            }
            
            $this->CreateZIP($img_src);
            
            //If (isset($_POST['CreateButton'])) {
            If ($_REQUEST['Action'] == 'Create') {
                copy($img_src.'.zip', $img_src1.'.zip');
                $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$this->linkId,1,0,'Создан запрос');
                $this->ochistit_papku(PathVremFiles);
            }
            else {
		copy($img_src.'.zip', $img_src1.'.zip');
		$this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$IdRec,3,0,'Направлен ответ');
		$this->ochistit_papku(PathVremFiles);
		}
            //$this->GlobalActionCreate=1;
            //header("location: /?option=viewJurVipnet");
        };
    }

    public function Create($Caption, $data) {
        //так же этим Вырубаем глобальный метод Create юзаем локальный НО ЭТО не правильно!!!!
        $this->TableHeadLocal=array("false");
       
       $data='';
       
        $data .= '<div  class="col_12 center" style="font-size:18px; color: Red;  text-align:center; ">ВНИМАНИЕ ПРЕЖДЕ ЧЕМ НАЖАТЬ КНОПКУ положите ОТПРАВЛЯЕМЫЕ файлы по пути '.PathVremFiles.' Затем открывайте это ОКНО. Если положить файлы когда окно открыто ФАЙЛЫ не ПОДПИШУТЬСЯ</div>';
        $this->EPCreate(); 
        //Echo "<form enctype='multipart/form-data' action='' method='Post'>";
        $data .=$this->MainRekviz1();
                $data .=' Способ запроса:
            <select name="SposNapr" required>
                   <option value="1"  >Почта</option>
                <option value="0" selected>VipNet</option>
                </select> </p></BR>';
        $data .= ' ФИО ЗЛ(на кого запрос): <input name="FIOZL" size="37" required> </BR>  </BR></p>';
        
       // Echo '<p> Файл для отправки: <input type="file" name="FileZ" required>';
        $data .=' Тип запроса: <select name="TypeZapr">
                <option value="1">ЗСИД</option>
                <option value="3">ЗИЛС</option>
                <option value="5">ЗП</option>
                <option value="7">ЗОС</option>
                </select> ';
        //Echo 'Тип действия(примечание): <input name="TypeDeistv" size="15" maxlength=20 >';
        $data .=' Тип действия(примечание): <select name="TypeDeistv" required>
                <option value="0">СТАЖ</option>
                <option value="1">З/ПЛ</option>
                <option value="2">СТАЖ И З/ПЛ</option>
                <option value="3">АКТ ПРОВЕРКИ</option>
                <option value="4">ДРУГОЕ</option>
                </select> ';
        $data .=' Заблаговременный запрос: 
        <select name="ZR">
                <option value="1">Да</option>
                <option value="0" selected >Нет</option>
                </select> </p></BR>';
        //$data .= "<p><input type='submit' name='CreateButton' value='Создать и отправить запрос' >";


//Echo "<p><input type='submit' name='SaveAs' value='Создать и отправить запрос' >";
     
         parent::Create($Caption, $data);
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet&Action=Create' title='Создать'>Сохранить</a></div> </Br></Br></Br>";
    }
    
//    public function Create($Caption, $data) {
//        
//        Echo "<Div class=grid>";
//        Echo '<div id="dialog" title="Создание запроса">';
//        Echo '<div  class="col_12 center" style="font-size:18px; color: Red;  text-align:center; ">ВНИМАНИЕ ПРЕЖДЕ ЧЕМ НАЖАТЬ КНОПКУ положите ОТПРАВЛЯЕМЫЕ файлы по пути '.PathVremFiles.' Затем открывайте это ОКНО. Если положить файлы когда окно открыто ФАЙЛЫ не ПОДПИШУТЬСЯ</div>';
//        $this->EPCreate(); 
//        Echo "<form enctype='multipart/form-data' action='' method='Post'>";
//        $this->MainRekviz();
//                Echo ' Способ запроса:
//            <select name="SposNapr" required>
//                   <option value="1"  >Почта</option>
//                <option value="0" selected>VipNet</option>
//                </select> </p></BR>';
//        Echo ' ФИО ЗЛ(на кого запрос): <input name="FIOZL" size="37" required> </BR>  </BR></p>';
//        
//       // Echo '<p> Файл для отправки: <input type="file" name="FileZ" required>';
//        Echo ' Тип запроса: <select name="TypeZapr">
//                <option value="1">ЗСИД</option>
//                <option value="3">ЗИЛС</option>
//                <option value="5">ЗП</option>
//                <option value="7">ЗОС</option>
//                </select> ';
//        //Echo 'Тип действия(примечание): <input name="TypeDeistv" size="15" maxlength=20 >';
//        Echo ' Тип действия(примечание): <select name="TypeDeistv" required>
//                <option value="0">СТАЖ</option>
//                <option value="1">З/ПЛ</option>
//                <option value="2">СТАЖ И З/ПЛ</option>
//                <option value="3">АКТ ПРОВЕРКИ</option>
//                <option value="4">ДРУГОЕ</option>
//                </select> ';
//        Echo ' Заблаговременный запрос: 
//        <select name="ZR">
//                <option value="1">Да</option>
//                <option value="0" selected >Нет</option>
//                </select> </p></BR>';
//        Echo "<p><input type='submit' name='SaveAs' value='Создать и отправить запрос' >";
//
//
////Echo "<p><input type='submit' name='SaveAs' value='Создать и отправить запрос' >";
//        Echo '</form>';
//        Echo '</Div>';
//        Echo '</Div>';
//        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet&Action=Create' title='Создать'>Сохранить</a></div> </Br></Br></Br>";
//    }

  
}
