document.addEventListener('DOMContentLoaded', () =>{
    const table = document.getElementById('dynamic-table');
    const tbody = table.querySelector('tbody');
    let row_count = document.getElementById('row-count');
    const add_button = document.getElementById('add-row-button');
    const delete_button = document.getElementById('delete-row-button');
    const STORAGE_KEY = 'dynamicTableData';
    const menu = document.getElementById('menu');
    const Mode_button = document.getElementById('mode');
    const mainBody = document.getElementById('main-body');
    const table_container = document.getElementById('table-container');

    //Counting total rows
    function UpdateRowCount(){
        row_count.textContent = tbody.querySelectorAll('tr').length;
    }
    //Saveing current table to local JSON
    function SaveToLocal(){
        const rows = Array.from(tbody.querySelectorAll('tr')).map(row => {
            const cells = row.querySelectorAll('td');
            return{
                col1: cells[1].textContent,
                col2: cells[2].textContent,
                col3: cells[3].textContent,
                col4: cells[4].textContent,
            };
        });
        localStorage.setItem(STORAGE_KEY, JSON.stringify(rows));
    }
    //Loading table from local JSON
    function LoadFromLocal(){
        const savedData = localStorage.getItem(STORAGE_KEY);
        if(savedData){
            const rows = JSON.parse(savedData);
            rows.forEach(data=>CreateRow(data.col1, data.col2, data.col3, data.col4));
        }
    }

    //Creating Row and updateing count number
    function CreateRow(content1 = 'Something 1', content2 = 'Something 2', content3 = 'Something 3', content4 = 'Something 4'){
        const tr = document.createElement('tr');
        //Checkbox
        const checkboxCell = document.createElement('td');
        checkboxCell.classList.add('checkbox-column');
        checkboxCell.innerHTML = `<input type="checkbox" class="row-checkbox">`;
        tr.appendChild(checkboxCell);
        //Col 1
        const col1 = document.createElement('td');
        col1.textContent = content1;
        col1.setAttribute('contenteditable', 'true');
        tr.appendChild(col1);
        //Col 2
        const col2 = document.createElement('td');
        col2.textContent = content2;
        col2.setAttribute('contenteditable', 'true');
        tr.appendChild(col2);
        //Col 3
        const col3 = document.createElement('td');
        col3.textContent = content3;
        col3.setAttribute('contenteditable', 'true');
        tr.appendChild(col3);
        //Col 4
        const col4 = document.createElement('td');
        col4.textContent = content4;
        col4.setAttribute('contenteditable', 'true');
        tr.appendChild(col4);
        
        //Col Action
        const actionCell = document.createElement('td');
        actionCell.innerHTML = `
            <button class="action-button move-up">↑</button>
            <button class="action-button move-down">↓</button>
            <button class="action-button delete-row">Delete</button>
        `;
        tr.appendChild(actionCell);
        
        tbody.appendChild(tr);
        UpdateRowCount();
        SaveToLocal();
    }
    //Add button function
    add_button.addEventListener('click', ()=>{
        CreateRow();
    });
    //Delete button function
    delete_button.addEventListener('click', ()=>{
        const selectedRow = tbody.querySelectorAll('.row-checkbox:checked');
        selectedRow.forEach(checkbox => checkbox.closest('tr').remove());
        UpdateRowCount();
        SaveToLocal();
    });

    tbody.addEventListener('click', (event)=>{
        const target = event.target;
        const target_row = target.closest('tr');
        //Action Delete
        if(target.classList.contains('delete-row')){
            target_row.remove();
            UpdateRowCount();
        }
        //Action Page Up
        if(target.classList.contains('move-up')){
            if(target_row.previousElementSibling){
                tbody.insertBefore(target_row, target_row.previousElementSibling);
            }
        }
        //Action Page Up
        if(target.classList.contains('move-down')){
            if(target_row.nextElementSibling){
                tbody.insertBefore(target_row.nextElementSibling, target_row);
            }
        }
        SaveToLocal();
    });
    //Side menu function
    window.toggleNav = function toggleNav() {
        var menu = document.getElementById("menu");
        if (menu.style.width === "250px") {
            menu.style.width = "0";
        } 
         else {
            menu.style.width = "250px"; 
        }
    }

    menu.addEventListener('click', () =>{
        toggleNav();
    });

    document.addEventListener('DOMContentLoaded', () => {
        window.toggleNav = function toggleNav() {
            var menu = document.getElementById("menu");
            if (menu.style.width === "250px") {
                menu.style.width = "0";
            } else {
                menu.style.width = "250px";
            }
        };
    });
    
    //Dark/Light mode
    function ModeToogle() {
        document.body.classList.toggle('dark-mode');
        mainBody.classList.toggle('dark-mode');
        table_container.classList.toggle('dark-mode');

        if (document.body.classList.contains('dark-mode')) {
            Mode_button.textContent = "Light Mode";
        } 
        else {
            Mode_button.textContent = "Dark Mode";
        }
    }

    Mode_button.addEventListener('click', ModeToogle);

    LoadFromLocal();

    //FORM

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