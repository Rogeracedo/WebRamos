document.addEventListener("DOMContentLoaded", () => {
    const projects = [
        {
            name: "Construcción Edificio A",
            client: "Juan Pérez",
            status: "En Ejecución",
            startDate: "2024-01-10",
            endDate: "2024-12-30",
        },
        {
            name: "Remodelación Oficina X",
            client: "María López",
            status: "Inicio",
            startDate: "2024-02-01",
            endDate: "2024-05-15",
        },
    ];

    const projectList = document.getElementById("project-list");

    const renderProjects = () => {
        projectList.innerHTML = "";
        projects.forEach((project) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${project.name}</td>
                <td>${project.client}</td>
                <td>${project.status}</td>
                <td>${project.startDate}</td>
                <td>${project.endDate}</td>
                <td>
                    <button class="btn-edit">Editar</button>
                    <button class="btn-delete">Eliminar</button>
                </td>
            `;
            projectList.appendChild(row);
        });
    };

    renderProjects();
});
