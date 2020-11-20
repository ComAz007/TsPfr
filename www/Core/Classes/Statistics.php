<?php
    
//http://blog.sklazer.com/865.html почитать для просветления!

class Statistics extends Jurnals {
    
    public function __construct() {
        $this->class='Statistics';
        $this->table='';
        include 'Header.php';
        echo"";
        parent::__construct();
        
    }
   

    public function MainContent()
  {
        
        echo "<Center> <H6> Статистика обработки входящих/исходящих Журнал регистрации направления поступления и исполнения запросов (Распоряжение Правления ПФР 463Р от 06.10.2015) </Center> </H6>";
       
   
  echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet'>НАЗАД</a></div>";
  
   Echo ('<div id="tabr1" class="tab-content">');
   //Исходящие
  
 echo 'ИСХОДЯЩИЕ всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0").'</BR>';
echo 'из них: '.'</BR>';
echo 'Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=1")."</BR>";
echo 'З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=2")."</BR>";
echo 'Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=3")."</BR>";
echo 'Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and TypeDeistv=4")."</BR>";
echo 'Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";


echo 'обработанные всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL")."</BR>"; 
echo 'из них: ';
echo 'Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=1")."</BR>";
echo 'З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=2")."</BR>";
echo 'Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=3")."</BR>";
echo 'Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and TypeDeistv=4")."</BR>";
echo 'Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=0 and DateOtveta is NOT NULL and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";

//SELECT jurvipnetzapros.Id, FIO FROM jurvipnetzapros, user WHERE IdUserCreate = User.id AND NapRavl =0 AND DateOtveta IS NULL 



 echo " </BR> </BR>".'ВХОДЯЩИЕ'."</BR>";
echo 'Входящие всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1")."</BR>";
echo 'из них: ';
echo 'Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=1")."</BR>";
echo 'З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=2")."</BR>";
echo 'Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=3")."</BR>";
echo 'Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and TypeDeistv=4")."</BR>";
echo 'Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";


  echo 'Входящие обработанные всего: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL")."</BR>"; 
echo 'из них: ';
echo 'Стаж: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=1")."</BR>";
echo 'З/пл: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=2")."</BR>";
echo 'Стаж и З/ПЛ: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=3")."</BR>";
echo 'Акт Проверки: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and TypeDeistv=4")."</BR>";
echo 'Другое: '. $this->resultOne("SELECT count(Id) FROM jurvipnetzapros Where NapRavl=1 and DateOtveta is NOT NULL and (TypeDeistv=5 Or TypeDeistv is null) ")."</BR>";
 

   Echo '</div>';
   
        
     
  }
  

   
    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, PathFileToArchiv `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
    //
    protected function obr() {

        //header("location: /?option=viewJurVipnet");
    }


  
}
