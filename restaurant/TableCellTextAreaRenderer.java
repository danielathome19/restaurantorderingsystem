package restaurant;

import java.awt.Component;

import javax.swing.JTable;
import javax.swing.JTextArea;
import javax.swing.table.TableCellRenderer;

@SuppressWarnings("serial")
public class TableCellTextAreaRenderer extends JTextArea implements TableCellRenderer
{
	public TableCellTextAreaRenderer() {   
        setLineWrap(true);     
        setWrapStyleWord(true);   
    }   
  
    public Component getTableCellRendererComponent(JTable table, Object value,   
            boolean isSelected, boolean hasFocus, int row, int column) {   
          
        int maxPreferredHeight = 0;   
        for (int i = 0; i < table.getColumnCount(); i++) {   
            setText("" + table.getValueAt(row, i));   
            setSize(table.getColumnModel().getColumn(column).getWidth(), 0);   
            maxPreferredHeight = Math.max(maxPreferredHeight, getPreferredSize().height);   
        }   
  
        if (table.getRowHeight(row) != maxPreferredHeight)   
            table.setRowHeight(row, maxPreferredHeight);   
  
        setText(value == null ? "" : value.toString());   
        return this;   
    }   

}
