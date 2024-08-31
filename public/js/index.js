const endPoint = 'http://127.0.0.1:8000/'
const data = document.getElementById('user-id');
const form_tasks = document.getElementById('form-task');

const userId = data.dataset.id;

//Selecciona todos los elementos con la clase 'no-edit'
const task = document.querySelectorAll('.no-edit');

//Cargo las tareas por usuario
uploadTasks();

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
                                <button class="btn btn-primary" data-id="${task.id}">Guardar</button>
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









