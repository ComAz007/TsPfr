<?php
class Defaul extends Acore_A{
    private $table;
    private $Fields;
    public function __construct($table='') {
        If ($table<>'') {
            $this->table=$table;
            $_SESSION['DefTable']=$table;
        }
        parent::__construct();
        
    }
    
    public function obr() {
        If ($_REQUEST['Act']=='Save'){
            echo 'Save records';

        }
    }

        public function MainContent(){
            
            echo $_SESSION['DefTable'];
            If ($_REQUEST['Act']=='Edit'){
                $this->Fields='';
              Echo "<form enctype='multipart/form-data' action='?option=Defaul&Act=Save' method='Post'>";  
            $Stt=$this->GetStructTable($_SESSION['DefTable']);
                foreach ($Stt as $key=>$value1){
                    foreach ($value1 as $key=>$value){
                        //echo $key .'=>'. $value;
                        
                        
                        If ($key=='Name') {$FieldName=$value1[$key]; $this->Fields=$this->Fields+$FieldName+',';};
                        If ($key=='Type') $FieldType=$value1[$key];
                        If ($key=='Comment') $FieldLabel=$value1[$key];
                        
                    }
                    $Zstr=$this->FieldZN($_SESSION['DefTable'], $FieldName, $_REQUEST['id']);
                        echo $this->UIDinamicTableFieldGenerate($FieldType, $FieldName, $FieldLabel, $Zstr);
                }
            
            //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=Defaul&Act=Save' title='Сохранить запись'>Сохранить запись</a></div>";
            Echo "<p><input type='submit' name='Save' value='Сохранить запись' >";
             Echo "</form>";
            }
            else {
                echo "<div class='LaButton' > <a  href='?option=Defaul&Act=Create' title='Создать запись'>Создать запись</a></div>";
            If ($this->table<>'') $this->MainTabel($this->table);
            }
            //yarray(2) { [0]=> array(4) { ["Name"]=> string(2) "Id" ["Type"]=> string(3) "int" ["Length"]=> string(2) "11" ["Comment"]=> string(4) "ИД" } [1]=> array(4) { ["Name"]=> string(10) "Name_Otdel" ["Type"]=> string(7) "varchar" ["Length"]=> string(2) "25" ["Comment"]=> string(29) "Название отдела" } } 
            echo '<div class="col_12 column">';
        echo '<a href="?option=viewJurVipnet">Дефаульт</H6></a>';
        echo '</div>';
       
    }
    
}


        
    