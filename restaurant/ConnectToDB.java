package restaurant;


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Arrays;

public class ConnectToDB 
{
	private final static String URL = "jdbc:mysql://actesco.org/restaurantsystem";
	private final static String USER = "restaurant";
	private final static String PASSWORD = "compsci776";
	private final static String QUREY = "SELECT * FROM transactions";
	private final static String QUREYACOUNT = "SELECT * FROM accounts";
	private final  String ITEM = "select * from items";
	public String address = "";
	public String email = "";
	public int index = -1;
	public String[] foodName = new String[10];
	public ConnectToDB() throws ClassNotFoundException, SQLException
	{
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection(URL,USER,PASSWORD);
		Statement stmt = con.createStatement();
		ResultSet food = stmt.executeQuery(this.ITEM);
		int k = 0;
		while(food.next())
		{
			foodName[k] = food.getString(2);
			k++;
		}
	}
	
	public Object[][] orderInfo() throws SQLException, ClassNotFoundException
	{
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection(URL,USER,PASSWORD);
		Statement stmt = con.createStatement();
			ResultSet rs = stmt.executeQuery(QUREY);
			
			
			int count = 0;
			while(rs.next())
			{
				if(rs.getInt(11) == 1)
					continue;
				count++;
			}
			rs.beforeFirst();
			
			if(count == 0)
			{
				Object[][] list = {
						{"No order","","","","","",""}
				};
				return list;
			}
			else
			{	
			Object [][] ad = new Object[count][];
			while(rs.next())
			{
				if(rs.getInt(11) == 0)
				{
					this.index = rs.getInt(1);
					break;
				}
			}
			rs.beforeFirst();
					for(int j=0; j<count; j++)
						ad[j] = new Object[7];
					int i = 0;
					while(rs.next())
					{
						if(rs.getInt(11) == 1)
							continue;
						ad[i][0] = rs.getInt(1);
						ad[i][1] = rs.getString(2);
						ad[i][2] = rs.getDouble(5);
						ad[i][3] = rs.getString(6);
						ad[i][4] = rs.getInt(8);
						ad[i][5] = rs.getDate(9);
						ad[i][6] = rs.getTime(10);
						i++;
					}
			if(ad[0][4] != "")
			{
				for(int m=0; m< ad.length; m++)
				{
					String request = ad[m][3].toString();
					ArrayList <Integer>left = new ArrayList<Integer>();
					ArrayList <Integer>right = new ArrayList<Integer>();
					for(int y =1; y<ad[m][3].toString().length()-1;y++)
					{
						if(request.charAt(y) == 91)
							left.add(y);
						if(request.charAt(y) == 93)
							right.add(y);
					}
					ArrayList <String>requestlist = new ArrayList<String>();
					for(int l=0; l<left.size(); l++)
						requestlist.add(request.substring(left.get(l)+1, right.get(l)));
					
					String tr = ad[m][3].toString().replaceAll("[^\\d]", " ");
					tr = tr.trim();
					tr = tr.replaceAll(" +", " ");
					String[] order = tr.split(" ");
					
					ad[m][3] = "";
					for(int x = 0; x <order.length; x=x+2)
					{
						ad[m][3] = ad[m][3]+this.foodName[Integer.valueOf(order[x])-1]+"*"+order[x+1]+"\n";
					}
					for(int n = 0; n<requestlist.size(); n++)
						ad[m][3] = ad[m][3] + requestlist.get(n)+"\n";
				}
			}
			return ad;
				
			}
	}
	public Object[] currentOrder() throws ClassNotFoundException, SQLException
	{
		Class.forName("com.mysql.jdbc.Driver");
		Connection con = DriverManager.getConnection(URL,USER,PASSWORD);
		Statement stmt = con.createStatement();
		ResultSet rs = stmt.executeQuery(QUREY);
		Object[] current = new Object[10];
		if(index == -1)
		{
				current[0] = "No order";
				for(int i=1; i<10; i++)
					current[i] = "";
				current[6] = 0;
		}
		else
		{
			while(rs.next())
			{
				if(rs.getInt(11) == 1)
					continue;
					
				if(rs.getInt(1) == index)
				{
					current[0] = rs.getInt(1);
					current[1] = rs.getString(2);
					current[2] = rs.getString(4);
					current[4] = rs.getDouble(5);
					current[5] = rs.getString(6);
					current[6] = rs.getInt(8);
					current[7] = rs.getDate(9);
					current[8] = rs.getTime(10);
					this.email = rs.getString(3);
					
					continue;
				}
			}
			
			ResultSet acount = stmt.executeQuery(QUREYACOUNT);
			while(acount.next())
			{
				if(email.equals(acount.getString(3)))
				{
					this.address = acount.getString(8);
				}
			}
			current[3] = this.address;
			current[9]= email;
		}
		
			if(index != -1)
			{
				String request = current[5].toString();
				ArrayList <Integer>left = new ArrayList<Integer>();
				ArrayList <Integer>right = new ArrayList<Integer>();
				for(int y =1; y<current[5].toString().length()-1;y++)
				{
					if(request.charAt(y) == 91)
						left.add(y);
					if(request.charAt(y) == 93)
						right.add(y);
				}
				ArrayList <String>requestlist = new ArrayList<String>();
				for(int l=0; l<left.size(); l++)
					requestlist.add(request.substring(left.get(l)+1, right.get(l)));
				
				String tr = current[5].toString().replaceAll("[^\\d]", " ");
				tr = tr.trim();
				tr = tr.replaceAll(" +", " ");
				String[] order = tr.split(" ");
				
				current[5] = "";
				for(int x = 0; x <order.length; x=x+2)
				{
					current[5] = current[5]+this.foodName[Integer.valueOf(order[x])-1]+"*"+order[x+1]+"\n";
				}
				for(int n = 0; n<requestlist.size(); n++)
					current[5] = current[5] + requestlist.get(n)+"\n";
			}
		
		return current;
	}
	
}
