<?php 
include_once '../backend/php/login.php'
 ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema Hospitalario</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../backend/css/style.css" />
    <link rel="icon" type="image/png" sizes="96x96" href="../backend/img/ico.svg">
  </head>
  <body>
    <div class="form-container">
      <!-- Logo/Imagen del hospital -->
      <div class="logo-container">
        <img src="../backend/img/hospital-logo.png" alt="Logo Hospital" class="hospital-logo" />
      </div>
      
      <h1 class="heading">
        Sistema<br />
        Hospitalario
      </h1>
      
      <?php 
        if (isset($errMsg)) {
          echo '
            <div style="color:#FF0000;text-align:center;font-size:20px; font-weight:bold;">'.$errMsg.'</div>
          ';
        }
      ?>
      
      <form action="" method="POST" autocomplete="off">
        <input
          type="text" 
          name="username" 
          value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>"  
          autocomplete="off" 
          class="form-input span-2"
          placeholder="Nombre de usuario"
        />
        <input 
          type="password" 
          required="true" 
          name="password" 
          class="form-input span-2" 
          placeholder="Contraseña" 
        />
     
        <button class="btn submit-btn span-2" name='login' type="submit">
          Iniciar sesión
        </button>
      </form>
      
      <!-- Botón de olvidé mi contraseña -->
      <div class="forgot-password-container">
        <a href="../backend/php/forgot_password.php" class="forgot-password-link">
          ¿Olvidaste tu contraseña?
        </a>
      </div>
      
      <p class="btm-line">
        By joining, you agree to our Terms of Service and Privacy Policy
      </p>
    </div>

    <style>
      :root {
        --aqua-primary: #00BCD4;
        --aqua-light: #26E0F3;
        --aqua-dark: #0099A8;
        --navy-primary: #1565C0;
        --navy-light: #1976D2;
        --navy-dark: #0D47A1;
        --white: #FFFFFF;
        --gray-50: #FAFAFA;
        --gray-100: #F5F5F5;
        --gray-200: #EEEEEE;
        --gray-300: #E0E0E0;
        --gray-600: #757575;
        --gray-700: #616161;
        --gray-900: #212121;
        --shadow-light: 0 2px 8px rgba(0, 188, 212, 0.15);
        --shadow-medium: 0 4px 16px rgba(0, 188, 212, 0.2);
        --shadow-heavy: 0 8px 32px rgba(0, 188, 212, 0.25);
      }

      body {
        background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .form-container {
        background: var(--white);
        padding: 40px;
        border-radius: 20px;
        box-shadow: var(--shadow-heavy);
        width: 100%;
        max-width: 420px;
        border: 1px solid var(--gray-200);
      }

      .logo-container {
        text-align: center;
        margin-bottom: 24px;
      }
      
      .hospital-logo {
        max-width: 120px;
        height: auto;
        border-radius: 12px;
        box-shadow: var(--shadow-light);
      }

      .heading {
        text-align: center;
        margin-bottom: 32px;
        background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.2em;
        font-weight: 700;
        letter-spacing: -0.5px;
        line-height: 1.2;
      }

      .form-input {
        width: 100%;
        padding: 16px 20px;
        margin-bottom: 20px;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--white);
        color: var(--gray-900);
        font-family: inherit;
        box-sizing: border-box;
      }

      .form-input:focus {
        outline: none;
        border-color: var(--aqua-primary);
        box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.1);
        transform: translateY(-2px);
      }

      .form-input:hover {
        border-color: var(--aqua-light);
      }

      .form-input::placeholder {
        color: var(--gray-600);
        font-weight: 400;
      }

      .submit-btn {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
        color: var(--white);
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        letter-spacing: 0.5px;
      }

      .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
      }

      .submit-btn:active {
        transform: translateY(0);
      }
      
      .forgot-password-container {
        text-align: center;
        margin: 20px 0;
      }
      
      .forgot-password-link {
        color: var(--navy-primary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-block;
      }
      
      .forgot-password-link:hover {
        color: var(--aqua-primary);
        background: rgba(0, 188, 212, 0.1);
        text-decoration: none;
      }

      .btm-line {
        text-align: center;
        font-size: 12px;
        color: var(--gray-600);
        margin-top: 24px;
        line-height: 1.4;
      }

      /* Error message styling */
      div[style*="color:#FF0000"] {
        background: rgba(244, 67, 54, 0.1) !important;
        color: #D32F2F !important;
        padding: 12px 16px !important;
        border-radius: 8px !important;
        margin-bottom: 20px !important;
        border-left: 4px solid #D32F2F !important;
        font-size: 14px !important;
        font-weight: 500 !important;
      }
      
      /* Responsive adjustments */
      @media (max-width: 768px) {
        .form-container {
          margin: 20px;
          padding: 32px 24px;
        }

        .hospital-logo {
          max-width: 100px;
        }

        .heading {
          font-size: 1.8em;
        }
        
        .form-input {
          padding: 14px 16px;
          font-size: 15px;
        }

        .submit-btn {
          padding: 14px 20px;
          font-size: 15px;
        }
        
        .forgot-password-link {
          font-size: 13px;
        }
      }

      @media (max-width: 480px) {
        .form-container {
          margin: 16px;
          padding: 24px 20px;
        }

        .heading {
          font-size: 1.6em;
          margin-bottom: 24px;
        }
      }
    </style>
  </body>
</html>
