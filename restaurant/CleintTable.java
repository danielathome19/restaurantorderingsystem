package restaurant;

import java.sql.SQLException;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextArea;
import javax.swing.table.DefaultTableModel;

public class CleintTable 
{
	public JFrame basic = frame("Orders in list: ",1000,600);
	public JPanel container;
	public Object[][] list;
	public Object[][] currentTableContent;
	public Object [] currentAll;
	public JTable table1;
	public JTable table2;
	public int index;
	public String email;
	JTextArea text ;
	
	public void getData () throws ClassNotFoundException, SQLException
	{
		ConnectToDB content;
		content = new ConnectToDB();
		Object [][]tableContent = content.orderInfo();
		this.index = content.index;
		this.email = content.email;
		
		if(tableContent.length == 1)
		{
			Object [][]temp = { {"No order","","","","","",""}};
			list = temp;
		}
		else
		{
			
			list = new Object[tableContent.length-1][];
			System.out.println(list.length);
			for(int i=0; i<list.length;i++)
				list[i] = tableContent[i+1]; 
		}
		
		Object [] currentContent = new Object[9];
		currentAll = content.currentOrder();
		
		for(int i=0; i<currentContent.length; i++)
			currentContent[i] = currentAll[i];
		currentTableContent = new Object[1][];
		currentTableContent[0] = currentContent;
		
		
	}
	
	public void table()
	{
		container = new JPanel();
		container.setLayout(null);
		
		int[] bounds1 = {50, 30, 150, 10};
		container.add(label("Orders in Queue:",bounds1));
		
		int[] bounds2 = {50, 240, 700, 100};
		container.add(label("Current Order:",bounds2));
		
		int[] positionOfheadText = {450, 460, 100, 20};
		container.add(label("Update ETA:",positionOfheadText));
		
		int[] positionOftailText = {640, 460, 100, 20};
		container.add(label("minites",positionOftailText));
		
		
		String [] tableHead = {"Transactions","UserName","Revenue","Items","ETA","Date","Time"};
		String [] currentHead = {"Transactions","FullName","Phone number","Delivery address","Revenue","Items","ETA","Date","Time"};
		//DefaultTableModel model1 = new DefaultTableModel(this.list, tableHead);
		//DefaultTableModel model2 = new DefaultTableModel(this.currentTableContent, currentHead);
		this.table1 = new JTable(this.list, tableHead);
		this.table2 = new JTable(this.currentTableContent, currentHead);
		table1.setRowHeight(16);
		table1.setDefaultRenderer(Object.class, new TableCellTextAreaRenderer());
		table2.setRowHeight(100);
		table2.setDefaultRenderer(Object.class, new TableCellTextAreaRenderer());
		
		JScrollPane tablePane1 = new JScrollPane(table1);
		tablePane1.setBounds(50, 60, 900, 200);
		
		JScrollPane tablePane2 = new JScrollPane(table2);
		tablePane2.setBounds(50, 320, 900, 100);

		container.add(tablePane1);
		container.add(tablePane2);
		
		JButton complete = new JButton("Complete Order");
		complete.setBounds(50,460,120,20);
		if(index != -1)
		{
			complete.addActionListener(e -> {
			
			try {
				UpdateOrder up = new UpdateOrder(index);
				up.update();
			} catch (ClassNotFoundException | SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
		});
		}
		container.add(complete);
		
		JButton update = new JButton("Send update");
		update.setBounds(830,460,120,20);
		update.addActionListener(e -> {
			try {
				refresh();
			} catch (ClassNotFoundException | SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
		});
		update.addActionListener(e ->
		{
			SendEmail send = new SendEmail ();
			send.sendMessage(this.email, this.currentTableContent[0][1].toString(), this.currentTableContent[0][5].toString(),
					this.currentTableContent[0][6].toString());
		});
		container.add(update);
		
		
		text = new JTextArea("");
		if(index != -1)
		{	
			text = new JTextArea(Integer.toString((int) currentAll[6]));
			
		}
		text.setBounds(550, 460, 80, 20);
		container.add(text);
		basic.getContentPane().add(container);
		basic.setVisible(true);
	}
	private void refresh() throws ClassNotFoundException, SQLException
	{
		getData ();
		container.removeAll();
		table();
		
	}
	private JLabel label(String name,int[]bounds)
	{
		JLabel label = new JLabel(name);
		label.setBounds(bounds[0], bounds[1], bounds[2], bounds[3]);
		return label;
	}
	
	private JFrame frame(String name,int sizeX, int sizeY)
	{
		JFrame basic = new JFrame(name);
		basic.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		basic.setSize(sizeX, sizeY);
		basic.setLocationRelativeTo(null);
		return basic;
	}
	
}
