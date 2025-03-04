using System;
using System.Collections.Generic;
using MySql.Data.MySqlClient;

public class DatabaseHelper
{
    private string connectionString = "Server=localhost;Database=barbershop;User=root;Password=;";

    public List<User> GetUsers()
    {
        List<User> users = new List<User>();

        using (var connection = new MySqlConnection(connectionString))
        {
            connection.Open();
            string query = "SELECT id, email, password FROM users";

            using (var command = new MySqlCommand(query, connection))
            using (var reader = command.ExecuteReader())
            {
                while (reader.Read())
                {
                    users.Add(new User
                    {
                        Id = reader.GetInt32("id"),
                        Email = reader.GetString("email"),
                        Password = reader.GetString("password")
                    });
                }
            }
        }

        return users;
    }
}
public void AddUser(string email, string password)
{
    using (var connection = new MySqlConnection(connectionString))
    {
        connection.Open();
        string query = "INSERT INTO users (email, password) VALUES (@Email, @Password)";
        
        using (var command = new MySqlCommand(query, connection))
        {
            command.Parameters.AddWithValue("@Email", email);
            command.Parameters.AddWithValue("@Password", password); // Itt valós jelszó titkosítás szükséges!
            command.ExecuteNonQuery();
        }
    }
}
public void BookAppointment(int userId, string barberName, DateTime appointmentDate)
{
    using (var connection = new MySqlConnection(connectionString))
    {
        connection.Open();
        string query = "INSERT INTO appointments (user_id, barber_name, appointment_date) VALUES (@UserId, @BarberName, @AppointmentDate)";
        
        using (var command = new MySqlCommand(query, connection))
        {
            command.Parameters.AddWithValue("@UserId", userId);
            command.Parameters.AddWithValue("@BarberName", barberName);
            command.Parameters.AddWithValue("@AppointmentDate", appointmentDate);
            command.ExecuteNonQuery();
        }
    }
}
public List<Appointment> GetAppointments()
{
    List<Appointment> appointments = new List<Appointment>();

    using (var connection = new MySqlConnection(connectionString))
    {
        connection.Open();
        string query = "SELECT * FROM appointments";

        using (var command = new MySqlCommand(query, connection))
        using (var reader = command.ExecuteReader())
        {
            while (reader.Read())
            {
                appointments.Add(new Appointment
                {
                    Id = reader.GetInt32("id"),
                    UserId = reader.GetInt32("user_id"),
                    BarberName = reader.GetString("barber_name"),
                    AppointmentDate = reader.GetDateTime("appointment_date"),
                    Status = reader.GetString("status")
                });
            }
        }
    }

    return appointments;
}
public void CancelAppointment(int appointmentId)
{
    using (var connection = new MySqlConnection(connectionString))
    {
        connection.Open();
        string query = "UPDATE appointments SET status = 'cancelled' WHERE id = @AppointmentId";

        using (var command = new MySqlCommand(query, connection))
        {
            command.Parameters.AddWithValue("@AppointmentId", appointmentId);
            command.ExecuteNonQuery();
        }
    }
}
public Admin GetAdminByEmail(string email)
{
    using (var connection = new MySqlConnection(connectionString))
    {
        connection.Open();
        string query = "SELECT * FROM admins WHERE email = @Email";

        using (var command = new MySqlCommand(query, connection))
        {
            command.Parameters.AddWithValue("@Email", email);
            using (var reader = command.ExecuteReader())
            {
                if (reader.Read())
                {
                    return new Admin
                    {
                        Id = reader.GetInt32("id"),
                        Email = reader.GetString("email"),
                        Password = reader.GetString("password")
                    };
                }
            }
        }
    }
    return null;
}
