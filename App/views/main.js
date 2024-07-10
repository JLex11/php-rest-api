const initialUsers = window.INITIAL_USERS || []
const baseAPI = window.API_URL

const usersService = new UsersService(baseAPI)

const usersRenderer = new UsersRenderer({
  $container: document.querySelector("#users_list"),
  onRemove: (userId) => usersService.removeUser(userId),
})

function addInitialUsers() {
  usersRenderer.addUsers(initialUsers)
}

async function handleFormSubmit(event) {
  event.preventDefault()
  const form = event.target
  const { username, email, password } = form.elements

  const user = await usersService
    .addNewUser({
      username: username.value,
      email: email.value,
      password: password.value,
    })
    .catch((error) => {
      console.error(error)
    })

  usersRenderer.addUsers([user])
  form.reset()
}

function main() {
  addInitialUsers()

  const $form = document.querySelector("form")
  $form.addEventListener("submit", handleFormSubmit)
}

main()
