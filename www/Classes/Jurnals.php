<?php
class Jurnals extends Acore_A{
     
//    static public $LogMsg;
//    public function __construct(){
//  
//    parent::__construct();
//    
//    //$this->rrrr();
//   
//}

//protected function rrrr() {
//           echo 'kkkk'.$this->LogMsg;
//}

//protected function IdentData($TableName,$key,$data){
//    
//    $result='';
//    If ($key=='IdUserCreate'){ $result=GetUserName($data);}
//    
//    If ($TableName=='juresia' AND $key=='Deistvie'){ $result=$this->getESIA($data);}
//    If ($TableName=='juresia' AND $key=='DateObr'){ $result=date("d.m.Y",strtotime($data));}
//
//
//    If ($result=='')
//        {return $data;}
//    else 
//        {return $result;}
//    
//}



//Array("Id"=>"№п/п", "FIO"=>"Фамилия Имя Отчество",
//              "DocRekv"=>"Реквизиты документа, удостоверяющего личность", "SNILS"=>"СНИЛС",
//              "DateObr"=>"Дата обращения", "Deistvie"=>"Услуга, за которой обратился заявитель",
//              "IdUserCreate"=>"Сотрудник, принявший заявление");
    
    protected function getTypeZ($type) {
   $arrays = array(
                0=>'ИСХД',
                1=>'ВХДИ',
                2=>'ПЕРЕ'
               );
    return $arrays[$type];
    }
    
    protected  function getEsNo($type) {
   $arrays = array(
                0=>'Нет',
                1=>'Да',
               );
    return $arrays[$type];
    }
    
    protected  function getTypeZ2($type) {
        $arrays = array(
            1 => 'ЗСИД',
            2 => 'ОСИД',
            3 => 'ЗИЛС',
            4 => 'ОИЛС',
            5 => 'ЗП',
            6 => 'ОП',
            7 => 'ЗОС',
            8 => 'ООС');
        return $arrays[$type];
    }
    
    protected  function getTypeZ1($type) {
        $arrays = array(
            ЗСИД => '1',
            ОСИД => '2',
            ЗИЛС => '3',
            ОИЛС => '4',
            ЗП => '5',
            ОП => '6',
            ЗОС => '7',
            ООС => '8');
        return $arrays[mb_strtoupper($type)];
    }
   
    
   protected function getTypeZ3($type) {
   $arrays = array(
                1=>'СТАЖ',
                2=>'З/ПЛ',
                3=>'СТАЖ И З/ПЛ',
                4=>'АКТ ПРОВЕРКИ',
                5=>'ДРУГОЕ'
                );
   If ($type>0)
    return $arrays[$type];
   else {
    return $type;
   }
    }
    
    protected function getTypeZ4($type) {
   $arrays = array(
                0=>'VipNet',
                1=>'ПОЧТА'
                );
    return $arrays[$type];
    }
    
    protected function getESIA($type,$GetSet=0) {
    //static function getESIA($type,$GetSet=0) {
        $arrays = array(
                1=>'Регистрация',
                2=>'Подтверждение',
                3=>'Восстановление доступа',
                4=>'Удаление'
                );
   
        If ($GetSet==1){
            $arrays = array_flip ($arrays);
        }
        
        If ($GetSet==2){
            return $arrays;
        }
        else {
            return $arrays[$type];
        }
    }

    
    protected function getPTK($type,$GetSet=0) {
    //static function getESIA($type,$GetSet=0) {
        $arrays = array(
                1=>'ПТК СПУ(РАЙОН)',
                2=>'ПТК СПУ(РЕГИОН)',
                3=>'Locopr',
                4=>'РК АСВ',
                5=>'БПИ',
                6=>'ПК ПЕРСО', 
                7=>'ПТК АСВ',
                8=>'ПТК Страхователь',
                9=>'ПТК КСиУПД',
                10=>'ПК СМЭВ', 
                11=>'АРМ КОНВЕРТАЦИЯ',
	    12=>'Выплата СПН',
	    13=>'ОГБД Ветераны'

                );
   
        If ($GetSet==1){
            $arrays = array_flip ($arrays);
        }
        
        If ($GetSet==2){
            return $arrays;
        }
        else {
            return $arrays[$type];
        }
    }
    
    
    
    protected function rdate($param, $time=0) {
	if(intval($time)==0)$time=time();
	$MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
	if(strpos($param,'M')===false) return date($param, $time);
		else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}




    
    
    public function MainContent(){
         //echo 'в лог идет: '+$this->LogMsg;
        echo '<div class="col_12 column">';
        echo '<p><a href="?option=viewJurVipnet"><H6> Журнал регистрации направления поступления и исполнения запросов (Распоряжение Правления ПФР 463Р от 06.10.2015)</H6></a></p>';
        echo '<p><a href="?option=viewJurEsia"><H6> Журнал регистрации заявлений на регистрацию, подтверждение, удаление, восстановление доступа к учетной записи пользователя в Единой системе идентификации и аутентификации в инфраструктуре, обеспечивающей информационно-технологическое взаимодействие информационных систем, используемых для предоставления государственных и муниципальных услуг в электронной форме</H6></a></p>';
        echo '</div>';
       
    }
    
}


        
    