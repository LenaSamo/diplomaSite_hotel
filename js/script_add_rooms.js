/*проверка кол-ва гостей в номере*/
number_of_guests.onblur = function() 
{
    let regexp = /^\d$/;
    if (!regexp.test(number_of_guests.value)) 
    {
        number_of_guests.classList.add('invalid');
        error_number_of_guests.innerHTML = 'Пожалуйста, введите правильно кол-во гостей(это должно быть число)'
    }
};

number_of_guests.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_number_of_guests.innerHTML = "";
    }
};