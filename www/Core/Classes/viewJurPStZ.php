<?php
class viewJurPStZ extends Jurnals {
    public function __construct() {
        $this->class='viewJurPStZ';
        $this->table='JurPStZ';
        $this->IdForm=4;
        $this->TableHead=Array("Id"=>"№п/п", "FIO"=>"Фамилия Имя Отчество",
              "NamePFR"=>"Наименование ПФР", "NomerKS"=>"Рег № КС",
              "DateKS"=>"Дата КС", "NomerISXD"=>"Исходящий №","DateISXD"=>"Дата исходящего",
              "IdUserCreate"=>"Сотрудник, инициировавший запрос");
        parent::__construct();
    }
    
    public function MainContent()
    {
        echo "<script language='javascript'>var module='".$this->class."' </script>";
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        echo "<Center> <H6> Журнал регистрации запросов  в целях подтверждения стажа и заработка </Center> </H6>";
        echo '<ul class="tabs left">
                <li><a href="#tabr1">Запросы</a></li>';
        echo '</ul>';
        Echo ('<div id="tabr1" class="tab-content">');
        $IDU = $_SESSION['Id_user'];
        $Button='';
        $Button .=$this->UIButtonAjax('Create', 'Создать запрос');
        echo $Button;
        echo '<div id="ContentMainTable">';
       Echo $this->MainTabelA();
        echo '</div>';
    }
  
  private function MainTabelA() {
          If (($_SESSION['Admin']==1) or ($_SESSION['Status']==20)){
              return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));
              }
          Else{return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));}
  }
    
    protected function obr() {
        $this->GLflagCreate=1;
        
        If ($_REQUEST['Act'] == UpdCont) {
            Echo $this->MainTabelA();
        }
        
        If ($_REQUEST['Act'] == Create) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            //$_SESSION['Class']=$this->class;
            $this->Create('Создание запроса', '');    
        }
        
        
        If ($_REQUEST['Action'] == CopyRecord) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->CopyRecord($Caption,$data);  
        }
        
    }

    public function Create($Caption, $data,$reg=0) {
        parent::Create($Caption, $data);      
    }
}
