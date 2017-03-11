 <div class="col_12 NoPrint1 visible center " >

        <div class="col_8"><Center><H4> <a href='Index.php' title='Техническая поддержка пользователя'>Техническая поддержка пользователя</a>
</H4></Center>
            
        
        </div>
     
     <?Php
 echo '<div class="col_2"> <Center> Авторизован: </BR> <B>'.$_SESSION['FIO'].'</b><Center></div>';?>
     
        <div class="col_2"><Form></BR><button class="Medium" name="exit"> <i class='fa fa-sign-out'></i>Выход</button></Form></div>
        
        
    </div>

 <div class="col_12 NoPrint1" >
<!-- Menu Horizontal -->
<ul class="menu">
<?Php

echo '<li> <a href="/?option=viewJurTS">Задачи</a></li>';
//echo '<a href="/?option=viewJurTS">Задачи</a></li>';



If ($_GET['option']=='Jurnals'){
    echo '<li class="current"> <a href="?option=Jurnals"> ';
}
else {
    echo '<li> <a href="?option=Jurnals">';
}
        
    echo 'Электронные Журналы </a>'
        ?>
    <ul>
        <li> <a href="/?option=viewJurVipnet">Регистрации запросов(463р)</a></li>
         <li> <a href="/?option=viewJurEsia">Регистрации заявлений для доступа к ЕСИА</a></li>
         <li> <a href="/?option=viewJurPStZ">Регистрации запросов подтверждения стажа</a></li>
         <li> <a href="/?option=viewJurObrEVD">Журнал обработки запросов загрузки ЭВД</a></li>
          <li> <a href="/?option=viewJurTruZp">Регистрации запросов подтверждения заработка</a></li>         
    </ul>
</li>

<?Php
    If ($_SESSION['Admin']=='1')
            Echo '
                

    
</li>

<li><a href="">Сопровождение ИТ</a>
    <ul>
	<li><a href="/?option=viewJurTechnical"><i class="fa fa-cog"></i> Техника</a></li>
        <li><a href="">ОЗИ</a>
            <ul>
                <li><a href="/?option=viewJurOZIKD">Журнал карточек ПТК</a></li>
                <li><a href="">Заявки на доступ</a></li>
                <li><a href="">Журнал списков доступа</a></li>
            </ul>
        </li>
     </ul>
</li>

<li><a href=""><i class="fa fa-inbox"></i> Администрирование</a>
	<ul>
	<li><a href=""><i class="fa fa-cog"></i> Настройки</a></li>
	<li><a href=""><i class="fa fa-envelope"></i> Справочники</a>
            <ul style="min-width: 170px">
		<li><a href="/?option=sprUsers"><i class="fa fa-wrench"></i> Пользователи</a></li>
                <li><a href="/UsersMain.php"><i class="fa fa-wrench"></i> Пользователи(OLD)</a></li>
                
                
                <li><a href=""><i class="fa fa-camera-retro"></i> Права доступа</a></li>
		<li><a href=""><i class="fa fa-coffee"></i> Отделы</a></li>
		<li><a href=""><i class="fa fa-twitter"></i> ПО и роли</a></li>
		</ul>
	</li>
	<li class="divider"><a href=""><i class="fa fa-trash"></i> li.divider</a></li>
	</ul>

</li>

'; ?>		
</ul>
</div>

<!-- Begin MainContent-->
<div class="MainContent col_12">
