import os
with open("catalogo.txt", encoding="utf-8") as dep:
    for x in dep.readlines():
        x = x.replace("\n","").lower()
        # Crear directorios
        # dir = os.getcwd() + "\\" + x
        # print(dir)
        # os.system(f"mkdir \"{dir}\"")
        # catalogo = open(dir+"\\catalogo.txt","w+")
        # catalogo.close()
        # Crear archivos
        f = open(x+".txt","w+")
        f.close()