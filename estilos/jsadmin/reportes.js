document.getElementById("generate-report-btn").addEventListener("click", () => {
    const reportOutput = document.getElementById("report-output");
    const sampleReport = `
        <h3>Reporte de Datos</h3>
        <p><strong>Total Clientes:</strong> 20</p>
        <p><strong>Proyectos en Ejecución:</strong> 8</p>
        <p><strong>Presupuestos Pendientes:</strong> 5</p>
    `;

    reportOutput.innerHTML = sampleReport;
});
