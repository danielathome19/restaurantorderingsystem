"""
Automatically ran during each transaction, check commission table, send transactions to 
restaurant client program to notify restaurant of a new order. Update total_amt_paid each time a 
commission is subtracted from outgoing_amount (add commission amount to total, subtract from outgoing)
""