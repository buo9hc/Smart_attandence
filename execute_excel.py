
import openpyxl
import unidecode
print("test")
import mysql.connector
import sys
path = sys.argv[1]
# path = "uploads/DSDiemDanh_222SCDA331629_02CLC.xlsx"
table_name = sys.argv[2]
# table_name = "SCDA331629"

wb_obj = openpyxl.load_workbook(path)
sheet_obj = wb_obj.active
row = sheet_obj.max_row 
column = sheet_obj.max_column 


#//Find Row contain table header
table = []
for i in range(1, row + 1):  
    cell_obj = sheet_obj.cell(row = i, column = 1)  
    # print(cell_obj.value)
    if(cell_obj.value == "STT" or cell_obj.value == "TT"):
        for j in range(1,column + 1):
            table_header = sheet_obj.cell(row = i, column = j)
            if (table_header.value != None):
                rm_sign = table_header.value
                rm_sign = unidecode.unidecode(rm_sign)
                rm_sign = rm_sign.replace(" ", "_")
                table.append(rm_sign)
                # print(str(table_header.value))
        break


mydb = mysql.connector.connect(
  host="localhost",
  user="admin",
  password="123456",
  database="DanhSachLop"
)

mycursor = mydb.cursor()

mycursor.execute("CREATE TABLE " + table_name + "(" + table[0] + " MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                                         + table[1] + " VARCHAR(8) NOT NULL, "
                                         + table[2] + " VARCHAR(30) NOT NULL, "
                                         + table[3] + " VARCHAR(10) NOT NULL, "
                                         + table[4] + " VARCHAR(15) NOT NULL, "
                                         + table[5] + " VARCHAR(15) NOT NULL"
                                         + ")")


# mycursor.execute("SHOW TABLES")

# for x in mycursor:
#   print(x)