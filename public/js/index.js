const endPoint = 'http://127.0.0.1:8000/'
const data = document.getElementById('user-id');
const form_tasks = document.getElementById('form-task');

const userId = data.dataset.id;

//Selecciona todos los elementos con la clase 'no-edit'
const task = document.querySelectorAll('.no-edit');

//Cargo las tareas por usuario
uploadTasks();

//Formulario para nuevas tareas
form_tasks.addEventListener('submit', (event) => {
    event.preventDefault();
    const task = document.getElementById('new-task');

    //Petición POST para el guardado de nuevas tareas
    fetch(endPoint + 'index', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            task: task.value,
            id: userId
        })
    })
        .then(response => response.json())
        .then(data => {
            task.value = '';
            uploadTasks(); //Carga de nuevo todas la tareas.
        })
        .catch(error => console.error('Error:', error));
})

function editTask(button) {
    const task = document.getElementById('task' + button.dataset.id);
    const btn = document.getElementById('btn' + button.dataset.id);
    const btn_edit = document.getElementById('btn-edit' + button.dataset.id);

    btn.classList.toggle('d-none')
    btn_edit.classList.toggle('d-none')
    task.removeAttribute('disabled');
}

function cancelEditTask(button) {
    const task = document.getElementById('task' + button.dataset.id);
    const btn = document.getElementById('btn' + button.dataset.id);
    const btn_edit = document.getElementById('btn-edit' + button.dataset.id);

    btn.classList.toggle('d-none')
    btn_edit.classList.toggle('d-none')
    task.disabled = true
}

//Función para cargar las tareas.
function uploadTasks() {
    fetch(endPoint + 'index/' + userId, {
        method: 'get',
    })
        .then(response => response.json())
        .then(data => {
            let task = document.getElementById('list-task');
            let task_list = '';

            //Recorro todas las tareas obtenidas y las escribo en el contenedor de tareas
            data.data.forEach(task => {
                task_list += `
            <div class="p-2 border rounded-1">
                        <div class="row">
                            <div class="col-md-9 col-12 text-start mt-1">
                                <input disabled value="${task.task}" type="text" id="task${task.id}" name="task" class="form-control no-edit">
                            </div>
                            <div id="btn${task.id}" class="col-md-3 col-12 text-center mt-1">
                            <button class="btn btn-warning" data-id="${task.id}" onclick="editTask(this)">Editar</button>
                                <button class="btn btn-danger" data-id="${task.id}"  onclick="deleteTask(this)">Eliminar</button>
                            </div>
                            <div id="btn-edit${task.id}" class="col-md-3 col-12 text-center mt-1 d-none">
                                <button class="btn btn-primary" data-id="${task.id}" onclick="updateTask(this)">Guardar</button>
                                <button class="btn btn-danger" data-id="${task.id}" onclick="cancelEditTask(this)">Cancelar</button>
                            </div>
                        </div>
                    </div>
        `;
            });
            task.innerHTML = task_list;
        })
        .catch(error => console.error('Error:', error));
}

function deleteTask(task) {
    fetch(endPoint + 'index/' + task.dataset.id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
        .then(response => response.json())
        .then(data => {
            uploadTasks();
        })
        .catch(error => console.error('Error:', error));
}

function updateTask(task) {
    const task_input = document.getElementById('task' + task.dataset.id);
    console.log('Te')
    fetch(endPoint + 'index/' + task.dataset.id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            task: task_input.value
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            uploadTasks();
        })
        .catch(error => console.error('Error:', error));
}

// function msgAlert(msg, process) {
//     const containerMsg = document.getElementById('container-msg');
//     let msg = ''
//     if (process === 'success') {
//         msg = `<div class="icon me-2">
//         <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="34" height="34" viewBox="0 0 50 50"
//             style="fill:#40C057;">
//             <path
//                 d="M 25 2 C 12.309534 2 2 12.309534 2 25 C 2 37.690466 12.309534 48 25 48 C 37.690466 48 48 37.690466 48 25 C 48 12.309534 37.690466 2 25 2 z M 25 4 C 36.609534 4 46 13.390466 46 25 C 46 36.609534 36.609534 46 25 46 C 13.390466 46 4 36.609534 4 25 C 4 13.390466 13.390466 4 25 4 z M 34.988281 14.988281 A 1.0001 1.0001 0 0 0 34.171875 15.439453 L 23.970703 30.476562 L 16.679688 23.710938 A 1.0001 1.0001 0 1 0 15.320312 25.177734 L 24.316406 33.525391 L 35.828125 16.560547 A 1.0001 1.0001 0 0 0 34.988281 14.988281 z">
//             </path>
//         </svg>
//     </div>
//     <div class="msg">
//         ${msg}
//     </div>`;
//     } else {
//         msg = `<div class="icon me-2">
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
//   <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
//   <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
// </svg>
//     </div>
//     <div class="msg">
//         ${msg}
//     </div>`;
//     }
// }









