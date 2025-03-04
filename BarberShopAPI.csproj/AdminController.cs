[HttpPost("login")]
public IActionResult Login([FromBody] Admin admin)
{
    var dbAdmin = _dbHelper.GetAdminByEmail(admin.Email);
    
    if (dbAdmin == null || !BCrypt.Net.BCrypt.Verify(admin.Password, dbAdmin.Password))
    {
        return Unauthorized("Invalid email or password");
    }

    var token = GenerateJwtToken(dbAdmin);
    return Ok(new { Token = token });
}
private string GenerateJwtToken(Admin admin)
{
    var key = new SymmetricSecurityKey(Encoding.UTF8.GetBytes("your_secret_key_here"));
    var creds = new SigningCredentials(key, SecurityAlgorithms.HmacSha256);

    var claims = new List<Claim>
    {
        new Claim(ClaimTypes.NameIdentifier, admin.Id.ToString()),
        new Claim(ClaimTypes.Email, admin.Email),
        new Claim(ClaimTypes.Role, "Admin")
    };

    var token = new JwtSecurityToken(
        issuer: "yourdomain.com",
        audience: "yourdomain.com",
        claims: claims,
        expires: DateTime.UtcNow.AddHours(2),
        signingCredentials: creds
    );

    return new JwtSecurityTokenHandler().WriteToken(token);
}
