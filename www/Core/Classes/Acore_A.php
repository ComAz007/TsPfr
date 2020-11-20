<?php

//!!!ЭТО АДМИНСКИЙ КЛАСС!!!!
/**
 * Description of Acore
 *
 * @author Я
 */
require_once 'ADB.php';

abstract class Acore_A extends ADB {

    public $class;
    public $table;
    public $tableHead;
    public $tableHeadLocal;
    public $statusEnd;
    public $crosTable;
    public $idForm;
    protected $idUser;
    private $userTable = [];
    // TO-DO пдумать как сделать красивей! Сейчас если 1 то работает Create Acore_A если 0 то Create Модуля!
    public $glFlagCreate = 1;
    public $glFlagEdit = 1;

    protected function logging($Id_User, $Id_Razdela = 1, $Id_Record, $id_Action, $Id_rezerv = 0, $Action) {
        /*
         * $Id_Razdela=0 - Журнал Тех поддержки
         * $Id_Razdela=1 - Журнал Випнет
         * $Id_Razdela=2 - Журнал ЕСИА
         * $Id_Razdela=3 - Журнал Карточек ПТК
         * $Id_Razdela=4 - Журнал Регистрации Запросов подтверждения стажа

         *
         * $id_Action=1 Создание запроса
         * $id_Action=2 Принятие запроса
         * $id_Action=3 Отправка ответа
         * $id_Action=4 Пересылка
         * $id_Action=5 Контроль
         * $id_Action=6 Запрос отписан ИД ответственного в поле $Id_rezerv
         * $id_Action=7 Направление повторного запроса
         * $id_Action=8 Загружен ответ
         * $id_Action=10 Акты на уничтожение
         * $id_Action=11 Изменение параметров карт доступа
         * $id_Action=1000 Просмотр истории
         */
//Id,Id_User, Id_Razdela,Id_Record,id_Action,Id_rezerv,Action,Dates,Times
        $d = date("Y-m-d H:i:s");
        $t = date("H:i:s");
        $query = "INSERT INTO logged (Id_User,Id_Razdela,Id_Record,id_Action,Id_rezerv,Action,Times)
                   VALUES('$Id_User','$Id_Razdela','$Id_Record','$id_Action','$Id_rezerv','$Action','$d')";
        $this->query($query);
    }

    public function __construct() {
        // echo 'Acore_A.php';
        if ($_SESSION['Id_user'] == '') {
            header("Location: /Auth.php");
        } else {
            $this->IDUser = $_SESSION['Id_user'];
            parent::__construct();

            if (empty($this->UserTable)) {
                $this->UserMas();
            }

            $this->get_Body();
        }
    }

    private function userMas() {
        $query = " Select Id,FIO from user";
        $res = $this->query($query);
        while ($data = $res->fetch_assoc()) {
            $this->UserTable[$data["Id"]] = $data["FIO"];
        }
    }

    protected function getUserName($Id) {
        return $this->UserTable[$Id];
    }

    protected function printMsg($MSG) {
        if ($MSG <> '')
            echo '<p style="height: 25px; color: red;">' . $MSG . '</p> </BR>';
        unset($_SESSION['$Message']);
    }

    function mergeArray() {
        $new_arr = array();
        $this->tableHeadLocal = array_map('strtolower', $this->tableHeadLocal);
        if (!empty($this->tableHeadLocal)) {
            foreach ($this->tableHead as $key => $value) {
                if (in_array($key, $this->tableHeadLocal)) {
                    $new_arr[$key] = $value;
                }
            }
        } else {
            foreach ($this->tableHead as $key => $value) {
                $new_arr[$key] = $value;
            }
        }
        $this->tableHeadLocal = $new_arr;
        //var_dump($this->tableHeadLocal);
    }

    public function createZIP($fileNameArch = NULL) {

        $folder = PathVremFiles;
        $array_file = scandir($folder); //Масcив с именами файлов
        $folderDopDoc = PathDopDoc;
        $array_fileDopDoc = scandir($folderDopDoc);
        $zip = new ZipArchive();
        $fileNameArx = $fileNameArch;

        if ($zip->open($fileNameArx . '.zip', ZIPARCHIVE::CREATE) !== true) {
            fwrite(STDERR, "Error while creating archive file");
            exit(1);
        }

        foreach ($array_file as $name_file) {
            if (!is_dir($folder . $name_file)) {
                $zip->addFile($folder . $name_file, iconv('windows-1251', 'CP866//TRANSLIT//IGNORE', $name_file));
            }
        }

        if ($_REQUEST['Action'] == 'Create') {
            foreach ($array_fileDopDoc as $name_file) {
                if (!is_dir($folderDopDoc . $name_file)) {
                    $zip->addFile($folderDopDoc . $name_file, iconv('windows-1251', 'CP866//TRANSLIT//IGNORE', $name_file));
                }
            }
        }
        $zip->close();
    }

    public function ochistit_papku($celevaya_papka) {
        $spisok = scandir($celevaya_papka);
        unset($spisok[0], $spisok[1]);
        $spisok = array_values($spisok);

        foreach ($spisok as $failik) :
            if (is_dir($celevaya_papka . $failik)) :
                $this->ochistit_papku($celevaya_papka . $failik . '/');
                rmdir($celevaya_papka . $failik);
            else :
                unlink($celevaya_papka . $failik);
            endif;
        endforeach;
    }

    public function EPCreate() {
        $folder = PathVremFiles; //Папка с файлами
        $array_file = scandir($folder); //Масcив с именами файлов
        //$array_file=iconv('utf-8','windows-1251', $array_file);
        foreach ($array_file as $key => $value) {
            $array_file[$key] = iconv("windows-1251", "UTF-8", $value);
        }

        $Files = json_encode($array_file);
        $PathTmp = json_encode(PathVremFiles);

        print "<script language='javascript'> SendGet($Files,$PathTmp) </script>";
    }

    //Чудо функция организующая связь поля и справочника
    protected function identData($TableName, $key, $data) {

        $result = '';
        if ($key == 'IdUserCreate') {
            $result = $this->getUserName($data);
        }

        if ($key == 'Id_User_Create') {
            $result = $this->getUserName($data);
        }

        if ($key == 'Id_User_Vipoln') {
            $result = $this->getUserName($data);
        }

        if ($key == 'Id_User_Get') {
            $result = $this->getUserName($data);
        }

        if ($TableName == 'JurObrEVD' AND $key == 'region') {
            $result = $this->getRegion($data);
        }

        if ($TableName == 'JurEsia' AND $key == 'Deistvie') {
            $result = $this->getESIA($data);
        }
        if ($TableName == 'JurEsia' AND $key == 'DateObr') {
            $result = date("d.m.Y", strtotime($data));
        }

        if ($TableName == 'JurOZIKD' AND $key == 'IDPtk') {
            $result = $this->getPTK($data);
        }

        if ($TableName == 'JurOZIKD' AND $key == 'DataBeg') {
            $result = date("d.m.Y", strtotime($data));
        }
        if ($TableName == 'JurOZIKD' AND $key == 'DataEnd') {
            $result = date("d.m.Y", strtotime($data));
        }
        if ($TableName == 'JurOZIKD' AND $key == 'DateAkt') {
            $result = date("d.m.Y", strtotime($data));
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'Napravl') {
            $result = $this->getTypeZ($data);
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'SpNap') {
            $result = $this->getTypeZ4($data);
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'DataReg') {
            $result = date("d.m.Y", strtotime($data));
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'Povtor') {
            $result = date("d.m.Y", strtotime($data));
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'DatePovtor') {
            $result = date("d.m.Y", strtotime($data));
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'DateOtveta') {
            $result = date("d.m.Y", strtotime($data));
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'TypeDeistv') {
            $result = $this->getTypeZ3($data);
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'ZR') {
            $result = $this->getEsNo($data);
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'Povtor') {
            $result = $this->getEsNo($data);
        }

        if ($TableName == 'jurvipnetzapros' AND $key == 'Otvetstv') {
            $result = $this->getUserName($data);
        }

        if ($result == '') {
            return $data;
        } else {
            return $result;
        }
    }

    protected function TablePrototype($Res, $Head, $TableName = '', $Class = '', $AtribId = Array('Edit'), $CheckedFieldOnOff = '1') {
        $str = '';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str = $str . '<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
        //echo $col;
        $str = $str . '<thead><tr class="alt User">';
        $ii = 0;
        $select = '';
        foreach ($Head as $key => $value) {
            $str = $str . '<th value="User" rel="' . $key . '">' . $value . '</th>';
            $select = $select . $key . ',';
        }
        $select = substr($select, 0, -1);

        if ($CheckedFieldOnOff !== '1') {
            $select.=',' . $CheckedFieldOnOff;
        }

        $query = '';
        $query = 'Select ' . $select . ' From ' . $TableName;

        if ($Access == 1) {
            $query = $query . ' Where IdUserCreate=' . $_SESSION['Id_user'];
        };

        $query = $query . ' Order By Id DESC LIMIT 20';
        $Res = $this->query($query);
        $str = $str . '</thead></tr>';
        $str = $str . '<tbody> <tr class="alt">';
        while ($data = $Res->fetch_assoc()) {
            foreach ($Head as $key => $value) {
                if ($key == 'Id') {
                    $datav = '';
                    if ($CheckedFieldOnOff !== 1 and $data[$CheckedFieldOnOff] == 0) {
                        if (in_array('Checked', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.='<input id="iCheked" class="cCheked" type="checkbox" name="NCheked" value="' . $data[$key] . '"></BR>';
                        };

                        if (in_array('Edit', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.='<a id="Edit" href="?option=' . $Class . '&Act=Edit&id=' . $data[$key] . '">' . $data[$key] . '</a> </BR>';
                        } else {
                            $datav.='  ' . $data[$key] . ' ';
                        };

                        $datav.='</Br>';
                        if ((in_array('EditStr', $AtribId, true) and ( !in_array('Edit', $AtribId, true))) or in_array('ALL', $AtribId, true)) {
                            $datav.='<a id="Edit" href="?option=' . $Class . '&Act=Edit&id=' . $data[$key] . ' ">Редактировать</a> </BR> ';
                        };
                        if (in_array('PrnRec', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.='<a class="PrintRecord PointCursor" href="?option=' . $Class . '&Act=PrintForm&id=' . $data[$key] . '" RecId=' . $data[$key] . '>Печать</a> </BR> ';
                        };

                        if (in_array('Copy', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.=$this->uiIdTableAction('CopyRecord', 'Скопировать');
                        };
                    } else {
                        $datav.='  ' . $data[$key] . ' ';
                    };
                    $datav.='<a id="Historym" href="?option=' . $Class . '&Act=History&id=' . $data[$key] . '"> История</a></BR> ';
                    $datav1 = $data[$key];
                } else {
                    $datav = $this->identData($TableName, $key, $data[$key]);
                }

                if ($key == 'Id') {
                    $str = $str . '<td RecId=' . $data[$key] . ' value="' . $data[$key] . '" >' . $datav . '</td>';
                } else {
                    $str = $str . '<td RecId=' . $data[$key] . ' value="' . $datav . '" >' . $datav . '</td>';
                }
            }

            $str = $str . '</tr>';
            $datav = '';
            $datav1 = '';
        }
        $str = $str . '</tbody></table>';

        return $str;
    }

    //TO-DO новая функция отрисовки таблиц(от 19/12/2016). Заменить во всех местах
    //TO-DO $CheckedFieldOnOff - поле по которому определяется что обработка завершена
    //доработат до состояния когда определяется Имя поля и значение
    //TO-DO человеческий эрор если таблицы нет в БД!
    protected function TablePrototypeNew($AtribId = Array('Edit'), $CheckedFieldOnOff = '1', $WhereString = '', $Access = 0) {
        $str = '';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str = $str . '<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
        $str = $str . '<thead><tr class="alt User">';
        $ii = 0;
        $select = '';

        foreach ($this->tableHead as $key => $value) {
            $str = $str . '<th value="User" rel="' . $key . '">' . $value . '</th>';
            $select = $select . $key . ',';
        }

        $select = substr($select, 0, -1);

        if ($CheckedFieldOnOff !== '1') {
            $select.=',' . $CheckedFieldOnOff;
        }

        $query = '';
        $query = 'Select ' . $select . ' From ' . $this->table;
        if ($Access == 1) {
            $query = $query . ' Where IdUserCreate=' . $_SESSION['Id_user'];
        };
        if ($Access !== 1 and $WhereString !== '') {
            $query.=' Where ' . $WhereString;
        };
        if ($Access == 1 and $WhereString !== '') {
            $query.=' and ' . $WhereString;
        };
        $query = $query . ' Order By Id DESC LIMIT 20';
        $Res = $this->query($query);
        $str = $str . '</thead></tr>';
        $str = $str . '<tbody> <tr class="alt">';
        //var_dump($query);

        while ($data = $Res->fetch_assoc()) {
            foreach ($this->tableHead as $key => $value) {
                if ($key == 'Id') {
                    $datav = '';
                    if ($CheckedFieldOnOff !== 1 and $data[$CheckedFieldOnOff] < $this->StatusEnd) {
                        if (in_array('Checked', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.='<input id="iCheked" class="cCheked" type="checkbox" name="NCheked" value="' . $data[$key] . '"></BR>';
                        };

                        if (in_array('Edit', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.=$this->uiIdTableAction('EditRecord', $data[$key]);
                        } else {
                            $datav.='  ' . $data[$key] . ' ';
                        };

                        if ((in_array('EditStr', $AtribId, true) and ( !in_array('Edit', $AtribId, true))) or in_array('ALL', $AtribId, true)) {
                            $datav.=$this->uiIdTableAction('EditRecord', 'Редактировать');
                        };

                        if (in_array('PrnRec', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.='<a class="PrintRecord" href="?option=' . $this->class . '&Act=PrintForm&id=' . $data[$key] . ' ">Печать</a> </BR> ';
                        };

                        if (in_array('Copy', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.=$this->uiIdTableAction('CopyRecord', 'Скопировать');
                        };
                    } else {
                        if (in_array('Checked', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.='<input id="iCheked" class="cCheked" type="checkbox" name="NCheked" value="' . $data[$key] . '"></BR>';
                        };

                        if (in_array('Edit', $AtribId, true) or in_array('ALL', $AtribId, true)) {
                            $datav.=$this->uiIdTableAction('EditRecord', $data[$key]);
                        } else {
                            $datav.='  ' . $data[$key] . ' ';
                        };

                        if ((in_array('EditStr', $AtribId, true) and ( !in_array('Edit', $AtribId, true))) or in_array('ALL', $AtribId, true)) {
                            $datav.=$this->uiIdTableAction('EditRecord', 'Редактировать');
                        };
                    };
                    $datav.='<a id="Historym" href="?option=' . $this->class . '&Act=History&id=' . $data[$key] . '"> История</a></BR> ';
                    $datav1 = $data[$key];
                } else {
                    $datav = $this->identData($this->table, $key, $data[$key]);
                }

                if ($key == 'Id') {
                    $str = $str . '<td RecId=' . $data[$key] . ' value="' . $data[$key] . '" >' . $datav . '</td>';
                } else {
                    $str = $str . '<td RecId=' . $data[$key] . ' value="' . $datav . '" >' . $datav . '</td>';
                }
            }

            $str = $str . '</tr>';
            $datav = '';
            $datav1 = '';
        }

        $str = $str . '</tbody></table>';
        echo $str;
    }

    //Чудо функция конвертирования DocX в строку! убогая но посмотреть содержимое можно
    public function readDocx($filePath) {
        // Create new ZIP archive
        $filePath = "D:/_ElArx/test.docx";
        $zip = new ZipArchive;
        $dataFile = 'word/document.xml';
        // Open received archive file
        if (true === $zip->open($filePath)) {
            // if done, search for the data file in the archive'
            if (($index = $zip->locateName($dataFile)) !== false) {
                // if found, read it to the string
                $data = $zip->getFromIndex($index);
                //Close archive file
                $zip->close();
                // Load XML from a string
                // Skip errors and warnings
                var_dump($data);
                $xml = new DOMDocument();
                $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                // Return data without XML formatting tags'
                $contents = explode('\n', strip_tags($xml->saveXML()));
                $text = '';
                foreach ($contents as $i => $content) {
                    $text .= $contents[$i];
                }
                return $text;
            }
            $zip->close();
        }
        // In case of failure return empty string
        return "";
    }

    protected function get_Header() {
        include 'Header.php';
        include 'menu.php';
    }

    protected function get_LeftBar() {
        //Function had been reserving from print LeftBar
    }

    protected function get_Footer() {
        echo '
        <!-- End mainContent-->
        </div >';
        include 'ver.php';
        echo '
                </body>
                </html>';
    }

    public function get_Body() {
        if ($_POST || $_GET) {

            if (!isset($_GET['SearchSTR'])) {
                include 'scripts.php';
            };

            $this->obr($_REQUEST);
            $this->obrGL($_REQUEST);
        } else {

            if ((!$_REQUEST['Action'] == 'Create') and ( !isset($_POST['CreateButton']))) {
                $this->get_Header();
                $this->mainContent();
                $this->get_Footer();
            }
        }

        if (isset($_REQUEST['id'])) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
        }

        if (isset($_REQUEST['IdRec'])) {
            $_SESSION['IdRec'] = $_REQUEST['IdRec'];
        }

        if (isset($_SESSION['IdRec'])) {
            $_SESSION['IdRec'] = $_SESSION['IdRec'];
        }

        if (isset($_REQUEST['RecordId'])) {
            $_SESSION['IdRec'] = $_REQUEST['RecordId'];
        }

        if (isset($_REQUEST['sl'])) {
            $_SESSION['param'] = $_REQUEST['sl'];
        }
    }

    abstract function mainContent();

    protected function edit($Caption, $data) {
        $data1 = '';
        $data1.=$data;
        $data1 .= $this->dynamicTableGenerated();
        $data1 .= $this->uiButtonSave();
        $data1 .= $this->uiButtonClose();
        var_dump($data1);
        $this->form($Caption, $data1, 'Edit');
    }

    protected function create($Caption, $data) {
        $data .= $this->dynamicTableGenerated();
        $data .= '</br> ' . $this->uiButtonCreate();
        $this->form($Caption, $data, 'Create');
    }

    //создание формы почти повторяет private function Form
    //TO-DO рассмотреть вопрос об оптимизации соединив все в одну форму
    // TO-DO доработать до стадии когда из полей подставляются значения если они там есть!!!
    protected function createForm($Caption, $data, $Action) {
        $this->form($Caption, $data, $Action);
    }

    protected function copyRecord($Caption, $data) {
        $data .= $this->dynamicTableGenerated();
        $data .= $this->uiButtonCreate();
        $this->form($Caption, $data, 'Create');
    }

    private function form($Caption, $data, $Action = '') {
        echo '<div id="dialog" title="' . $Caption . '# ' . $_SESSION['IdRec'] . '" >';

        if ($Action == '') {
            echo "<form enctype='multipart/form-data' action='' method='Post'>";
        } else {
            echo "<form enctype='multipart/form-data' action='$Action' method='post' class='Uiform'>";
        }

        echo $data;
        echo '</form>';
        echo '</Div>';
    }

    protected function obr() {
        //To-Do Function had been reserving for additional process
    }

    protected function obrGL($request) {
        $pole = '';
        $zn = '';

        if (isset($request['exit'])) {
            include_once 'logout.php';
            header("location: /auth.php");
        }

        if (isset($request['Authorization'])) {
            require_once "Lib/Function.php";
            $login = $_POST['Loginname'];
            $pass = $_POST['PassText'];

            if (chekUser($login, $pass)) {
                $_SESSION['login'] = $Login;
                $_SESSION['pass'] = $pass;
                unset($_SESSION['err_autrh']);
                header("location: index.php");
            } else {
                $_SESSION['err_autrh'] = 1;
            }
        }

        if ($_REQUEST['Act'] == UMC) {
            $this->mainContent();
        }

        if ($this->glFlagCreate == 1) {
            if ($request['Action'] == 'Create') {
                //var_dump($request);
                $this->MergeArray();
                //To-do оптимизировать Инсерт СКУЭЛЬ не тянуть все поляа только те что в Хеадре на форме были//
                foreach ($this->tableHeadLocal as $key => $value) {
                    if ($key <> 'Id' and $key <> 'IdUserCreate') {
                        $zn.='"' . $request[$key] . '",';
                        $pole.=$key . ',';
                    }

                    if ($key == 'IdUserCreate') {
                        $zn.='"' . $_SESSION['Id_user'] . '",';
                        $pole.='IdUserCreate' . ',';
                    }
                }

                $zn = substr($zn, 0, -1);
                $pole = substr($pole, 0, -1);
                $query = "INSERT INTO " . $this->table . " (" . $pole . ") VALUES(" . $zn . ")";
                $this->query($query);
                $this->logging($_SESSION['Id_user'], $this->IdForm, $this->linkId, 1, 0, 'Создание записи');

                if ($this->class == 'viewJurObrEVD') {
                    mail("071-040-0800", iconv('utf-8', 'windows-1251', "Новая задача загрузки ЭВД"), iconv('utf-8', 'windows-1251', "Новая задача загрузки ЭВД"));
                }
            }
        }
    }

    public function MainTabel($Table) {
        $arr = $this->GetStructTable($Table);
        //var_dump($arr);
        $str = '';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str = $str . '<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
        $str = $str . '<thead><tr class="alt first last">';
        foreach ($arr as $key => $value) {

            $str = $str . '<th value="' . $value['Name'] . '" rel="' . $key . '">' . $value['Comment'] . '</th>';
        }

        $str = $str . '</thead></tr>';
        $str = $str . '<tbody>';
        $query = "Select * from " . $Table;
        $Res = $this->query($query);
        while ($data = $Res->fetch_row()) {
            $col--;
            if ($col1 == 1) {
                $str .= '<tr class="alt">';
                $col1--;
            } Else {
                $str .= '<tr class="">';
                $col1++;
            };

            foreach ($data as $key => $value) {
                if ($key == 0) {
                    $str .= '<td value="' . $value . '" >
                                <a href="?option=Defaul&Act=Edit&id=' . $value . '">' . $value . '</a> </td>';
                } else {
                    $str .= '<td value="' . $value . '" >' . $value . '</td>';
                }
            }
            $str .= '</tr>';
        }

        $str .= '</tbody></table>';
        echo $str;
    }

    //TO-DO ниже полная хрень ИПО элементы можно выделить в отдельные строки т.е. уменишить дублирование использовать UI
    function uiDinamicTableFieldGenerate($Type, $Name, $Label, $Value = '', $IdEdit = FALSE, $LinksField = Array()) {
        switch ($Type) {
            case 'varchar':
                return ' <div class="col_6 center">' . $Label . '<BR> <input name="' . $Name . '" value="' . $Value . '"> </div> ';
                break;
            case 'text':
                return $Label . ' <BR> ' . $this->uiTextArea($Name, $Value) . '</BR> </BR>'; // почти трушная реализаци To-DO вот так должно быть ВЕЗДЕ!!!
                break;
            case 'tinyint':
                return ' <div class="col_6 center">' . $Label . '<BR> <input name="' . $Name . '" value="' . $Value . '"> </div> ';
                break;
            case 'int':
                if ($Name <> 'Id' or $IdEdit == True) {
                    return ' <div class="col_6 center">' . $Label . '<BR> <input name="' . $Name . '" value="' . $Value . '"> </div> ';
                }
                break;
            case 'date':
                return ' <div class="col_6 center">' . $Label . '<BR> <input id="KD" class="KalDates" name="' . $Name . '" value="' . $Value . '"> </div> ';
                break;
            case 'datetime':
                return ' <div class="col_6 center">' . $Label . '<BR> <input class="KalDatesTimes" name="' . $Name . '" value="' . $Value . '"> </div> ';
                break;
        }
    }

    //TO-DO слишком все по тупому
    //TO-DO во первых все проверки ПОЛЯ вынести в отдельную функцию с возвратом труе или фалсе
    // проверки на названия полей и пустоту имени
    //TO-DO во вторых пусть юзер хоть пупок изорвет нужно объединить все массивы
    // $StructTable, tableHeadLocal, tableHead на придмет названия полей
    private function dynamicTableGenerated() {
        $StructTable = $this->GetStructTable($this->table);
        $data = '';
        //var_dump($_REQUEST);
        foreach ($StructTable as $key => $pole) {
            $fieldValue = '';
            if (isset($_REQUEST['RecordId'])) {
                //$RecordData = $this->GetValueFieldRecord($_REQUEST['Table'],'*',$_REQUEST['RecordId']);
                $recordData = $this->getValueFieldRecord($this->table, '*', $_REQUEST['RecordId']);
                $fieldValue = $recordData[$pole['Name']];
            }

            //var_dump($fieldValue);
            if (($pole['Name'] !== 'Id') and ( $pole['Name'] !== 'IdUserCreate')) {
                //приведение к нижнему регистру что бы пофиг как написаннно...
                $this->tableHeadLocal = array_map('strtolower', $this->tableHeadLocal);
                if (!empty($this->tableHeadLocal)) {
                    if (in_array(strtolower($pole['Name']), $this->tableHeadLocal)) {
                        if ($pole['Comment'] == '')
                            $data .=$this->uiDinamicTableFieldGenerate($pole['Type'], $pole['Name'], $this->tableHead[$pole['Name']], $fieldValue);
                        else
                            $data .=$this->uiDinamicTableFieldGenerate($pole['Type'], $pole['Name'], $pole['Comment'], $fieldValue);
                    }
                }
                else {
                    if (array_key_exists(strtolower($pole['Name']), $this->tableHead)) {
                        $data .=$this->uiDinamicTableFieldGenerate($pole['Type'], $pole['Name'], $this->tableHead[$pole['Name']], $fieldValue);
                    } else {
                        if ($pole['Comment'] !== '') {
                            $data .=$this->uiDinamicTableFieldGenerate($pole['Type'], $pole['Name'], $pole['Comment'], $fieldValue);
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function uiButtonAjax($ButtonType, $ButtonText) {
        return "<div class='col_3 ButtonUIAjax visible center' style='height: 25px;'> <a id='" . $ButtonType . "' title='" . $ButtonText . "'>" . $ButtonText . "</a></div>";
    }

    public function uiButtonActionAjax($ButtonAction, $ButtonLabel) {
        return "<div class='col_3 ButtonActionAjax visible center' Action='" . $ButtonAction . "' style='height: 25px;'> <a title='" . $ButtonLabel . "'>" . $ButtonLabel . "</a></div>";
    }

    public function uiTextArea($Name, $Data, $cols = 68, $Rows = 5) {
        return '<textarea name="' . $Name . '" cols="68" rows="5">' . $Data . '</textarea>';
    }

    public function uiLabel($Text) {
        return '<div>' . $Text . '</div>';
    }

    public function uiButtonSave() {
        return ' <input type="submit" name="SaveButton" value="Сохранить изменения" > ';
    }

    public function uiButtonCreate() {
        return ' <input type="submit" name="CreateButton" value="Создать запись" > ';
    }

    public function uiButtonClose() {
        return ' <input type="submit" name="CloseButton" value="Закрыть" > ';
    }

    protected function uiIdTableAction($CssSelector, $ActionLabel) {
        return ' <a class="' . $CssSelector . ' PointCursor">' . $ActionLabel . ' </a> </BR> ';
    }

}
