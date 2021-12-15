package com.example.mannyfoods;

import androidx.annotation.NonNull;

public class Subdepartamento {
    private int sdept;
    private String nombre;

    public Subdepartamento(int sdept, String nombre) {
        this.sdept = sdept;
        this.nombre = nombre;
    }

    public int getSdept() {
        return sdept;
    }

    public String getNombre() {
        return nombre;
    }

    public void setSdept(int sdept) {
        this.sdept = sdept;
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
