import { listarDatos } from "../supabase/operaciones.js";
 
async function cargarDatos() {
  const datos = await listarDatos("formulario","id_formulario","id_formulario,cliente(nombre,apellido,telefono,email,direccion,fecha_registro),fecha_envio,estado,comentarios");
  console.log(datos);

  function mostrardatos(){
     const { data: formularios, error} = datos;
    if (error) {
      console.error("Error al cargar los datos:", error);
      alert("Error al cargar los datos: " + error.message);
      return;
    }
    const tbody = document.querySelector(".table__body");
    tbody.innerHTML = "";
    formularios.forEach((formulario) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${formulario.id_formulario}</td>
        <td>${formulario.cliente.nombre} ${formulario.cliente.apellido}</td>
        <td>${formulario.cliente.telefono}</td>
        <td>${formulario.cliente.email}</td>
        <td>${formulario.cliente.direccion}</td>
        <td>${formulario.fecha_envio}</td>
        <td>${formulario.estado}</td>
        <td>${formulario.comentarios}</td>
      `;
      tbody.appendChild(tr);
    });
  }
  mostrardatos();
}
cargarDatos();