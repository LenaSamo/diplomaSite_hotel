function unblockreferences(form)
{
    if (form.approval.checked == true 
    && form.email.validity.valid 
    && form.surname.validity.valid 
    && form.patronymic.validity.valid 
    && form.log.validity.valid 
    && form.phone.validity.valid
    && form.password1.validity.valid 
    && form.password2.validity.valid)
    {
        document.getElementById('Register_Person').disabled = false;
       
    }
    else document.getElementById('Register_Person').disabled = true;
}


/*проверка login*/
log.onblur = function() 
{
    let regexp = /^[A-z]{1,20}|[А-я]{1,20}$/;
    if (!regexp.test(log.value)) 
    {
        log.classList.add('invalid');
        error_name.innerHTML = 'Пожалуйста, введите правильно имя'
    }
};

log.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_name.innerHTML = "";
    }
};
/*проверка surname*/
surname.onblur = function() 
{
    let regexp = /^[A-я]{1,50}$/;
    if (!regexp.test(surname.value)) 
    {
        surname.classList.add('invalid');
        error_surname.innerHTML = 'Пожалуйста, введите правильно фамилию'
    }
};

surname.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_surname.innerHTML = "";
    }
};
/*проверка patronymic*/
patronymic.onblur = function() 
{
    let regexp = /^[A-я]{1,50}$/;
    if (!regexp.test(patronymic.value)) 
    {
        patronymic.classList.add('invalid');
        error_patronymic.innerHTML = 'Пожалуйста, введите правильно отчество'
    }
};

patronymic.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_patronymic.innerHTML = "";
    }
};

/*проверка email*/
email.onblur = function() 
{
    let regexp = /^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/;
    if (!regexp.test(email.value)) 
    { 
        email.classList.add('invalid');
        error_email.innerHTML = 'Пожалуйста, введите правильный email.';
    }
};

email.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_email.innerHTML = "";
    }
};

/*проверка phone*/
// phone.onblur = function() 
// {
//     let regexp = /^(8|\+7)\d{10}$/;
//     if (!regexp.test(phone.value)) 
//     { 
//         phone.classList.add('invalid');
//         error_phone.innerHTML = 'Пожалуйста, введите правильный телефон.'
//     }
// };

// phone.onfocus = function() 
// {
//     if (this.classList.contains('invalid')) 
//     {
//         // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
//         this.classList.remove('invalid');
//         error_phone.innerHTML = "";
//     }
// };

/*проверка пороля*/
password1.onblur = function() 
{
    let regexp = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/;
    if (!regexp.test(password1.value)) 
    { 
        password1.classList.add('invalid');
        error_password1.innerHTML = 'Пароль должен содержать цифры, заглавные и строчные буквы. Не меньше 6 символов'
    }
    else if (!password1.value.includes(password2.value)) 
    { 
        password2.classList.add('invalid');
        error_password2.innerHTML = 'Пороли не совпадают'
    }
};
password1.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_password1.innerHTML = "";
    }
};

password2.onblur = function() 
{
    
    if (!password2.value.includes(password1.value)) 
    { 
        password2.classList.add('invalid');
        error_password2.innerHTML = 'Пороли не совпадают'
    }
};

password2.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_password2.innerHTML = "";
    }
};