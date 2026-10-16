
class ValidadorDatos {
  constructor() {
    this.usuarioInput = document.getElementById('usuario');
    this.passwordInput = document.getElementById('password');
    this.captchaInput = document.getElementById('captcha');
    this.btnSubmit = document.getElementById('btnSubmit');

    this.contieneLetraONumero = /[a-zA-Z0-9]/;
    this.iniciarEventos();
    this.validarCampos();
  }

  validarCampos() {
    const usuarioValido = this.contieneLetraONumero.test(this.usuarioInput.value.trim());
    const passwordValida = this.contieneLetraONumero.test(this.passwordInput.value.trim());
    const captchaValido = this.captchaInput.value.trim().length > 0;

    this.btnSubmit.disabled = !(usuarioValido && passwordValida && captchaValido);
  }

  iniciarEventos() {
    this.usuarioInput.addEventListener('input', () => this.validarCampos());
    this.passwordInput.addEventListener('input', () => this.validarCampos());
    this.captchaInput.addEventListener('input', () => this.validarCampos());
  }
}


document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (form) {
    new ValidadorDatos();
  }
});