function MayusculasAutomatico() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="search"], textarea');
  
    inputs.forEach(input => {
      input.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
      });
    });
  }
  
  // Llama a la función cuando el DOM esté completamente cargado
  document.addEventListener('DOMContentLoaded', MayusculasAutomatico);