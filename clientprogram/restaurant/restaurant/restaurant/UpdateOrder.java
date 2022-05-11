package restaurant;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;

public class UpdateOrder 
{
	private final static String URL = "jdbc:mysql://actesco.org/restaurantsystem";
	private final static String USER = "restaurant";
	private final static String PASSWORD = "compsci776";
	private  int  index = -1;
	
	public UpdateOrder(int index)
	{
		this.index = index;
	}
	public void update() throws ClassNotFoundException, SQLException
	{
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection(URL,USER,PASSWORD);
		Statement stmt = con.createStatement();
		String updateinfo = "update transactions set completed=1 where "+"transactions.index="+index;
		stmt.executeUpdate(updateinfo);
		
	}

	public void updateETA(String eta) throws ClassNotFoundException, SQLException
	{
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection(URL,USER,PASSWORD);
		Statement stmt = con.createStatement();
		String updateinfo = "update transactions set eta=" + eta + " where "+"transactions.index="+index;
		stmt.executeUpdate(updateinfo);

	}
}
