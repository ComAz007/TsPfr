<?php
class TechSupport extends Acore_A{
       
    
      public function MainContent(){
	       $this->EPCreate(); 
	
          Echo "<form enctype='multipart/form-data' action='?option=TechSupport' method='Post'>";
	
	
         Echo "<p><input type='submit' name='EP' value='ВАрхив'>";
          //Echo "<p><input type='submit' name='EP' value='ProverkaEP1' onClick='SendGet()' >";
          Echo "</form>";
          //Echo '<div id="your-files"> mmm </div>';
          
         Echo ' <script>
var target = document.getElementById("your-files");
target.addEventListener("dragover", function(event) {
    event.preventDefault(); // отменяем действие по умолчанию
}, false);
target.addEventListener("drop", function(event) {
    // отменяем действие по умолчанию
    event.preventDefault();
    var i = 0,
     files = event.dataTransfer.files,
     len = files.length;
     for (; i < len; i++) {
          console.log("Filename: " + files[i].name);
          console.log("Type: " + files[i].type);
          console.log("Size: " + files[i].size + " bytes");
     }
}, false);
</script>';
        //exec('unoconv -f html D:/_ElArx/test1.xlsx -o D:/_ElArx/Peres/' , $output);
        //exec('D:\_ElArx\201520160405160525.pdf');
        //echo $this->readDocx($filePath);
        echo '<div class="col_12 column">';
        echo '<a href="?option=TechSupport"><H6> Обновленная ТП </H6></a>';
        echo '</div>';
 Echo '       
<ul class="tabs left">
<li><a href="#tabr2">Задания открытые</a></li>
<li><a href="#tabr1">Все задания</a></li>
<li><a href="#tabr3">Задания исполненные</a></li>
</ul>';

Echo '<div id="tabr2" class="tab-content">';
Echo '<div class="col_3 visible center" style="height: 25px;"> <a href="AddZadan.php" title="Создать задание">Создать задание</a></div> </Br></Br></Br>
  <div id="content"></div>';
Echo '</div>';

                Echo ('<div id="tabr1" class="tab-content">');
               // echo "<div class='col_12'>";
                

                If ($_SESSION['Status']!='1' and $_SESSION['Admin']!='1')
                Echo TableOut(0,$dats,$_SESSION['Id_user'],'');
                Else

                Echo TableOut(0,'','',pagination1());
                echo '</Br>';

                Echo ('</div>'); // id="tabr1" class="tab-content"
                
                
                
                Echo ('<div id="tabr3" class="tab-content">'); 
                    If ($_SESSION['Status']!='1' and $_SESSION['Admin']!='1')
                    Echo TableOut(2,'',$_SESSION['Id_user'],'');
                    Else
                    Echo TableOut(2,'','','');
                Echo ('</div>');
            
           
            
            unset($_SESSION['Message']);   
}
function obr() {
    IF (isset($_POST['EP'])) {
//echo'CreateZIP()';
        $this->CreateZIP();
        }
}
    
}