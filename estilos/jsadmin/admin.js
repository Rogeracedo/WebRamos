// js/script.js
document.addEventListener("DOMContentLoaded", () => {
    // Variables simuladas
    const clients = [
        { name: "Juan Pérez", email: "juan@example.com", phone: "123456789", status: "Ejecución" },
        { name: "María López", email: "maria@example.com", phone: "987654321", status: "Inicio" }
    ];

    // Resumen Inicial
    const updateSummary = () => {
        document.getElementById("active-projects").innerText = clients.filter(c => c.status === "Ejecución").length;
        document.getElementById("completed-projects").innerText = clients.filter(c => c.status === "Finalizado").length;
        document.getElementById("total-clients").innerText = clients.length;
    };

    // Mostrar Clientes
    const clientList = document.getElementById("client-list");
    const renderClients = () => {
        clientList.innerHTML = "";
        clients.forEach(client => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${client.name}</td>
                <td>${client.email}</td>
                <td>${client.phone}</td>
                <td>${client.status}</td>
                <td><button class="btn-edit">Editar</button></td>
            `;
            clientList.appendChild(row);
        });
    };

    // Iniciar
    updateSummary();
    renderClients();
});
