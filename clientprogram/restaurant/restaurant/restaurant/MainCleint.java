package restaurant;

import java.sql.SQLException;

public class MainCleint 
{
	public static void main (String[] args) throws ClassNotFoundException, SQLException
	{
		
		restaurant.CleintTable test = new restaurant.CleintTable();
		
		test.getData();
		test.table();
	}
}
