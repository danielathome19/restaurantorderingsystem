import mariadb


def get_db_connection():
    conn = mariadb.connect(host="localhost",
                           user="restaurant",
                           password="compsci776",
                           port=3306,
                           database='restaurantsystem')
    return conn


try:
    print('Running commission script.......')
    # getting total incoming commission amount
    get_commission_query = 'SELECT INCOMING_AMOUNT, OUTGOING_AMOUNT FROM commission'
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute(get_commission_query)
    commission = cursor.fetchone()
    if commission[0] > 500:
        # deduct commission from any transaction
        deducted_commission = commission[1]
        update_query = 'UPDATE commission SET INCOMING_AMOUNT=INCOMING_AMOUNT-%s, TOTAL_AMT_PAID=TOTAL_AMT_PAID+%s'
        value = (deducted_commission, deducted_commission)
        connection = get_db_connection()
        cursor = connection.cursor()
        cursor.execute(update_query, value)
        connection.commit()
    print('Commission script ran successfully!!')
except Exception as e:
    print(f"Database exception in python script: {e}")
