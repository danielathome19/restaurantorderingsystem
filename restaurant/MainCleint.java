package restaurant;

import java.sql.SQLException;

public class MainCleint 
{
	public static void main (String[] args) throws ClassNotFoundException, SQLException
	{
		
		CleintTable test = new CleintTable();
		
		test.getData();
		test.table();
	}
}
