const editorContainer = document.querySelector('#editor');
const editUserBtn = document.querySelectorAll('.edit_user_btn');
const editScriptBtn = document.querySelectorAll('.edit_script_btn');
const editServerBtn = document.querySelectorAll('.edit_server_btn');
const cancelBtn = document.querySelector('#cancel_btn');

const handleButtons = () => {
    editScriptBtn.forEach(button => {
        button.addEventListener('click', function(){
            const scriptItem = this.closest('.script-item');
            const scriptId = scriptItem.querySelector('.script_id_value').value;
            const scriptName = scriptItem.querySelector('.script_name_value').textContent;
            const scriptType = scriptItem.querySelector('.script_type_value').textContent;
            const scriptContent = scriptItem.querySelector('.script_content_value').textContent;

            const idInput = document.querySelector('#input_scr_id');
            const nameInput = document.querySelector('#input_scr_name');
            const typeInput = document.querySelector('#input_scr_type');
            const contentTextArea = document.querySelector('#input_scr_content');

            idInput.value = scriptId;
            nameInput.value = scriptName;
            typeInput.value = scriptType;
            contentTextArea.value = scriptContent;
        })
    })

    editServerBtn.forEach(button => {
        button.addEventListener('click', function(){
            const serverItem = this.closest('.server-item');
            const serverId = serverItem.querySelector('#server_id_value').value;
            const scriptHostname = serverItem.querySelector('#server_hostname_value').textContent;
            const scriptIpAddress = serverItem.querySelector('#server_ipAddress_value').textContent;
            const scriptDescription = serverItem.querySelector('#server_description_value').textContent;

            const idInput = document.querySelector('#input_ser_id');
            const hostnameInput = document.querySelector('#input_ser_hostname');
            const ipAddressInput = document.querySelector('#input_ser_ipaddress');
            const descriptionInput = document.querySelector('#input_ser_description');

            idInput.value = serverId;
            hostnameInput.value = scriptHostname;
            ipAddressInput.value = scriptIpAddress;
            descriptionInput.value = scriptDescription;
            
        })
    })

    // In user_list it checks if the form is empty, in that case the button will create the user, otherwise it will modify it.
    document.addEventListener('DOMContentLoaded', function() {
        const userListForm = document.querySelector('#user-list-form');
        const userFormButton = document.querySelector('#user-form-button');
        const editUserBtns = document.querySelectorAll('.edit_user_btn');
        const cancelEditUserBtn = document.querySelector('#user-form-cancel-button');
    
        editUserBtns.forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.preventDefault();
    
                // Cambiar el botón a "Actualizar usuario"
                userFormButton.name = "update_user";
                userFormButton.textContent = "Actualizar usuario";
    
                const row = btn.closest('tr');
                const userID = row.querySelector('#usr_id').value;
                const userName = row.querySelector('.tble-username').textContent;
                const userEmail = row.querySelector('.tble-email').textContent;
                const userAdmin = row.querySelector('input[type="hidden"]').value === 'S';
    
                // Rellenar el formulario con los datos del usuario
                const idInput = document.querySelector("#input_usr_id");
                const usernameInput = document.querySelector('#input_usr_name');
                const emailInput = document.querySelector('#input_usr_email');
                const adminInput = document.querySelector('#input_usr_admin');

                idInput.value = userID;
                usernameInput.value = userName;
                emailInput.value = userEmail;
                

                cancelEditUserBtn.addEventListener('click', function() {
                    userFormButton.name = "create_user";
                    userFormButton.textContent = "Crear usuario";

                    document.querySelector('#user-list-form').reset();
                })
            });
        });
    
        // Por defecto, el botón es "Crear usuario"
        userFormButton.name = "create_user";
        userFormButton.textContent = "Crear usuario";
    });
        

    cancelBtn.addEventListener('click', function() {
        editorContainer.querySelector('form').reset();
    })
}

const init = () => {
    handleButtons();
}

init();
