UPDATE `zgloszenia` SET `sygnatura` = concat(`id`, '/', month(`czas_wprowadzenie`), '/', year(`czas_wprowadzenie`), '/RN');