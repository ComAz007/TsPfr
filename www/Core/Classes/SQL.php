//���������
SELECT count(id)
FROM `jurvipnetzapros`
WHERE `Napravl` =0
AND `SpNap` =0

//��������
SELECT count(id)
FROM `jurvipnetzapros`
WHERE `Napravl` =1
AND `SpNap` =0

//�� ��������
SELECT count(id)
FROM `jurvipnetzapros`
WHERE `Kontrol` =1
AND `SpNap` =0

