//Исходящие
SELECT count(id)
FROM `jurvipnetzapros`
WHERE `Napravl` =0
AND `SpNap` =0

//Входящие
SELECT count(id)
FROM `jurvipnetzapros`
WHERE `Napravl` =1
AND `SpNap` =0

//На контроле
SELECT count(id)
FROM `jurvipnetzapros`
WHERE `Kontrol` =1
AND `SpNap` =0

