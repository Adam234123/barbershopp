using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;

[Route("api/[controller]")]
[ApiController]
public class UserController : ControllerBase
{
    private readonly DatabaseHelper _dbHelper = new DatabaseHelper();

    [HttpGet]
    public IActionResult GetUsers()
    {
        List<User> users = _dbHelper.GetUsers();
        return Ok(users);
    }
}
