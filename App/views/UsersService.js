class UsersService {
  constructor(baseAPI) {
    this.baseAPI = baseAPI
  }

  async getUsers(id = null) {
    console.log(`${this.baseAPI}/users${id ? `/${id}` : ""}`)
    const response = await fetch(`${this.baseAPI}/users${id ? `/${id}` : ""}`)
      .then((response) => {
        if (!response.ok) throw new Error("Failed to get users")
        return response.json()
      })
      .catch((error) => {
        console.error(error)
      })

    console.log("getUsers", response)
    return Array.isArray(response) ? response : [response]
  }

  async addNewUser({ username, email, password }) {
    const userFormData = new FormData()
    userFormData.append("username", username)
    userFormData.append("email", email)
    userFormData.append("password", password)

    const response = await fetch(`${this.baseAPI}/users`, {
      method: "POST",
      body: userFormData,
    })
      .then((response) => {
        if (!response.ok) throw new Error("Failed to add new user")
        return response.json()
      })
      .catch((error) => {
        console.info(error)
      })

    const { id } = response
    const [user] = await this.getUsers(id)
    return user
  }

  async removeUser(userId) {
    const response = await fetch(`${this.baseAPI}/users/${userId}`, {
      method: "DELETE",
    })
      .then((response) => {
        if (!response.ok) throw new Error("Failed to remove user")
        return response.json()
      })
      .catch((error) => {
        console.error(error)
      })
  }
}
