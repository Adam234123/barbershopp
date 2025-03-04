[HttpPost]
public IActionResult BookAppointment([FromBody] Appointment appointment)
{
    _dbHelper.BookAppointment(appointment.UserId, appointment.BarberName, appointment.AppointmentDate);
    return Ok("foglalás sikeres!");
}
[HttpGet]
public IActionResult GetAppointments()
{
    List<Appointment> appointments = _dbHelper.GetAppointments();
    return Ok(appointments);
}
[HttpDelete("{id}")]
public IActionResult CancelAppointment(int id)
{
    _dbHelper.CancelAppointment(id);
    return Ok("Appointment cancelled.");
}
