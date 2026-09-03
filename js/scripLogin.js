
class ValidadorDatos {
  constructor() {
    
    this.usuarioInput = document.getElementById('usuario');
    this.passwordInput = document.getElementById('password');
    this.btnSubmit = document.getElementById('btnSubmit');

    
    this.contieneLetraONumero = /[a-zA-Z0-9]/;

    
    this.iniciarEventos();
  }

  
  validarCampos() {
    const usuarioValido = this.contieneLetraONumero.test(this.usuarioInput.value);
    const passwordValida = this.contieneLetraONumero.test(this.passwordInput.value);

    this.btnSubmit.disabled = !(usuarioValido && passwordValida);
  }

  
  iniciarEventos() {
    // Usamos bind(this) o arrow functions para no perder la referencia a la clase
    this.usuarioInput.addEventListener('input', () => this.validarCampos());
    this.passwordInput.addEventListener('input', () => this.validarCampos());
  }
}


document.addEventListener('DOMContentLoaded', () => {
  new ValidadorDatos();
});