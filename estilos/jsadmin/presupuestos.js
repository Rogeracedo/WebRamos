document.addEventListener("DOMContentLoaded", () => {
    const budgets = [
        {
            client: "Juan Pérez",
            project: "Construcción Edificio A",
            amount: "$150,000",
            status: "Aprobado",
            date: "2024-03-10",
        },
        {
            client: "María López",
            project: "Remodelación Oficina X",
            amount: "$30,000",
            status: "Pendiente",
            date: "2024-02-15",
        },
    ];

    const budgetList = document.getElementById("budget-list");

    const renderBudgets = () => {
        budgetList.innerHTML = "";
        budgets.forEach((budget) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${budget.client}</td>
                <td>${budget.project}</td>
                <td>${budget.amount}</td>
                <td>${budget.status}</td>
                <td>${budget.date}</td>
                <td>
                    <button class="btn-edit">Editar</button>
                    <button class="btn-delete">Eliminar</button>
                </td>
            `;
            budgetList.appendChild(row);
        });
    };

    renderBudgets();
});
