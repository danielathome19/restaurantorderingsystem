package restaurant;
/*
 * CS776 final project/ message part by Dan Zhao in restaurant group
 * 4/21/2022 in UW
 */
import javax.mail.*;
import javax.mail.internet.*;
import java.util.Properties;

public class SendEmail 
{
	public void sendMessage(String recipient, String name, String food, String time)
	{
		
		final String sender = "zhaodan0513@gmail.com";
		final String password = "jiujuban1982";
		String host = "smtp.gmail.com";
		
		Properties properties = System.getProperties();
		properties.setProperty("mail.smtp.host", host);
		properties.put("mail.smtp.auth", "true");
		properties.put("mail.debug", "true");
		properties.put("mail.smtp.starttls.enable", "true");
		
		Authenticator auth = new Authenticator()
				{
					public PasswordAuthentication getPasswordAuthentication() {
						return new PasswordAuthentication("zhaodan0513",password);}
				}; 
		
		Session session = Session.getDefaultInstance(properties,auth);
		try
		{
			MimeMessage message = new MimeMessage(session);
			message.setFrom(new InternetAddress(sender));
			message.addRecipient(Message.RecipientType.TO, new InternetAddress(recipient));
			message.setSubject("This is subject");
			message.setText("Dear Sir/Madam, your order: "+food+" will be ready in "+time+" minitues");
			Transport.send(message);
			System.out.println("Success!");
		}
		catch(MessagingException mex)
		{
			mex.printStackTrace();
		}

	}
}
