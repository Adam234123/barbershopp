public class User
{
    public int Id { get; set; }
    public string Email { get; set; }
    public string Password { get; set; }
}
[HttpPost]
public IActionResult AddUser([FromBody] User user)
{
    _dbHelper.AddUser(user.Email, user.Password);
    return Ok("User added successfully.");
}
