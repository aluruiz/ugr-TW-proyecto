
function desplegarIncidencia(id) {
    console.log("click con " + id);
    let bloqueIncidencia = document.getElementById("incidencia-" + id);
    let detalles = bloqueIncidencia.querySelector("#infoIncidencia-" + id);
    let nuevoComent = bloqueIncidencia.querySelector("#nuevoComentarioIncidencia-" + id);
    let listaComent = bloqueIncidencia.querySelector("#listaComentariosIncidencia-" + id);

    if (detalles.style.display === "" || detalles.style.display === "none") {
      detalles.style.display = "block";
      nuevoComent.style.display = "block";
      listaComent.style.display = "block";
    } else {
      detalles.style.display = "none";
      nuevoComent.style.display = "none";
      listaComent.style.display = "none";
    }
}
