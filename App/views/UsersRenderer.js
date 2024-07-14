let usersState = []

class UsersRenderer {
  constructor({ $container, $template, onRemove }) {
    this.$container = $container
    this.template = $template
    this.onRemove = onRemove
    this.users = []
  }

  removeUser(userId) {
    const newUsers = usersState.filter((user) => user.id != userId)
    usersState = newUsers
    return newUsers
  }

  async mapRandomUserImage(user) {
    const response = await fetch(`https://randomuser.me/api/?inc=picture&seed=${user.id}`)
      .then((response) => response.json())
      .catch((error) => {
        console.info(error)
        return { results: [{ picture: { large: '' } }] }
      })

    const picture = response.results[0].picture.large
    return { ...user, image: picture }
  }

  renderUser(user) {
    const template = this.template.cloneNode(true)
    const $userCard = template.querySelector('.user_card')

    $userCard.dataset.id = user.id
    $userCard.style.viewTransitionName = `__user-card-${user.id}`

    $userCard.querySelector('#__user_image').src = user.image
    $userCard.querySelector('#__user_image').alt = user.username
    $userCard.querySelector('#__user_name').textContent = user.username
    $userCard.querySelector('#__user_email').textContent = user.email
    $userCard.querySelector('#__user_password').textContent = user.password
    $userCard.querySelector('button').dataset.id = user.id

    return $userCard.outerHTML
  }

  handleRemoveClick(event, self) {
    const userId = event.target.dataset.id
    const newUsers = self.removeUser(userId)
    self.onRemove(userId)
    self.renderUsers(newUsers)
  }

  renderUsers(users) {
    const renderedUsers = usersState.map((user) => this.renderUser(user)).join('')

    document.startViewTransition(() => {
      this.$container.innerHTML = renderedUsers
      this.$container.querySelectorAll('button[type=button]#__user-card-remove').forEach((button) => {
        button.addEventListener(
          'click',
          (event) => {
            console.log(this)
            this.handleRemoveClick(event, this)
          },
          {
            once: true
          }
        )
      })
    })
  }

  async addUsers(users) {
    const newUsers = await Promise.all(users.map((user) => this.mapRandomUserImage(user)))

    usersState = [...usersState, ...newUsers]
    this.renderUsers(usersState)
  }
}
