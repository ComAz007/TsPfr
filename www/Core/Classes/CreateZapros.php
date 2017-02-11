<?php

class CreateZapros extends Jurnals {

//    public function __construct() {
//        include 'Header.php';
//        parent::__construct();
//        
//    }
    
    private function MainRekviz()
    {
        Echo '<p> Поиск УПФР по классификатору: </BR> <input name="SearchField" placeholder="Поиск УПФР по справочнику" style="width: 100%" class="searchUPFR"></p>';
        $D = date('Y-m-d');
        Echo '<p>Дата: <input name="DateC" value=' . $D . '></p>';
        Echo '<p>Код Региона: <input name="KodRegion" value="071" maxlength=3 size="5" placeholder="000" required>';
        Echo '    Код Юрлица: <input name="KodUrL" value="001"  maxlength=3 size="5" placeholder="000" required>'; 
        Echo '    Код У(О)ПФР: <input name="KodUPFR" value="001" maxlength=3 size="5" placeholder="000" required></p>';
    } 

    
    
    private function getExtens($filename) {
        $path_info = pathinfo($filename);
        return $path_info;
    }

    private function Otvetstv() {

        Echo '<div id="dialog" title="Назначение ответственного">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        echo '<p>Назначить ответственного </p>';
        echo selected(SetSpisok("Select Id, FIO From User Where status=20"), 'UserId', 'Style="width:  200px"', 0);
        Echo "<p><input type='submit' name='OTV' value='Назначить ответственного' >";
        Echo "</form>";
        Echo '</div>';
    }
    
    private function Kontrols() {

        Echo '<div id="dialog" title="На контроль">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        echo '<p>Причина постановки</p>';
        Echo '<textarea name="KontrolsText" cols="155" rows="5"></textarea>';
        Echo "<p><input type='submit' name='KontrolsBut' value='Поставить на контроль' >";
        Echo "</form>";
        Echo '</div>';
 
    }
     private function history() {

        Echo '<div id="dialog" title="История обработки Запроса">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        echo '<p>История: В РАЗРАБОТКЕ </p>';
      
        Echo "<p><input type='submit' name='HistoryBut' value='Закрыть' >";
        Echo "</form>";
        Echo '</div>';
 
    }
    

    private function VxodZapros() {
        
        Echo '<div id="dialog" title="Обработка входящего запроса">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        $this->PrintMsg($_SESSION['$Message']);
                Echo ' Способ запроса:
            <select name="SposNapr" required>
                   <option value="1"  >Почта</option>
                <option value="0" selected>VipNet</option>
                </select> </p></BR>';
        
        echo 'Выбрать файл: </BR>';
        Echo ' <input type="file" name="FileZ" required></p></BR>';
        Echo "<p><input type='submit' name='VxdZ' value='Обработать запрос' >";
        Echo "</form>";
        Echo '</div>';
    }
    
    private function VxodOtvet() {
       
        Echo '<div id="dialog" title="Обработка ответа на запрос">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        $this->PrintMsg($_SESSION['$Message']);
        echo 'Выбрать файл: </BR>';
        Echo ' <input type="file" name="FileZ" required></p></BR>';
        Echo "<p><input type='submit' name='VxdO' value='Принять ответ' >";
        Echo "</form>";
        Echo '</div>';
    }
    
    private function Msg() {
   
        Echo '<div id="dialog" title="Отправка ответа на запрос">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        $this->MainRekviz();
        Echo ' Файл для отправки: <input type="file" name="FileZ" required></p></BR>';
        Echo '<p>Тип запроса: <select name="TypeZapr">
                <option value="2">ОСИД</option>
                <option value="4">ОИЛС</option>
                <option value="6">ОП</option>
                <option value="8">ООС</option>
                </select> </BR> ';

Echo ' Тип действия(примечание): <select name="TypeDeistv" required>
                <option value="0">СТАЖ</option>
                <option value="1">З/ПЛ</option>
                <option value="2">СТАЖ И З/ПЛ</option>
                <option value="3">АКТ ПРОВЕРКИ</option>
                <option value="4">ДРУГОЕ</option>
                </select> ';

        Echo "<p><input type='submit' name='SendAs' value='Послать ответ' >";
        Echo "</form>";
        Echo '</div>';
    }
    
     private function Peres() {
      
        Echo '<div id="dialog" title="Пересылка запроса">';
        Echo "<form enctype='multipart/form-data' action='?option=CreateZapros' method='Post'>";
        $this->MainRekviz();
        Echo "</BR> <p><input type='submit' name='ReSend' value='Переслать запрос' >";
        Echo "</form>";
        Echo "</div>";
    }

    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, PathFileToArchiv `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
    //
    protected function obr() {

        If ($_REQUEST['Act'] == 2) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Otvetstv();
            exit();
        }
        

        IF (isset($_POST['OTV'])) {
            $IdRec = $_SESSION['IdRec'];
            $IdUserSet = $_POST['UserId'];
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$IdRec,6,$IdUserSet,'Назначен ответственный');
            $query = "UPDATE jurvipnetzapros SET Otvetstv='$IdUserSet' Where Id=$IdRec";
            $this->query($query);
            unset($_SESSION['IdRec']);
            header("location: /?option=viewJurVipnet");
        }

        If ($_REQUEST['Act'] == PZ) {
            $this->VxodZapros();
            
            unset($_SESSION['$Message']);
            exit();
        }
       
        If ($_REQUEST['Act'] == history) {
           // $this->VxodZapros();
          
          $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$_REQUEST['id'],1000,0,'Просмотр истории');
          $this->history();
               //Logging($Id_User, $Id_Razdela=1,$Id_Record,$id_Action,$Id_rezerv=0,$Action)
           // unset($_SESSION['$Message']);
           
           //exit();
        }
        IF (isset($_POST['HistoryBut'])) {
          header("location: /?option=viewJurVipnet");   
        }
        
        IF (isset($_POST['VxdZ'])) {
            $DC = date('Y-m-d');
            $IDU = $_SESSION['Id_user'];
            
            $Ext = $this->getExtens($_FILES['FileZ']['name']);  
            $PS = PATHINVipnet;
            $SpNap = $_POST['SposNapr'];
            
            $file=$_FILES['FileZ']['name'];
            
            $FileMas = explode("_", $file);
            
            //$FileMas[0] - КОД ОПФР ЮРЛИЦА УПФР
            If ($FileMas[0]=='') 
            {
                
                //exit('Ошибка выбора файла. Файл уже обработан. Выберите другой');
                $_SESSION['$Message']='Ошибка выбора файла. Файл уже обработан. Выберите другой';
                //TO-DOжестокий костыль нужно что бы выводило окно как в оригинале!
               header("location: /?option=CreateZapros&Act=PZ");
                //$this->VxodZapros();
            }
            
            Else {
                $Zapr1=$FileMas[1];

                $napominanie=stripos($Zapr1, '(н)' );
                $Zapr=$Zapr1;

                If ($napominanie!==FALSE){
                    $Zapr=substr($Zapr1,$napominanie+4);
                    $napominanie=1;
                }
                else {$napominanie=0;}


                $Zapr1=$Zapr;
                $zablagRab=stripos($Zapr1, '(зр)' );

                If ($zablagRab!==FALSE){
                    $Zapr=substr($Zapr1,0,$zablagRab);
                    $zablagRab=1;

                }
                else {$zablagRab=0;}

                $Zapr1=mb_strtoupper($Zapr);

                $FIO=substr($FileMas[2],0,strlen($FileMas[2])-4);

                $TZI = $this->getTypeZ1($Zapr1);

                $Flname='_'.$file;



                $query = "INSERT INTO jurvipnetzapros (DataReg, FIOZL,IdUserCreate,TypeZapros,TypeZaprosId,FileZapr,PathFileToArchiv,Napravl,Povtor,ZR,SpNap)
                   VALUES('$DC','$FIO','$IDU','$Zapr1','$TZI','$Flname','$PS','1','$napominanie','$zablagRab','$SpNap')";
                $this->query($query);
                
                $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$this->linkId,2,0,'Принят входящий запрос');
                
                $P=$PS.iconv('utf-8', 'windows-1251', $file);
                $P1=$PS.'_'.iconv('utf-8', 'windows-1251', $file);
                rename($P,$P1);
                header("location: /?option=viewJurVipnet");
            } //If ($FileMas[0]=='') else
        }        
        
        If ($_REQUEST['Act'] == 3) {
            //TO-DO добавить проверку на соответсвие ЗИЛС-ОИЛС И возможно на фамилию если не совпадает то предупреждать ;
            $this->VxodOtvet();
            $_SESSION['IdRec']=$_REQUEST['id'];
            exit();
        }
        
         IF (isset($_POST['VxdO'])) {
            $DC = date('Y-m-d');
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
              //header("location: /?option=CreateZapros&Act=3");
              $this->VxodOtvet();
                
            }
            
            Else {
                $F='_'.$file;
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', FileOtv='$F' Where Id=$IdRec";
                $this->query($query);
                $P=$PS.iconv('utf-8', 'windows-1251', $file);
                $P1=$PS.'_'.iconv('utf-8', 'windows-1251', $file);
                rename($P,$P1);
                header("location: /?option=viewJurVipnet");
            }
        }
         
         If ($_REQUEST['Act'] == 'Peres') {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $Id= $_REQUEST['id'];
            $query = "Select FileZapr from jurvipnetzapros Where Id=$Id";
            $rez=$this->query($query);
            $rez=mysqli_fetch_assoc($rez);            
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
                
         
        
        IF (isset($_POST['ReSend']))
                {
            $IdRec = $_SESSION['IdRec'];
            $IDUs=$_SESSION['Id_user'];
            $DC = $_POST['DateC'];
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
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', KodReg='$KR',KodUrLic='$KU',KodUpfr='$KP', FileOtv='$Flname', Otvetstv='$IDUs' , Napravl='2' Where Id=$IdRec";    
            else 
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', KodReg='$KR',KodUrLic='$KU',KodUpfr='$KP', FileOtv='$Flname', Napravl='2' Where Id=$IdRec";    
            $this->query($query);
            
                };
                
        
           If ($_REQUEST['Act'] == 'PovtISXD') {
            $Path=PathServerArxiv;
            $D = date('Y-m-d');
            $Id= $_REQUEST['id'];
            $query = "Select FileZapr from jurvipnetzapros Where Id=$Id";
            $rez=$this->query($query);
            $rez=mysqli_fetch_assoc($rez);
            $FileName=$rez['FileZapr'];
            
            $FileMas = explode("_", $rez['FileZapr']);
            $NewFileName=$FileMas[0].'_(н)'.$FileMas[1].'_'.$FileMas[2];
            $Pt=$Path.$FileName;
            $P=iconv('utf-8', 'windows-1251', $Pt);
            $Pt=$Path.$NewFileName;
            $P1=iconv('utf-8', 'windows-1251', $Pt);
            $Pt=PATHOUTVipnet.$NewFileName;
            $P2=iconv('utf-8', 'windows-1251', $Pt);
            $query = "UPDATE jurvipnetzapros SET Povtor='1', DatePovtor='$D',FileZapr='$NewFileName' Where Id=$Id";
            
            $this->query($query);
            rename($P,$P1);
            copy($P1, $P2);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=1,$Id,7,0,'Направлен повторный запрос');
            header("location: /?option=viewJurVipnet");
        }
        
        
        
        If ($_REQUEST['Act'] == 'Msg') {
            
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $Id= $_REQUEST['id'];
            $query = "Select FIOZL from jurvipnetzapros Where Id=$Id";
            $rez=$this->query($query);
            $rez=mysqli_fetch_assoc($rez);            
            $_SESSION['FIOZL']=$rez['FIOZL'];
            $this->Msg();
            
            exit();
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

        IF (isset($_POST['SaveAs'])||isset($_POST['SendAs'])) {
            
            $IdRec = $_SESSION['IdRec'];
            $DC = $_POST['DateC'];
            $KR = $_POST['KodRegion'];
            
            $KU = $_POST['KodUrL'];
            $KP = $_POST['KodUPFR'];

            IF (isset($_POST['SaveAs']))
                {
                    $FL = $_POST['FIOZL'];
                    $SpNap = $_POST['SposNapr'];
                }
                else {
                    $FL=$_SESSION['FIOZL'];
            }

            $TZI = $_POST['TypeZapr'];
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

            $Flname = $Flname . '.' . $Ext['extension'];
            
            $img_src = PathServerArxiv.iconv('utf-8', 'windows-1251', $Flname);
            $img_src1 = PATHOUTVipnet.iconv('utf-8', 'windows-1251', $Flname);
            
            If (!move_uploaded_file($_FILES['FileZ']['tmp_name'], $img_src)) {
                exit("Не удалось загрузить файл");
            }
            

            copy($img_src, $img_src1);

            //FileOtv
            
            
            If (isset($_POST['SaveAs'])) {
                $query = "INSERT INTO jurvipnetzapros (DataReg, KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeZaprosId,TypeDeistv,FileZapr,PathFileToArchiv,ZR,Napravl,SpNap)
                VALUES('$DC','$KR','$KU','$KP','$FL','$IDU','$TZ','$TZI','$TDe','$Flname','$PS','$TZR','0',$SpNap)";}
            else {
                $query = "UPDATE jurvipnetzapros SET DateOtveta='$DC', KodReg='$KR',KodUrLic='$KU',KodUpfr='$KP', FileOtv='$Flname', TypeDeistv='$TDe' Where Id=$IdRec";    
            }
            //var_dump($query);
            $this->query($query);
            header("location: /?option=viewJurVipnet");
        };
    }

    public function MainContent() {
        If (isset($_REQUEST['Act'])==False) {
        Echo "<Div class=grid>"; 
       
        Echo "<form enctype='multipart/form-data' action='' method='Post'>";
        $this->MainRekviz();
                Echo ' Способ запроса:
            <select name="SposNapr" required>
                   <option value="1"  >Почта</option>
                <option value="0" selected>VipNet</option>
                </select> </p></BR>';
        Echo ' ФИО ЗЛ(на кого запрос): <input name="FIOZL" size="37" required> </BR>  </BR></p>';
        
        Echo '<p> Файл для отправки: <input type="file" name="FileZ" required>';
        Echo ' Тип запроса: <select name="TypeZapr">
                <option value="1">ЗСИД</option>
                <option value="3">ЗИЛС</option>
                <option value="5">ЗП</option>
                <option value="7">ЗОС</option>
                </select> ';
        //Echo 'Тип действия(примечание): <input name="TypeDeistv" size="15" maxlength=20 >';
        Echo ' Тип действия(примечание): <select name="TypeDeistv" required>
                <option value="0">СТАЖ</option>
                <option value="1">З/ПЛ</option>
                <option value="2">СТАЖ И З/ПЛ</option>
                <option value="3">АКТ ПРОВЕРКИ</option>
                <option value="4">ДРУГОЕ</option>
                </select> ';
        Echo ' Заблаговременный запрос: 
        <select name="ZR">
                <option value="1">Да</option>
                <option value="0" selected >Нет</option>
                </select> </p></BR>';
        Echo "<p><input type='submit' name='SaveAs' value='Создать и отправить запрос' >";
        Echo '</form>';
        Echo '</Div>';
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=CreateZapros&Action=Create' title='Создать'>Сохранить</a></div> </Br></Br></Br>";
    }}

}
