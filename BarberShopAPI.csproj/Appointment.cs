public class Appointment
{
    public int Id { get; set; }
    public int UserId { get; set; }
    public string BarberName { get; set; }
    public DateTime AppointmentDate { get; set; }
    public string Status { get; set; } = "pending";
}
