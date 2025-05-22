    // Función para mostrar/ocultar modales
    function toggleModal(id) {
      const modal = document.getElementById(id);
      modal.classList.toggle('hidden');
    }

    // Mostrar/ocultar campo de descripción
    document.querySelectorAll('[id^="descripcionCheck"]').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const id = this.id.replace('descripcionCheck', '');
        const descDiv = document.getElementById('descripcionDiv' + id);
        descDiv.classList.toggle('hidden', !this.checked);
      });
    });

    // Confirmar eliminación
    function confirmarEliminacion(metaId) {
      if (confirm("¿Estás seguro de que deseas eliminar esta meta?")) {
        window.location.href = "index.php?ruta=main&modulo=ahorro&accion=eliminar&id=" + metaId;
      }
    }

function toggleDropdown(id) {
      const menu = document.getElementById(id);
      menu.classList.toggle('hidden');
    }

    // Cierra todos los menús si haces clic fuera
    window.addEventListener('click', function(e) {
      document.querySelectorAll('[id^="acciones"]').forEach(menu => {
        if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
          menu.classList.add('hidden');
        }
      });
    });