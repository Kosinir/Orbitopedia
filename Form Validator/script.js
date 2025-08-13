document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reg-form');
    const errorSummary = document.getElementById('error-summary');
    const fields = form.querySelectorAll('input, textarea');

    function ValidateField(field){
        let field_id = field.id;
        let errorStar = document.getElementById(field_id + '-error');
        let errorMessage = '';

        if(field_id==='f_name'){
           if (field.value.trim() === '') {
                errorMessage = 'Name is required.';
            }
        }

        if(field_id==='f_lastname'){
            if(field.value.trim() === ''){
                errorMessage = 'Last name is required.';
            }
        }

        if(field_id==='f_email'){
            const RegExp = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if(field.value.trim() === '') {
                errorMessage = 'Email is required.';
            }
            else if(RegExp.test(field.value.trim()) === false){
                errorMessage = 'Invalid Email';
            }
        }

        if (field.id === 'f_birth') {
            const currentDate = new Date();
            const inputDate = new Date(field.value);
            const currentYear = currentDate.getFullYear();
            const inputYear = inputDate.getFullYear();
        
            if (field.value === '') {
                errorMessage = 'Date of birth is required.';
            } 
            else if (isNaN(inputDate.getTime())) {
                errorMessage = 'Invalid date format.';
            } 
            else if (inputDate > currentDate) {
                errorMessage = 'Date of birth cannot be in the future.';
            } 
            else if (inputDate < 1900) {
                errorMessage = 'Surely you are not that old';
            } 
            else if (currentYear - inputYear < 13) {
                errorMessage = 'You must be at least 13 years old.';
            }
        }
        

        if(field_id === 'f_password'){
            const RegExp =/[0-9]/g;
            if(field.value.length < 8){
                errorMessage = 'Password is too short (minimum 8 characters and 1 number)'
            } 
            if(field.value.match(RegExp) === false)
                {
                errorMessage = 'Password requirers atleast 1 number.';
            }

        }

        if(field_id==='f_confirm_password'){
            const password = document.getElementById('f_password').value;
            if(field.value.trim() !== password){
                errorMessage = 'Passwords do not match.';
            }
        }

        if(errorMessage !== ''){
            field.classList.add('error');
            if(errorStar) errorStar.textContent = '*';
        }
        else{
            field.classList.remove('error');
            if(errorStar) errorStar.textContent = '';
        }
        return errorMessage;
    }

        fields.forEach(field => {
            field.addEventListener('blur', () => ValidateField(field));
        });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        let errorMessages = [];

        fields.forEach(field => {
            const error = ValidateField(field);
            if(error){
                errorMessages.push(error);
            }
        });

        if (errorMessages.length > 0){
            errorSummary.innerHTML = 
                errorMessages.map(msg => `<p>${msg}</p>`).join('');
            errorSummary.style.display = 'block';
        }
        else{
            errorSummary.style.display = 'none';
            alert('Form submitted successfully!');
        }
    });
});