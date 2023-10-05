function check(form) 
{
	
	if ( (error_new_password.innerHTML == "") && (error_old_password.innerHTML == "") && (form.newpassword.value != "") && (form.oldpassword.value != ""))
		document.getElementById('button_password').disabled = false;
	else
		document.getElementById('button_password').disabled = true;
	
}


oldpassword.onblur = function() 
{
    let regexp = /^[A-z][A-z0-9]{3,}$/;
    if (!regexp.test(oldpassword.value)) 
    {
        oldpassword.classList.add('invalid');
        error_old_password.innerHTML = 'Пароль должен содержать цифры, заглавные и строчные буквы. Не меньше 6 символов'
    }
};

oldpassword.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_old_password.innerHTML = "";
    }
};

newpassword.onblur = function() 
{
    let regexp = /^[A-z][A-z0-9]{3,}$/;
    if (!regexp.test(newpassword.value)) 
    {
        newpassword.classList.add('invalid');
        error_new_password.innerHTML = 'Пароль должен содержать цифры, заглавные и строчные буквы. Не меньше 6 символов'
    }
};

newpassword.onfocus = function() 
{
    if (this.classList.contains('invalid')) 
    {
        // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
        this.classList.remove('invalid');
        error_new_password.innerHTML = "";
    }
};

  

