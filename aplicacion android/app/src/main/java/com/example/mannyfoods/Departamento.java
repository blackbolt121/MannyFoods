package com.example.mannyfoods;

import androidx.annotation.NonNull;

public class Departamento {

    int dept;
    String nombre;

    public Departamento(int dept, String nombre) {
        this.dept = dept;
        this.nombre = nombre;
    }

    public int getDept() {
        return dept;
    }

    public String getNombre() {
        return nombre;
    }

    public void setDept(int dept) {
        this.dept = dept;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    @NonNull
    @Override
    public String toString() {
        return this.nombre;
    }
}
