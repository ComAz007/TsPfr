<?php

class Jurnals extends Acore_A {

    protected function getTypeZ($type) {
        $arrays = array(
            0 => 'ИСХД',
            1 => 'ВХДИ',
            2 => 'ПЕРЕ'
        );
        return $arrays[$type];
    }

    protected function getEsNo($type) {
        $arrays = array(
            0 => 'Нет',
            1 => 'Да',
        );
        return $arrays[$type];
    }

    protected function getTypeZ2($type) {
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

    protected function getTypeZ1($type) {
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
            0 => 'СТАЖ',
            1 => 'З/ПЛ',
            2 => 'СТАЖ И З/ПЛ',
            3 => 'АКТ ПРОВЕРКИ',
            4 => 'ДРУГОЕ'
        );
        return $arrays[$type];
    }

    protected function getTypeZ4($type) {
        $arrays = array(
            0 => 'VipNet',
            1 => 'ПОЧТА'
        );
        return $arrays[$type];
    }

    protected function getESIA($type, $getSet = 0) {
        //static function getESIA($type,$getSet=0) {
        $arrays = array(
            1 => 'Регистрация',
            2 => 'Подтверждение',
            3 => 'Восстановление доступа',
            4 => 'Удаление'
        );

        If ($getSet == 1) {
            $arrays = array_flip($arrays);
        }

        If ($getSet == 2) {
            return $arrays;
        } else {
            return $arrays[$type];
        }
    }

    protected function getPTK($type, $getSet = 0) {
        //static function getESIA($type,$getSet=0) {
        $arrays = array(
            1 => 'ПТК СПУ(РАЙОН)',
            2 => 'ПТК СПУ(РЕГИОН)',
            3 => 'Locopr',
            4 => 'РК АСВ',
            5 => 'БПИ',
            6 => 'ПК ПЕРСО',
            7 => 'ПТК АСВ',
            8 => 'ПТК Страхователь',
            9 => 'ПТК КСиУПД',
            10 => 'ПК СМЭВ',
            11 => 'АРМ КОНВЕРТАЦИЯ',
            12 => 'Выплата СПН',
            13 => 'ОГБД Ветераны'
        );

        If ($getSet == 1) {
            $arrays = array_flip($arrays);
        }

        If ($getSet == 2) {
            return $arrays;
        } else {
            return $arrays[$type];
        }
    }

    protected function getRegion($type, $getSet = 0) {
        $arrays = array(
            1 => 'Наш регион',
            0 => 'Не наш'
        );

        If ($getSet == 1) {
            $arrays = array_flip($arrays);
        }

        If ($getSet == 2) {
            return $arrays;
        } else {
            return $arrays[$type];
        }
    }

    protected function rdate($param, $time = 0) {
        if (intval($time) == 0)
            $time = time();
        $monthNames = array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        if (strpos($param, 'M') === false)
            return date($param, $time);
        else
            return date(str_replace('M', $monthNames[date('n', $time) - 1], $param), $time);
    }

    public function MainContent() {
        //echo 'в лог идет: '+$this->LogMsg;
        echo '<div class="col_12 column">';
        echo '<p><a href="?option=viewJurVipnet" class="LocalMenu"><H6> Журнал регистрации направления поступления и исполнения запросов (Распоряжение Правления ПФР 463Р от 06.10.2015)</H6></a></p>';
        echo '<p><a href="?option=viewJurEsia" class="LocalMenu"><H6> Журнал регистрации заявлений на регистрацию, подтверждение, удаление, восстановление доступа к учетной записи пользователя в Единой системе идентификации и аутентификации в инфраструктуре, обеспечивающей информационно-технологическое взаимодействие информационных систем, используемых для предоставления государственных и муниципальных услуг в электронной форме</H6></a></p>';
        echo '</div>';
    }

}
