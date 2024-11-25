// Obtener los datos de clientes desde el localStorage o crear un array vacío
let clients = JSON.parse(localStorage.getItem('clients')) || [
    { id: 1, nombre: "Juan Pérez", email: "juan.perez@mail.com", telefono: "123456789", estadoProyecto: "En ejecución" },
    { id: 2, nombre: "María López", email: "maria.lopez@mail.com", telefono: "987654321", estadoProyecto: "Finalizado" },
];

// Selección de elementos HTML
const clientsTableBody = document.querySelector("#clients-table");
const addClientBtn = document.querySelector("#add-client-btn");
const clientFormModal = document.querySelector("#client-form-modal");
const clientForm = document.querySelector("#client-form");
const closeModalBtn = document.querySelector("#close-modal-btn");
const refreshBtn = document.querySelector("#refresh-btn"); // Botón de actualización

// Renderizar clientes en la tabla
function renderClients() {
    clientsTableBody.innerHTML = ""; // Limpiar tabla
    clients.forEach((client) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${client.id}</td>
            <td>${client.nombre}</td>
            <td>${client.email}</td>
            <td>${client.telefono}</td>
            <td><input type="text" class="estado-proyecto" data-id="${client.id}" value="${client.estadoProyecto}" /></td>
            <td>
                <button class="btn-edit" data-id="${client.id}">Editar</button>
                <button class="btn-delete" data-id="${client.id}">Eliminar</button>
            </td>
        `;
        clientsTableBody.appendChild(row);
    });
    attachEventListeners(); // Reasignar eventos
}

// Mostrar el formulario para agregar/editar un cliente
function showClientForm(client = null) {
    if (client) {
        clientForm["id"].value = client.id;
        clientForm["nombre"].value = client.nombre;
        clientForm["email"].value = client.email;
        clientForm["telefono"].value = client.telefono;
    } else {
        clientForm.reset();
    }
    clientFormModal.style.display = "flex";  // Cambiar display para centrar el modal
}

// Ocultar el formulario modal
function closeClientForm() {
    clientFormModal.style.display = "none";
}

// Guardar cliente (nuevo o editado)
function saveClient(event) {
    event.preventDefault();

    const id = parseInt(clientForm["id"].value);
    const nombre = clientForm["nombre"].value;
    const email = clientForm["email"].value;
    const telefono = clientForm["telefono"].value;

    if (id) {
        // Editar cliente existente
        const clientIndex = clients.findIndex((client) => client.id === id);
        if (clientIndex !== -1) {
            clients[clientIndex] = { id, nombre, email, telefono, estadoProyecto: clients[clientIndex].estadoProyecto }; // Mantener estado
        }
    } else {
        // Agregar nuevo cliente
        const newId = clients.length > 0 ? clients[clients.length - 1].id + 1 : 1;
        clients.push({ id: newId, nombre, email, telefono, estadoProyecto: "En ejecución" });
    }

    localStorage.setItem('clients', JSON.stringify(clients)); // Guardar los cambios en localStorage
    renderClients(); // Actualizar la tabla
    closeClientForm(); // Cerrar el modal
}

// Eliminar cliente
function deleteClient(id) {
    const clientIndex = clients.findIndex((client) => client.id === id);
    if (clientIndex !== -1) {
        clients.splice(clientIndex, 1);
        localStorage.setItem('clients', JSON.stringify(clients)); // Guardar los cambios en localStorage
        renderClients(); // Actualizar la tabla
    }
}

// Actualizar el estado del proyecto
function updateProjectStatus(id, newStatus) {
    const clientIndex = clients.findIndex((client) => client.id === id);
    if (clientIndex !== -1) {
        clients[clientIndex].estadoProyecto = newStatus;
        localStorage.setItem('clients', JSON.stringify(clients)); // Guardar los cambios en localStorage
    }
}

// Adjuntar eventos a botones dinámicos
function attachEventListeners() {
    // Botones de edición
    document.querySelectorAll(".btn-edit").forEach((button) => {
        button.addEventListener("click", (event) => {
            const clientId = parseInt(event.target.dataset.id);
            const client = clients.find((client) => client.id === clientId);
            if (client) {
                showClientForm(client);
            }
        });
    });

    // Botones de eliminación
    document.querySelectorAll(".btn-delete").forEach((button) => {
        button.addEventListener("click", (event) => {
            const clientId = parseInt(event.target.dataset.id);
            if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {
                deleteClient(clientId);
            }
        });
    });

    // Actualizar estado del proyecto
    document.querySelectorAll(".estado-proyecto").forEach((input) => {
        input.addEventListener("change", (event) => {
            const clientId = parseInt(event.target.dataset.id);
            const newStatus = event.target.value;
            updateProjectStatus(clientId, newStatus);
        });
    });
}

// Función para actualizar la tabla sin recargar la página
function refreshTable() {
    renderClients(); // Renderiza los clientes nuevamente
}

// Eventos principales
addClientBtn.addEventListener("click", () => showClientForm());
closeModalBtn.addEventListener("click", closeClientForm);
clientForm.addEventListener("submit", saveClient);
refreshBtn.addEventListener("click", refreshTable); // Evento para actualizar la tabla

// Renderizar clientes al cargar la página
renderClients();
