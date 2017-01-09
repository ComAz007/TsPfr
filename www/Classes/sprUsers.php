<?php
    
//http://blog.sklazer.com/865.html почитать для просветления!

class SprUsers extends Spravochniki {
    
    public function __construct() {
        $this->class='SprUsers';
        $this->table='User';
        parent::__construct();
        
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
	$str=$str. '</thead></tr>';
	$str=$str.'<tbody> <tr class="alt">';
        
        while($data = $Res->fetch_row()){ 
                
                $str=$str. '<td value="'.GetUserName($data['0']).'" >' . GetUserName($data['0']). '</td>';
		If($data['4']==6){
	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1'].': '. GetUserName($data['3']). '</td>';}
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



    public function MainContent(){
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        echo "<Center> <H6> Журнал регистрации начала и конца действия Карточек доступа к ПТК </Center> </H6>";
        echo '<ul class="tabs left">
            <li><a href="#tabr1">Карточки</a></li>';
        echo '</ul>';
        Echo ('<div id="tabr1" class="tab-content">');
        $IDU = $_SESSION['Id_user'];
        echo "<div id='Create' class='col_3 visible center' style='height: 25px;'> <a   title='Создать'>Создать Пользователя</a></div>";
        //echo "<div id='PrintM' class='col_3 visible center' style='height: 25px;'> <a  title='Печатать АКТ'>Печатать АКТ</a></div>";
        //echo "<div id='Action1' class='col_3 visible center' style='height: 25px;'> <a  title='Включит в АКТ'>Включить в АКТ</a></div>";
       // echo "<div id='Action2' class='col_3 visible center' style='height: 25px;'> <a  title='Закрыть карточки(у)'>Закрыть карточки(у)</a></div>";
        //echo "<div class='col_3 visible center' id='Create' style='height: 25px;'> <a href='?option=viewJurEsia&Act=Create' title='Создать заявление'>Создать заявление</a></div>";
        echo '<div id="content">';
        Echo $this->MainTabelA();
        echo '</div>';
    }
  
    private function MainTabelA() {
        $Head=Array("Id"=>"№п/п", "Login"=>"Логин",
            "FIO"=>"ФИО пользователя", "Status"=>"Набор прав",
            "Admin"=>"Администратор");
        //user.Id, user.Login, user.FIO, user.Status, user.Admin, otdely.name_Otdel FROM user, otdely WHERE (otdely.id=user.Id_Otdel)
        If (($_SESSION['Admin']==1)){
            return $this->TablePrototype($Res,$Head,$this->table,$this->class);
        }

    }
    
    private function getExtens($filename) {
        $path_info = pathinfo($filename);
        return $path_info;
    }

    private function history($id) {

        Echo '<div id="dialog" title="История обработки Запроса">';
        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $query="SELECT Id_User,Action,Times,Id_rezerv,id_action FROM logged WHERE Id_Record=$id order by Times desc";
        $Res= $this->query($query);
        $Head=array("Пользователь","Действие","Дата/время");
        //$this->TablePrototype($Res, $Head, 1, 0);
        $this->TableHistory($Res);
      
        Echo "<p><input type='submit' name='HistoryClose' value='Закрыть' >";
        Echo "</form>";
        Echo '</div>';
 
    }
    

    private function printMain() {
        If (isset($_REQUEST['sl'])){
            include 'Header.php';
            $perech='';
            foreach($_REQUEST['sl'] as $product):
                    $NNAkt.=$product.' ';
                    $query=" Select IDPtk,DataBeg,DataEnd,IdAkt,DateAkt From ".$this->table." Where Id=$product";
                    $Res= $this->query($query,1);
                    $data = $Res->fetch_assoc();
                    $perech.=$this->getPTK($data['IDPtk']).' срок действия с '.date("d.m.Y",strtotime($data['DataBeg'])).' по '.date("d.m.Y",strtotime($data['DataEnd'])).'; </BR>';
            endforeach;

            $DatAkt=$this->rdate("d M Y",strtotime($data['DateAkt']));
            $NomAkt=$data['IdAkt'];
            echo "<div class='col_3 visible NoPrint center' style='height: 25px;'> <a href='?option=".$this->class."'>Закрыть форму(возврат в журнал)</a><br></div>";
            Echo '<BR> <BR> <div  class="col_12 center" style="font-size:15px; text-align:right; ">'
                .'УТВЕРЖДАЮ:</BR >
                Начальник УПФР в г.Азове РО</BR >
                _____________ Ю.А. Булавин</BR >'.$DatAkt.'</div>';

            Echo '<BR> <BR> <div  class="col_12 center" style="font-size:15px; text-align: center; ">'
                .'<B> АКТ № '.$NomAkt.' <BR>
                об уничтожении парольной документации для доступа к программным комплексам и программам ПФР </B><BR> </div>';
            echo "<div class='col_6' style='text-align: left;'>".$DatAkt."</div>";
            echo "<div class='col_6' style='text-align: right;'> г. Азов<BR> </div>";
            Echo '<div  class="col_12" style="font-size:15px; text-align: justify;">'
                .' 1.	Комиссия в составе:</BR>
                Председатель комиссии: </BR>
                Головченко Н.А. - зам. начальника управления;</BR>
                члены комиссии: </BR>
                Оплачко М.С.- ведущий специалист-эксперт группы автоматизации;</BR>
                Ращупкина О.Н. - начальник ОПУАСВВСВЗ;</BR>
                Трубицин А.А. - главный специалист-эксперт группы автоматизации;</BR>
                назначенная Приказом от 11.10.2010 г. № 158-О «О назначении Администраторов серверов iSeries УПФР в г. Азове РО и комиссии по удалению парольной документации», в соответствии с требованиями  Инструкции по организации защиты информации АИС ПФР, утвержденной Постановлением Правления ПФР от 26.06.2008 г. № 1п дсп, Инструкции по организации защиты информации регионального и районных сегментов АИС ПФР по Отделению ПФР по РО, утвержденной Приказом по Отделению ПФР по РО от 23 марта 2009 г. № 255-О, в связи с истечением срока действия паролей пользователей произвела уничтожение парольной документации(парольные карточки):
            </div>';
            Echo '<div  class="col_12" style="font-size:18px; text-align: left;"> <B>'.
            $perech
            .'</B></BR> </div>';
            Echo '<div  class="col_12" style="font-size:15px; text-align: justify;">'
            .' путем измельчения в шредере и сжиганием. Факт выдачи и изьятия парольных карточек отражен в журнале «Учета и выдачи парольной документации» </BR> </div>';
            Echo '<div  class="col_12" style="font-size:15px; text-align: Left;">'
            .'Председатель комиссии: </BR></BR>
            Зам. начальника управления члены комиссии: ______________ Головченко Н.А.; </BR></BR></BR>
            Ведущий специалист-эксперт группы автоматизации:  ______________ Оплачко М.С.; </BR></BR></BR>
            Начальник ОПУАСВСВЗ ______________ Ращупкина О.Н; </BR></BR></BR>
            Главный специалист-эксперт группы автоматизации: ______________ Трубицин А.А.; </BR>
            </div>';
        }
        else { header("location: /?option=".$this->class);}
    }
    
   
    
    protected function obr() {
        
        If ($_REQUEST['Act'] == Create) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Create($Caption, $data);    
        }
        
        If (isset($_REQUEST['sl'])){
            If ($_REQUEST['Act'] == Action1) {
               $_SESSION['IdRec'] = $_REQUEST['id'];
               $_SESSION['param']=$_REQUEST['sl'];
               $this->Action1();
            }
        }
        
        If ($_REQUEST['Act'] == Edit) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Edit();    
        }
        
          If ($_REQUEST['Act'] == Action2) {
          
            If (isset($_REQUEST['sl'])){
                foreach($_REQUEST['sl'] as $product):
                    $query=" UPDATE ".$this->table." SET obr='1' Where Id=$product";
                    $this->query($query);
                    $this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$product,12,0,'Закрыта ПК');
                endforeach;
            
            $this->MainTabelA();
            header("location: /?option=".$this->class);
           }
        }
        
        If ($_REQUEST['Act'] == PrintM) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->printMain($data);
        }
        
        If ($_REQUEST['Act'] == 'CopySL') {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Create(1);  
        }
        
        IF (isset($_POST['B1Action1'])) {
            $NNAkt='';
            $query='';
            $DAct = $_POST['DataAkt'];
            $IAct = $_POST['NomAKT'];
            
            foreach($_SESSION['param'] as $product):
                $NNAkt.=$product.' ';
                $query=" UPDATE ".$this->table." SET IdAkt='$IAct', DateAkt='$DAct' Where Id='$product'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$product,10,0,'Проставлена дата на акт №'.$product);
            endforeach;

            //$this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$this->linkId,10,0,'Проставлены даты на акты №№'.$NNAkt);
            $this->MainTabelA();
            header("location: /?option=".$this->class);
        }
        
        IF (isset($_POST['B1Edit'])) {
            $DAct = $_POST['DataAkt'];
            $query=" UPDATE ".$this->table." SET DataEnd='$DAct' Where Id=".$_SESSION['IdRec'];
            $this->query($query);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$_SESSION['IdRec'],11,0,'Изменение реквизитов Карты');
            $this->MainTabelA();
            header("location: /?option=".$this->class);
        }
        
       IF (isset($_POST['CreateBut'])) {
            $IdRec = $_SESSION['IdRec'];
            $IDU = $_SESSION['Id_user'];
            $DateBeg = $_POST['DataBeg'];
            $Osn = $_POST['Osnovanie'];
            $PTK = $_POST['Usluga'];
            $query = "INSERT INTO JurOZIKD (IDPtk, DataBeg, Osnovanie, IdUserCreate)
                      VALUES('$PTK','$DateBeg','$Osn','$IDU')";
            $this->query($query);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$this->linkId,1,0,'Создана запись для парольных карт к ПТК');
            $this->MainTabelA();
            header("location: /?option=".$this->class);
        };
    }

    public function Create($Caption, $data) {
        Echo "<Div class=grid>"; 
        Echo '<div id="dialog" title="Создание пользователя">';
        Echo "<form enctype='multipart/form-data' action='' method='Post'>";  
            $Stt=$this->GetStructTable($this->table);
            $pole='';
                foreach ($Stt as $key=>$value1){
//                    foreach ($value1 as $key=>$value){
//                      
//                        If ($key=='Name') {$FieldName=$value1[$key]; $this->Fields=$this->Fields+$FieldName+',';};
//                        If ($key=='Type') $FieldType=$value1[$key];
//                        If ($key=='Comment') $FieldLabel=$value1[$key];
//                        
//                    }
                    //$Zstr=$this->FieldZN($_SESSION['DefTable'], $FieldName, $_REQUEST['id']);
                        //echo $this->FieldGenerate($FieldType, $FieldName, $FieldLabel, $Zstr);
                       //echo $this->FieldGenerate($FieldType, $FieldName, $FieldLabel);
                        echo $this->UIDinamicTableFieldGenerate($value1['Type'], $value1['Name'], $value1['Comment']);
                }
            //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=Defaul&Act=Save' title='Сохранить запись'>Сохранить запись</a></div>";
            Echo "<br><p><input type='submit' name='Save' value='Создать пользователя' >";
             Echo "</form>";
//            }
//            else {
//                echo "<div class='LaButton' > <a  href='?option=Defaul&Act=Create' title='Создать запись'>Создать запись</a></div>";
//            If ($this->table<>'') $this->MainTabel($this->table);
//}
        
        
        Echo '</Div>';
        Echo '</Div>';
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet&Action=Create' title='Создать'>Сохранить</a></div> </Br></Br></Br>";
    }

    
    public function Action1(){
        Echo "<Div class=grid>"; 
        Echo '<div id="dialog" title="Включение карточек в АКТ">';
        Echo "<form enctype='multipart/form-data' action='' method='Post'>";
        Echo ' Номер Акта <input name="NomAKT"> </BR>  </BR></p>';
        Echo ' Дата Акта <input class="KalDates"  name="DataAkt"> </BR>  </BR></p>';
        Echo "<p><input type='submit' name='B1Action1' value='Включить в АКТ' >";
        Echo '</form>';
        Echo '</Div>';
        Echo '</Div>';
    }
    
    public function Edit(){
        Echo "<Div class=grid>"; 
        Echo '<div id="dialog" title="Изменение карточки # '.$_SESSION['IdRec'].'">';
        Echo "<form enctype='multipart/form-data' action='' method='Post'>";
        Echo 'Дата окончания действия карт <input class="KalDates"  name="DataAkt"> </BR>  </BR></p>';
        Echo "<p><input type='submit' name='B1Edit' value='Изменить' >";
        Echo '</form>';
        Echo '</Div>';
        Echo '</Div>';
    }
  
}
