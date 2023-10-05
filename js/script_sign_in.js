
// /*проверка почты или номера телефона*/
// email_or_num.onblur = function() 
// {
//     let regexp1 = /^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/;
//     let regexp2 = /^(8|\+7)\d{10}$/;
//     if (!regexp1.test(email_or_num.value) && !regexp2.test(email_or_num.value)) 
//     {
//         email_or_num.classList.add('invalid');
//         error.innerHTML = 'Пожалуйста, введите правильно почту или номер'
//     }
// };

// email_or_num.onfocus = function() 
// {
//     if (this.classList.contains('invalid')) 
//     {
//         // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
//         this.classList.remove('invalid');
//         error.innerHTML = "";
//     }
// };
/*проверка пороля*/
password.onblur = function() 
{
    let regexp = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/;
    if (!regexp.test(password.value)) 
    { 
        password.classList.add('invalid');
        error_passwordform.innerHTML = 'Пароль должен содержать цифры, заглавные и строчные буквы. Не меньше 6 символов'
    }
    
};
password.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_passwordform.innerHTML = "";
    }
};