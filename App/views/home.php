<?php
require_once './config/config.php';

use App\Models\UserDAO;

$userDAO = new UserDAO();
$users = $userDAO->getAllUsers();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users App</title>
  <link rel="stylesheet" href="<?php echo BASE_URL . "/dist/style.css" ?>">
  <script>
    window.INITIAL_USERS = <?php echo json_encode($users); ?>;
    window.API_URL = "<?php echo BASE_URL . "/api"; ?>"
  </script>
</head>

<body class="p-4">
  <h1 class="text-3xl m-4 text-center">Users App</h1>
  <main class="max-w-[min(100%,1280px)] flex sm:flex-row flex-col sm:items-start items-center gap-8 p-4">
    <section class="border border-gray-300 dark:border-gray-600 px-7 py-8 rounded-lg shadow flex flex-col gap-4 w-full max-w-96">
      <header>
        <h3 class="text-xl">Registro</h3>
        <p class="opacity-80">Ingresa los datos del usuario a registrar</p>
      </header>

      <hr class="bg-gray-600 border border-gray-300 dark:border-gray-600">

      <form action="<?php echo BASE_URL . "/api/users"; ?>" method="post" class="flex flex-col gap-3 md:sticky top-8">
        <label class="flex gap-1 flex-col">
          <span>Nombre de usuario</span>
          <input type="text" name="username" placeholder="Ingresa el nombre de usuario" class="rounded py-2 px-4 bg-white/10 border border-gray-300 dark:border-gray-600">
        </label>

        <label class="flex gap-1 flex-col">
          <span>Correo</span>
          <input type="email" name="email" placeholder="Ingresa el correo del usuario" class="rounded py-2 px-4 bg-white/10 border border-gray-300 dark:border-gray-600">
        </label>

        <label class="flex gap-1 flex-col">
          <span>Contraseña</span>
          <input type="password" name="password" placeholder="Ingresa la contraseña del usuario" class="rounded py-2 px-4 bg-white/10 border border-gray-300 dark:border-gray-600">
        </label>

        <button type="submit" class="rounded bg-blue-800 text-white hover:bg-blue-700 transition-colors p-2">
          Agregar
        </button>
      </form>
    </section>
    <section class="w-full">
      <ul id="users_list" class="grid grid-cols-[repeat(auto-fill,_minmax(300px,1fr))] gap-2">
      </ul>
    </section>
    <template id="user_card_template">
      <li class="user_card">
        <article class="flex flex-row gap-3 p-2 border dark:border-gray-300 dark:border-gray-600 border-gray-300 shadow rounded max-w-96 h-fit">
          <img id="__user_image" src="" alt="" height="90" class="rounded aspect-square h-28">
          <div class="flex flex-col gap-0 w-full overflow-hidden gradient-mask-r-80 justify-between">
            <h4 id="__user_name" class="text-lg font-bold"></h4>
            <span id="__user_email" class="opacity-80"></span>
            <span id="__user_password" class="opacity-80"></span>
            <button type="button" class="flex px-3 py-1 bg-red-700 w-fit h-fit rounded">Eliminar</button>
          </div>
        </article>
      </li>
    </template>
  </main>

  <script src="<?php echo BASE_URL . "/app/views/UsersRenderer.js" ?>" type="text/javascript"></script>
  <script src="<?php echo BASE_URL . "/app/views/UsersService.js" ?>" type="text/javascript"></script>
  <script src="<?php echo BASE_URL . "/app/views/main.js" ?>" type="text/javascript"></script>
</body>

</html>