import mysql.connector
mydb = mysql.connector.connect(host="localhost",user="root",password="",port="3300",database="manyfoods")
cursor = mydb.cursor()
def executeQuery(query):
    try:
        cursor.execute(query)
        mydb.commit()
    except:
        print("Error")
        print(query)
        input()
        mydb.rollback()


def insertDepartment(department):
    department = department.replace("\n","").replace("-"," ").capitalize()
    statement = f"CALL INSERTDEPARTMENT('{department}');"
    print(statement)
    executeQuery(statement)
    

def insertSubDepartament(department):
    department = department.replace("\n","").replace("-"," ").capitalize()
    statement = f"CALL INSERTSUBDEPARTAMENTO('{department}');"
    executeQuery(statement)


def readCatalogoBook(folder, line):
    ine = line.replace("\n","")
    with open(f"{folder}/{line.lower()}.txt", "r", encoding="utf-8") as tier:
        products = tier.readlines()
        #for i in range(0,int(len(products)/2)):
        #   print(f"{products[i]} {products[i+1]}")
        catalogos = folder.split("/")
        catalogos[1] = catalogos[1].replace("-"," ")
        print(catalogos[1] + " " + catalogos[2] + " " + line)
        print()
        for i in range(0,len(products),2):
            product1 = products[i].replace('\n','')
            product2 = products[i+1].replace('\n','').replace("$","")
            statement = f'CALL INSERT_PRODUCT("{product1}","{catalogos[1]}","{catalogos[2]}",{product2});'
            executeQuery(statement)

def readCatalogo(folder,lvl):
    folder = folder.replace("\n","")
    with open(f"{folder}/catalogo.txt","r",encoding="utf-8") as file:
            if lvl > 1:
                for line in file.readlines():
                    line = line.replace("\n","").rstrip()
                    try:
                        readCatalogoBook(folder,line)
                    except:
                        line = line + " "
                        readCatalogoBook(folder,line)
            else:
                return file.readlines()
    pass
def moveFolders(folder,lvl):
    if (lvl > 1):
            readCatalogo(folder,lvl)
    else:
        dep = readCatalogo(folder,lvl)
        for x in dep:
            if lvl == 0:
                print("Departamento: " + x)
                #insertDepartment(x)
            elif lvl == 1:
                print("Subdepartamento: " + x)
                #insertSubDepartament(x)
            lookfor(folder+"/"+x,lvl+1)

def lookfor(folder="", lvl=0):
    if folder == "":
        folder= "."
    try:
        moveFolders(folder,lvl)
    except:
        folder = folder.rstrip()
        moveFolders(folder,lvl)
lookfor()
cursor.close()
mydb.close()