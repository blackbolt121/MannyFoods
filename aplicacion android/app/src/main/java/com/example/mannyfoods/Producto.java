package com.example.mannyfoods;

import androidx.annotation.NonNull;

public class Producto {
    private int id;
    private String nombre;
    private int dept;
    private int subdept;
    private double precio;
    public Producto(){
        id = 0;
        nombre = "";
        dept = 0;
        subdept = 0;
        precio = 0.0;
    }
    public Producto(int _id, String _nombre, int _dept, int _subdept, double _precio){
        id = _id;
        nombre = _nombre;
        dept = _dept;
        subdept = _subdept;
        precio = _precio;
    }
    public int getId() {
        return id;
    }

    public String getNombre() {
        return nombre;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public void setDept(int dept) {
        this.dept = dept;
    }

    public void setSubdept(int subdept) {
        this.subdept = subdept;
    }

    public void setPrecio(double precio) {
        this.precio = precio;
    }

    public int getDept() {
        return dept;
    }

    public int getSubdept() {
        return subdept;
    }

    public double getPrecio() {
        return precio;
    }

    @NonNull
    @Override
    public String toString() {
        return this.nombre;
    }
}
